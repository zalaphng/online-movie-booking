<?php
session_start();
require_once("config/db_connect.php");

if (isset($_POST['check_username'])) {
    $check_username = $_POST['check_username'];
    $check_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$check_username'");
    if (mysqli_num_rows($check_query) > 0) {
        echo "1";
    } else {
        echo "0";
    }
    exit();
}

?>

<!DOCTYPE html>
<!-- Designed by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="assets/js/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="container">

    <?php

    function uploadFile($file)
    {
        $filename = $file['name'];
        $location = 'uploads/' . $filename;

        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $image_ext = array('jpg', 'png', 'jpeg', 'gif');

        if (in_array($file_extension, $image_ext)) {
            if (move_uploaded_file($file['tmp_name'], $location)) {
                return $location;
            }
        }

        return false;
    }

    function getNewUserId($conn){
        $result = mysqli_query($conn, "SELECT MAX(id) AS max_userid FROM users");
        $row = mysqli_fetch_assoc($result);
        $max_userid = $row['max_userid'];
        $new_userid = $max_userid + 1;
        return $new_userid;
    }

    if (isset($_POST['submit'])) {

        $new_userid = getNewUserId($conn);


        $username = $_POST['username'];
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];

        $uploadedLocation = uploadFile($_FILES['image']);

        if ($uploadedLocation) {

            $file_extension = pathinfo($uploadedLocation, PATHINFO_EXTENSION);
            $new_filename = "avatar-uid-$new_userid.$file_extension";
            $new_location = 'uploads/' . $new_filename;
            rename($uploadedLocation, $new_location);


            try {
                $insert_record = mysqli_query($conn, "INSERT INTO users (`username`, `name`, `email`, `password`, `phone`, `birthday`, `image`) 
                VALUES ('$username', '$name', '$email', '$password', '$phone', '$birthday', '$new_filename')");

                if ($insert_record) {
                    header("Location: login.php?msg=Registration successful! Please log in.");
                    exit();
                }
            } catch (Exception $e) {
                $msg = "Đăng ký không thành công";
            }


        } else {
            $msg = "Định dạng file không hợp lệ";
        }
    }

    ?>

    <center><a href="./index.php"><img src="assets/images/logo.png" alt="" style="margin: 30px 0; width: 35%;"></a>
    </center>
    <div class="title">Registration</div>
    <div class="content">
        <form id="form" action="" method="post" enctype="multipart/form-data">
            <div class="php-message">
                <p class="text-danger"><?php echo isset($msg) ? $msg : ''; ?></p>
                <p class="text-danger" id="username-message"></p>
            </div>
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your name" value="<?php if(isset($username)) echo $username ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" id="username" name="username" placeholder="Enter your name" value="<?php if(isset($name)) echo $name ?>" required
                           pattern="[a-zA-Z0-9]+" onblur="checkUsername()">
<!--                    <p class="text-danger" id="username-message"></p>-->
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="email" id="email" name="email" placeholder="Enter your Email" value="<?php if(isset($email)) echo $email ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input type="tel" id="number" name="phone" placeholder="Enter your Phone Number" value="<?php if(isset($phone)) echo $phone ?>" required
                           pattern="[0-9]{10}">
                </div>
                <div class="input-box">
                    <span class="details">Birthday</span>
                    <input type="date" id="birthday" name="birthday" value="<?php if(isset($birthday)) echo $birthday ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                           pattern=".{3,10}">
                </div>
                <div class="input-box">
                    <span class="details">Image uploaded (Option)</span>
                    <input type="file" id="image" name="image" style="padding-top: 10px;">
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your password" required
                           pattern=".{3,10}">
                </div>
            </div>
            <div class="button">
                <input type="submit" value="Register" id="submit" name="submit">
            </div>
        </form>
    </div>

    <script>
        function checkUsername() {
            var username = $("#username").val();
            $.ajax({
                type: 'POST',
                url: 'register.php',
                data: {check_username: username},
                success: function (response) {
                    if (response.trim() === "1") {
                        $("#username-message").text("Username already exists!");
                        $("#submit").prop("disabled", true);
                    } else {
                        $("#username-message").text("");
                        $("#submit").prop("disabled", false);
                    }
                }
            });
        }
    </script>

</div>
</body>
</html>

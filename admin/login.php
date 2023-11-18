<html>
<head>
    <title> Login Page</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/site.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<?php
    require_once('../config/db_connect.php');
    session_start();

    if(isset($_POST['login'])) {
        if (isset($_POST['username']) || isset($_POST['password'])) {
            $uname = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $password_query = "SELECT password FROM admin WHERE username='" . $uname . "'";


            try {

                $result = mysqli_query($conn, $password_query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $password_verify = $row['password'];

                    if (password_verify($password, $password_verify)) {
                        $_SESSION['admin'] = $uname;
                        header("Location: index.php");
                        exit();
                    } else {
                        $msg = "Invalid Username or password.";
                    }
                } else {
                    $msg = "Invalid Username or password.";
                }
            } catch (Exception $e) {
                $msg = "An error occurred: " . $e->getMessage();
            }
        }
    }



?>
<div>
    <div class="parent-container mx-auto vh-100">

        <table width="100%" height="100%">
            <tr>
                <td align="center" valign="middle">
                    <div class="loginholder">
                        <form action="" method="post">
                            <table style="background-color:white;" class="table-condensed">
                                <tr>
                                    <a href="./index.php"><img src="../assets/images/logo.png" alt="" width="180px"></a>
                                </tr>
                                <tr>
                                    <td>
                                        <hr style="background-color:blue;height:1px;margin:0px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Username:</b></td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="inputbox" id="username" name="username" required/>
                                        <br>
                                </tr>
                                <tr>
                                    <td><b>Password:</b></td>
                                </tr>
                                <tr>
                                    <td><input type="password" class="inputbox" id="password" name="password" required/>
                                        <br>
                                        <p id="msg" class="mt-5 text-danger text-center"><?php if (isset($msg)) echo $msg; ?></p>
                                    </td>

                                </tr>
                                <tr>
                                    <td align="center">
                                        <input type="submit" class="btn-normal" name="login" id="login" value="LOGIN">
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center"></td>
                                </tr>

                            </table>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <a href="./index.php"><img src="../assets/images/logo.png" alt="" width="180px"></a>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required/>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required/>
                            <p id="msg" class="mt-3 text-danger"><?php if (isset($msg)) echo $msg; ?></p>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" id="login">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
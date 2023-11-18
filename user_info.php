<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Information user</title>

    <?php
    include_once('templates/styles.php')
    ?>
</head>
<body>

<?php

include("templates/header.php");

?>


<?php
    if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $query = "SELECT username, `name`, email, phone, birthday, image, gender FROM users WHERE id = $user_id";

    try {
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
    } catch (Exception $e) {
        $msg = "An error occurred: " . $e->getMessage();
        $error = 1;
    }


?>


<div class="container-fluid mt-5 mb-5 px-lg-5">
    <div class="row">
        <div class="col-lg-11 offset-1">
            <h2 class="part-line ml-lg-4">User Information</h2>
        </div>
    </div>

    <?php
    if (isset($_GET['msg']) && (isset($_GET['error']))) {
          ?>

        <div class="row px-1">
            <div class="col-lg-10 offset-1">
                <?php
                include_once ('templates/error.php')
                ?>
            </div>
        </div>

        <?php
    }
    ?>

    <div class="row my-5">
        <div class="offset-xl-1 col-xl-3 px-xl-4">
            <div class="card border-0 shadow-lg mb-4 px-xl-4">
                <img src="uploads/<?php echo $user['image']; ?>" alt="User Image"
                     class="card-img-top rounded-circle mx-auto d-block mt-3"
                     style="width: 250px; height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h3 class="card-title mt-1"><?php echo $user['name']; ?></h3>
                    <p class="card-text text-muted text-uppercase">@<?php echo $user['username']; ?></p>
                    <ul class="list-unstyled text-left">
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Hotline:</strong> 1900 ...</span> <i
                                    class="fa fa-angle-right"></i></li>
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Email:</strong> support@azircinema.com</span>
                            <i class="fa fa-angle-right"></i></li>
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Q&A</strong></span> <i
                                    class="fa fa-angle-right"></i></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-11">
                    <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4 rounded"
                         style="border-bottom: 1px solid rgb(160 163 167);">
                        <ul class="navbar-nav w-100 d-flex justify-content-between font-weight-bold text-capitalize">
                            <li class="nav-item">
                                <a class="nav-link" href="./booking_history.php">Booking History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Personal Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gifts</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-11">
                    <div class="card border-0 shadow-lg mb-4 rounded-0">
                        <div class="card-body">
                            <form action="update_user_info.php" method="post" id="updateForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name">Họ và tên:</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="<?php if (isset($user)) echo $user['name']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="birthday">Ngày sinh:</label>
                                        <input type="date" class="form-control" id="birthday" name="birthday"
                                               value="<?php if (isset($user)) echo $user['birthday']; ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?php if (isset($user)) echo $user['email']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Số điện thoại:</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                               value="<?php if (isset($user)) echo $user['phone']; ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Gender:</label>
                                        <div class="form-group my-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="male"
                                                       value="Male" <?php if (isset($user)) echo ($user['gender'] == 0) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="male">Nam</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="female"
                                                       value="Female" <?php if (isset($user)) echo ($user['gender'] == 1) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="female">Nữ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password">Mật khẩu:</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="********" disabled>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        data-toggle="modal" data-target="#changePasswordModal">Thay đổi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary float-right" id="updateBtn">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Thay đổi mật khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="change_password.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currentPassword">Mật khẩu cũ:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" style="margin-top: .25rem;">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('updateBtn').addEventListener('click', function() {
        let confirmUpdate = confirm("Bạn có chắc chắn muốn cập nhật thông tin?");

        if (confirmUpdate) {
            document.getElementById('updateForm').submit();
        }
    });

</script>

<?php
include("templates/footer.php");
?>

</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Manageuser Page</title>


    <?php session_start();
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">

            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Users</h2>
                </div>
                <div class="col-2">
                    <a href="#" data-toggle="modal" data-target="#add_users_modal"
                       class="btn btn-primary btn-sm">Thêm</a>
                </div>
            </div>

            <?php
            include_once ('templates/error.php');
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");
                    $result = mysqli_query($conn, "SELECT * FROM users");

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id']; ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo ($row['gender'] == 0) ? "Nam" : "Nữ"; ?></td>
                                <!--              <td><img src="../upload/-->
                                <?php //echo $row['image']; ?><!--" alt="" class="resize"></td>-->
                                <td><?php echo $row['birthday'] ?></td>
                                <td><?php echo $row['image'] ?></td>
                                <td>
                                    <button data-toggle="modal" type="button"
                                            data-target="#edit_users_modal<?php echo $id; ?>"
                                            class="btn btn-primary btn-sm">Chỉnh sửa
                                    </button>
                                    <button data-toggle="modal" type="button"
                                            data-target="#change_password<?php echo $id; ?>"
                                            class="btn btn-success btn-sm">Change Password
                                    </button>
                                    <button data-toggle="modal" type="button"
                                            data-target="#delete_users_modal<?php echo $id; ?>"
                                            class="btn btn-danger btn-sm">Xóa
                                    </button>
                                </td>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete_users_modal<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Movie</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="insert_user" action="exec/users.php" method="post">
                                                <h4> Are you sure want to delete this ID "<?php echo $row['id']; ?>" ?</h4>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-user-btn" id="delete-user-btn"
                                                       value="OK" class="btn btn-primary">
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="edit_users_modal<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit users</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="edit_user" action="exec/users.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Username</label>
                                                            <input class="form-control" name="edit-username"
                                                                   id="edit-username" placeholder="user name" value="<?php echo $row['username']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input class="form-control" name="edit-name"
                                                                   id="edit-name" placeholder="user name" value="<?php echo $row['name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control" name="edit-email"
                                                                   id="edit-email" value="<?php echo $row['email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group form-inline">
                                                            <label>Gender</label>
                                                            <div class="form-check mx-2">
                                                                <input class="form-check-input" type="radio"
                                                                       name="edit-gender" id="male" value="0" <?php echo ($row['gender'] == 0) ? "checked" : "" ?>>
                                                                <label class="form-check-label" for="male">
                                                                    Male
                                                                </label>
                                                            </div>
                                                            <div class="form-check mx-2">
                                                                <input class="form-check-input" type="radio"
                                                                       name="edit-gender" id="female" value="1" <?php echo ($row['gender'] == 1) ? "checked" : "" ?>>
                                                                <label class="form-check-label" for="female">
                                                                    Female
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Ngày sinh</label>
                                                            <input type="date" name="edit-birthday" id="edit-birthday" class="form-control"
                                                                   placeholder="Enter City Name" value="<?php echo $row['birthday'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Số điện thoại</label>
                                                            <input type="number" class="form-control" name="edit-phone"
                                                                   id="edit-phone" value="<?php echo $row['phone']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Hình ảnh</label>
                                                            <img src="../uploads/<?php echo $row['image']; ?>"
                                                                 width="10%">
                                                            <input type="file" name="edit-image" id="edit-image"
                                                                   class="form-control">
                                                            <input type="hidden" name="old_image"
                                                                   value="<?php echo $row['image']; ?>" id="old_image"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="hidden" name="e-id" value="<?php echo $row['id']; ?>">
                                                        <input type="submit" name="update-user-btn" id="update-user-btn"
                                                               value="update" class="btn btn-primary">
                                                    </div>
                                                </div>

                                            </form>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Change password -->

                            <div class="modal fade" id="change_password<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enter Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form name="myform" id="insert_movie" action="exec/users.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()" >
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Username</label>
                                                            <input class="form-control" name="username" id="username" placeholder="user name" value="<?php echo $row['username']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input type="text" name="new-password" id="new-password" class="form-control" placeholder="Enter Password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="hidden" name="ep-id" value="<?php echo $row['id'] ?>">
                                                        <input type="submit" name="change-password" class="btn btn-primary add-product" value="Add Product">
                                                    </div>
                                                </div>

                                            </form>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Change password -->

                            <?php

                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
    </div>


    <!-- Add User Modal start -->
    <div class="modal fade" id="add_users_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myform" id="insert_movie" action="exec/users.php" method="post"
                          enctype="multipart/form-data" onsubmit="return validateform()">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" name="username" id="username" placeholder="User Name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" name="name" id="name" placeholder="User Name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label> Email</label>
                                    <input class="form-control" name="email" id="email" placeholder=" Enter Email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group form-inline">
                                    <label>Gender</label>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="0"
                                               checked>
                                        <label class="form-check-label" for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                               value="1">
                                        <label class="form-check-label" for="female">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="number" class="form-control" name="phone" id="phone"
                                           placeholder="Mobile phone" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Ngày sinh</label>
                                    <input type="date" name="birthday" id="birthday" class="form-control"
                                           placeholder="Enter City Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" name="password" id="Password" class="form-control"
                                           placeholder="Enter Password" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Hình ảnh</label>
                                    <input type="file" name="image" value="image" id="image" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="add_product" value="1">
                            <div class="col-12">
                                <input type="submit" name="add-user-btn" class="btn btn-primary add-product"
                                       value="Add Product">
                            </div>
                        </div>

                    </form>
                    <div id="preview"></div>
                </div>
            </div>
        </div>
    </div>


<?php include_once("./templates/footer.php"); ?>
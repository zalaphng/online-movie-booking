<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Showtimes Page</title>

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
                    <h2>Theaters</h2>
                </div>
                <div class="col-2">
                    <button type="button" data-toggle="modal" data-target="#add_theater" class="btn btn-primary btn-sm">Add Theater</button>
                </div>
            </div>

            <?php
                include_once("templates/error.php");
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Theater Name</th>
                        <th>Theater Address</th>
                        <th>Theater Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");
                    $query = "SELECT * FROM theaters";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['theater_name']; ?></td>
                                <td><?php echo $row['theater_address']; ?></td>
                                <td><?php echo $row['theater_phone']; ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#update_show<?php echo $row['id']; ?>"
                                            class="btn btn-primary btn-sm">Edit Show
                                    </button>
                                    <button data-toggle="modal" data-target="#delete_show<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm">Delete Show
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="update_show<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Show</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="update_theater" action="exec/theaters.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Theater Name</label>
                                                            <input class="form-control" name="edit-theater-name" id="edit-theater-name"
                                                                   placeholder="Enter Theater Name" value="<?php echo $row['theater_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Theater Address</label>
                                                            <input class="form-control" name="edit-theater-address" id="edit-theater-address"
                                                                   placeholder="Enter Theater Address" value="<?php echo $row['theater_address']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Theater Phone</label>
                                                            <input type="text" pattern="^(0|\+84)[0-9]{9,10}$" class="form-control" name="edit-theater-phone" id="edit-theater-phone"
                                                                   placeholder="Enter Theater Phone" value="<?php echo $row['theater_phone']; ?>">
                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <input type="submit" name="edit-theater-btn" id="edit-theater-btn" value="submit" class="btn btn-primary">
                                                    </div>
                                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="e-id">
                                                </div>

                                            </form>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete_show<?php echo $row['id']; ?>" tabindex="-1"
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
                                            <form id="delete_theater" action="exec/theaters.php" method="post">
                                                <h4> Are you sure want to delete Cinema number "<?php echo $row['id']; ?>" ? </h4>
                                                <input type="hidden" name="delete-theater-id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-theater-btn" id="delete-theater-btn" value="OK"
                                                       class="btn btn-primary">
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
    </div>


    <!-- Add show Modal start -->
    <div class="modal fade" id="add_theater" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Theater</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="" id="add_theater" action="exec/theaters.php" method="post"
                          enctype="multipart/form-data" onsubmit="">

                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Name</label>
                                <input class="form-control" name="theater-name" id="add_theater_name"
                                       placeholder="Enter Theater Name" value="<?php if(isset($_POST['theater-name'])) echo $_POST['theater-name']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Address</label>
                                <input class="form-control" name="theater-address" id="add_theater_address"
                                       placeholder="Enter Theater Address" value="<?php if(isset($_POST['theater-address'])) echo $_POST['theater-address']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Phone</label>
                                <input type="text" pattern="^(0|\+84)[0-9]{9,10}$" class="form-control" name="theater-phone" id="add_theater_phone"
                                       placeholder="Enter Theater Phone" value="<?php if(isset($_POST['theater-phone'])) echo $_POST['theater-phone']; ?>" required>
                            </div>
                        </div>


                        <div class="col-12">
                            <input type="submit" name="add-theater-btn" id="add-theater-btn" value="Add Theater" class="btn btn-primary">
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Add show Modal end -->


    <?php include_once("./templates/footer.php"); ?>



    </script>
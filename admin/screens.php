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
                    <h2>Screen</h2>
                </div>
                <div class="col-2">
                    <button type="button" data-toggle="modal" data-target="#add_show" class="btn btn-primary btn-sm">Add Screen</button>
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
                        <th>Screen Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");


                    $query = "SELECT
                                screens.*,
                                theaters.theater_name 
                            FROM
                                screens
                                INNER JOIN theaters ON screens.theater_id = theaters.id";
                    $result = mysqli_query($conn, $query);


                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {

                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['theater_name']; ?></td>
                                <td><?php echo $row['screen_name']; ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#update_screen<?php echo $row['id']; ?>"
                                            class="btn btn-primary btn-sm">Edit Screen
                                    </button>
                                    <button data-toggle="modal" data-target="#delete_screen<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm">Delete Screen
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="update_screen<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Theater</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="insert_movie" action="exec/screens.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Theater Name</label>
                                                            <select class="form-control category_list"
                                                                    name="edit-theater-id">
                                                                <option value="null">Select Theater Name</option>
                                                                <?php
                                                                $resultTheaters = mysqli_query($conn, "SELECT * FROM theaters");

                                                                if (mysqli_num_rows($resultTheaters) > 0) {
                                                                    while ($rowTheaters = mysqli_fetch_array($resultTheaters)) {
                                                                        if ($rowTheaters['id'] == $row['theater_id']) {
                                                                            ?>
                                                                            <option value="<?php echo $rowTheaters['id']; ?>"
                                                                                    selected><?php echo $rowTheaters['theater_name']; ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $rowTheaters['id']; ?>"><?php echo $rowTheaters['theater_name']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Screen Name</label>
                                                            <input type="text" class="form-control"
                                                                   name="edit-screen-name" id="edit-screen-name"
                                                                   placeholder="Enter Theater Name"
                                                                   value="<?php echo $row['screen_name']; ?>">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="e_id" value="<?php echo $row['id']; ?>">

                                                    <div class="col-12">
                                                        <input type="submit" name="update-screen-btn"
                                                               id="update-screen-btn"
                                                               value="update" class="btn btn-primary">
                                                    </div>
                                                </div>

                                            </form>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete_screen<?php echo $row['id']; ?>" tabindex="-1"
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
                                            <form id="insert_movie" action="exec/screens.php" method="post">
                                                <h4> Are you want to delete ID "<?php echo $row['id']; ?>" ?</h4>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-screen-btn" id="delete-screen-btn"
                                                       value="OK"
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
    <div class="modal fade" id="add_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Screen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="" id="insert_movie" action="exec/screens.php" method="post"
                          enctype="multipart/form-data" onsubmit="">

                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Name</label>
                                <select class="form-control category_list" name="theater-id">
                                    <option value="null">Select Theater Name</option>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM theaters");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['theater_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Screen Name</label>
                                <input class="form-control" name="screen-name" id="screen-name"
                                       placeholder="Enter Screen Name" required>
                            </div>
                        </div>


                        <input type="hidden" name="add_product" value="1">
                        <div class="col-12">

                            <input type="submit" name="add-screen-btn" id="add-screen-btn" value="Add Screen" class="btn btn-primary">
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Add show Modal end -->


    <?php include_once("./templates/footer.php"); ?>


    </script>
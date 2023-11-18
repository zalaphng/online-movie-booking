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
                    <h2>Showtime</h2>
                </div>
                <div class="col-2">
                    <button type="button" data-toggle="modal" data-target="#add_showtimes"
                            class="btn btn-primary btn-sm">Add
                        Show
                    </button>
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
                        <th>Movie Name</th>
                        <th>Theater Name</th>
                        <th>Screen Number</th>
                        <th>Showtime</th>
                        <th>Price</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");
                    $query = "SELECT
                        showtimes.id,
                        showtimes.showtime,
                        screens.screen_name, 
                        theaters.theater_name,
                        movies.id as movie_id,
                        theaters.id as theater_id,
                        screens.id as screen_id,
                        movies.title,
                        showtimes.price
                    FROM
                        showtimes
                        INNER JOIN
                        movies
                        ON 
                            showtimes.movie_id = movies.id
                        INNER JOIN
                        theaters
                        ON 
                            showtimes.theater_id = theaters.id
                        INNER JOIN
                        screens
                        ON 
                            showtimes.screen_id = screens.id";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['theater_name']; ?></td>
                                <td><?php echo $row['screen_name']; ?></td>
                                <td><?php echo $row['showtime']; ?></td>
                                <td><?php echo $row['price']; ?></td>
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
                                            <form id="update_show" action="exec/showtimes.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Movie Name</label>
                                                            <select class="form-control category_list"
                                                                    name="edit-movie-id">
                                                                <option value="null">Select Movie Name</option>
                                                                <?php
                                                                $resultEditMovies = mysqli_query($conn, "SELECT id, title FROM movies");

                                                                if (mysqli_num_rows($resultEditMovies) > 0) {
                                                                    while ($rowEditMovies = mysqli_fetch_array($resultEditMovies)) {
                                                                        if ($rowEditMovies['id'] == $row['movie_id']) {
                                                                            ?>
                                                                            <option value="<?php echo $rowEditMovies['id']; ?>"
                                                                                    selected><?php echo $rowEditMovies['title']; ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $rowEditMovies['id']; ?>"><?php echo $rowEditMovies['title']; ?></option>
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
                                                            <label>Theater Name</label>
                                                            <select class="form-control category_list"
                                                                    name="edit-theater-id"
                                                                    id="edit-theater-select">
                                                                <option value="null">Select Theater Name</option>
                                                                <?php
                                                                $resultEditTheaters = mysqli_query($conn, "SELECT id, theater_name FROM theaters");

                                                                if (mysqli_num_rows($resultEditTheaters) > 0) {
                                                                    while ($rowEditTheaters = mysqli_fetch_array($resultEditTheaters)) {
                                                                        if ($rowEditTheaters['id'] == $row['theater_id']) {
                                                                            ?>
                                                                            <option value="<?php echo $rowEditTheaters['id']; ?>"
                                                                                    selected><?php echo $rowEditTheaters['theater_name']; ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $rowEditTheaters['id']; ?>"><?php echo $rowEditTheaters['theater_name']; ?></option>
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
                                                            <label>Screen Number</label>
                                                            <select class="form-control category_list"
                                                                    name="edit-screen-id"
                                                                    id="edit-screen-select">
                                                                <option value="null">Select Screen Number</option>

                                                                <?php
                                                                $theater_id = $row['theater_id'];
                                                                $resultEditScreens = mysqli_query($conn, "SELECT id, screen_name FROM screens WHERE theater_id = $theater_id");

                                                                if (mysqli_num_rows($resultEditScreens) > 0) {
                                                                    while ($rowEditScreens = mysqli_fetch_array($resultEditScreens)) {
                                                                        if ($rowEditScreens['id'] == $row['screen_id']) {
                                                                        ?>
                                                                        <option value="<?php echo $rowEditScreens['id']; ?>" selected><?php echo $rowEditScreens['screen_name']; ?></option>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <option value="<?php echo $rowEditScreens['id']; ?>"><?php echo $rowEditScreens['screen_name']; ?></option>
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
                                                            <label>Showtime</label>
                                                            <input type="datetime-local" class="form-control"
                                                                   name="edit-showtime" id="edit-showtime"
                                                                   placeholder="Enter Theater Name"
                                                                   value="<?php echo $row['showtime']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Price</label>
                                                            <input type="number" class="form-control"
                                                                   name="edit-showtime-price"
                                                                   id="edit-showtime-price"
                                                                   placeholder="Enter Price"
                                                                   value="<?php echo $row['price']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <input type="submit" name="edit-showtime-btn"
                                                               id="edit-showtime-btn"
                                                               value="update" class="btn btn-primary">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="e-id" value="<?php echo $row['id']; ?>">
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
                                            <form id="insert_movie" action="exec/showtimes.php" method="post">
                                                <h4> Are you want to delete this ID "<?php echo $row['id']; ?>" ? </h4>
                                                <input type="hidden" name="delete-showtime-id"
                                                       value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-showtime-btn" id="delete-showtime-btn"
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
    <div class="modal fade" id="add_showtimes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Showtime</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="" id="add_showtimes" action="exec/showtimes.php" method="post"
                          enctype="multipart/form-data" onsubmit="">

                        <div class="col-12">
                            <div class="form-group">
                                <label>Movie Name</label>
                                <select class="form-control category_list" name="showtime-movie-id">
                                    <option value="null">Select Movie Name</option>
                                    <?php
                                    $resultMovies = mysqli_query($conn, "SELECT id, title FROM movies");

                                    if (mysqli_num_rows($resultMovies) > 0) {
                                        while ($rowMovies = mysqli_fetch_array($resultMovies)) {
                                            ?>
                                            <option value="<?php echo $rowMovies['id']; ?>"><?php echo $rowMovies['title']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Name</label>
                                <select class="form-control category_list" name="showtime-theater-id"
                                        id="theater-select">
                                    <option value="null">Select Theater Name</option>
                                    <?php
                                    $resultTheaters = mysqli_query($conn, "SELECT id, theater_name FROM theaters");

                                    if (mysqli_num_rows($resultTheaters) > 0) {
                                        while ($rowTheaters = mysqli_fetch_array($resultTheaters)) {
                                            ?>
                                            <option value="<?php echo $rowTheaters['id']; ?>"><?php echo $rowTheaters['theater_name']; ?></option>
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
                                <select class="form-control category_list" name="showtime-screen-id" id="screen-select">
                                    <option value="null">Select Screen Name</option>
                                    <!--                                    --><?php
                                    //                                    $resultScreens = mysqli_query($conn, "SELECT id, screen_name FROM screens");
                                    //
                                    //                                    if (mysqli_num_rows($resultScreens) > 0) {
                                    //                                        while ($rowScreens = mysqli_fetch_array($resultScreens)) {
                                    //                                            ?>
                                    <!--                                            <option value="-->
                                    <?php //echo $rowScreens['id']; ?><!--">-->
                                    <?php //echo $rowScreens['screen_name']; ?><!--</option>-->
                                    <!--                                            --><?php
                                    //                                        }
                                    //                                    }
                                    //                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Showtime</label>
                                <input type="datetime-local" class="form-control" name="showtime-showtime"
                                       id="edit-screen-name"
                                       placeholder="Enter Showtime">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="showtime-price"
                                       id="showtime-price"
                                       placeholder="Enter Price" value="<?php echo $row['price']; ?>" required>
                            </div>
                        </div>


                        <input type="hidden" name="add_product" value="1">
                        <div class="col-12">

                            <input type="submit" name="add-showtime-btn" id="add-showtime-btn" value="Add Showtime" class="btn btn-primary">
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Add show Modal end -->

    <script type="text/javascript" src="js/showtimes.js"></script>
    <?php include_once("./templates/footer.php"); ?>


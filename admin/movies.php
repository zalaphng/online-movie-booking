<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Movies Page</title>

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
                    <h2>Movies</h2>
                </div>
                <div class="col-2">
                    <button data-toggle="modal" data-target="#add_movie_modal" class="btn btn-primary btn-sm">
                        Add Movie
                    </button>
                </div>
            </div>

            <?php
            include_once('templates/error.php');
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Director</th>
                        <th>Release Date</th>
                        <th>language</th>
                        <th>Show</th>
<!--                        <th>Trailer</th>-->
<!--                        <th>Description</th>-->
                        <th>Image</th>
                        <th>Status</th>
                        <th>Running</th>
                        <th>Edit</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tbody id="product_list">
                    <?php
                    require_once("../config/db_connect.php");
                    $query = "SELECT
                        movies.*,
                        genre.genre_name 
                    FROM
                        movies
                    INNER JOIN genre ON movies.genre_id = genre.id";

                    $result = $conn->query($query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id']; ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['director']; ?></td>
                                <td><?php echo $row['release_date']; ?></td>
                                <td><?php echo $row['genre_name']; ?></td>
                                <td><?php echo $row['language']; ?></td>
<!--                                <td>--><?php //echo $row['trailer_link']; ?><!--</td>-->
<!--                                <td>--><?php //echo $row['description']; ?><!--</td>-->
                                <td><img src="../uploads/<?php echo $row['image']; ?>" alt="" class="resize" width="70px;" style="object-fit: cover"></td>
                                <td><?php echo ($row['status'] == 1) ? "Active" : "Inactive" ?></td>
                                <td><?php echo ($row['running'] == 1) ? "Running" : "Upcomming" ?></td>
                                <!--                                <td><img src="../../uploads/-->
                                <?php //echo $row['image']; ?><!--" alt="" class="resize"></td>-->
                                <td>
                                    <button data-toggle="modal" type="button"
                                            data-target="#edit_movie_modal<?php echo $id; ?>"
                                            class="btn btn-primary btn-sm">Edit Movie
                                    </button>
                                </td>
                                <td>
                                    <button data-toggle="modal" type="button"
                                            data-target="#delete_movie_modal<?php echo $id; ?>"
                                            class="btn btn-danger btn-sm">Delete Movie
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Movie Modal start -->

                            <div class="modal fade" id="edit_movie_modal<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="insert_movie" action="exec/movies.php" method="post"
                                                  enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="hidden" name="e_id"
                                                                   value="<?php echo $row['id']; ?>">
                                                            <input class="form-control" name="edit-movie-title"
                                                                   id="edit-movie-title"
                                                                   value="<?php echo $row['title']; ?>">
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Director Name</label>
                                                            <input class="form-control" name="edit-movie-director"
                                                                   id="edit-movie-director"
                                                                   value="<?php echo $row['director']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Release Date</label>
                                                            <input type="date" class="form-control"
                                                                   name="edit-movie-release-date"
                                                                   id="edit-movie-release-date"
                                                                   value="<?php echo $row['release_date']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Genre</label>
                                                            <select class="form-control" name="edit-movie-genre-id"
                                                                    id="edit-movie-genre-id">
                                                                <?php
                                                                $queryGenre = "SELECT id, genre_name FROM genre";
                                                                $resultGenre = $conn->query($queryGenre);
                                                                while ($rowGenre = mysqli_fetch_assoc($resultGenre)) {
                                                                    echo '<option value="' . $rowGenre['id'] . '">' . $rowGenre['genre_name'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Language</label>
                                                            <input type="text" name="edit-movie-language"
                                                                   id="edit-movie-language"
                                                                   class="form-control"
                                                                   value="<?php echo $row['language']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Trailer Link</label>
                                                            <input type="text" name="edit-movie-trailer-link"
                                                                   id="edit-movie-trailer-link"
                                                                   class="form-control"
                                                                   value="<?php echo $row['trailer_link']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea type="text" name="edit-movie-description"
                                                                      id="edit-movie-description"
                                                                      class="form-control"><?php echo $row['description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="form-control" name="edit-movie-status"
                                                                    id="edit-movie-status">
                                                                <option value="1" <?php echo ($row['status'] == 1) ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?php echo ($row['status'] == 0) ? "selected" : "" ?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Running</label>
                                                            <select class="form-control" name="edit-movie-running"
                                                                    id="edit-movie-running">
                                                                <option value="1" <?php echo ($row['running'] == 1) ? "selected" : "" ?>>Running</option>
                                                                <option value="0" <?php echo ($row['running'] == 0) ? "selected" : "" ?>>Upcoming</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Images</label>
                                                            <br>
                                                            <img src="../../uploads/<?php echo $row['image']; ?>"
                                                                 width="10%">
                                                            <input type="file" name="edit-movie-image"
                                                                   id="edit-movie-image"
                                                                   class="form-control">
                                                            <input type="hidden" name="old_image"
                                                                   value="<?php echo $row['image']; ?>" id="old_image"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="edit-movie-id"
                                                           value="<?php echo $row['id']; ?>">
                                                    <div class="col-12">

                                                        <input type="submit" name="edit-movie-btn" id="edit-movie-btn"
                                                               value="update" class="btn btn-primary">
                                                    </div>
                                                </div>

                                            </form>
                                            <div id="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Movie Modal End -->

                            <!-- Delete Movie Modal Start -->

                            <div class="modal fade" id="delete_movie_modal<?php echo $row['id']; ?>" tabindex="-1"
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
                                            <form id="insert_movie" action="exec/movies.php" method="post">
                                                <h4> Are you sure want to delete this ID film "<?php echo $row['id']; ?>" ?</h4>
                                                <input type="hidden" name="delete-movie-id"
                                                       value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-movie-btn" id="delete-movie-btn"
                                                       value="OK"
                                                       class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Movie Modal End -->

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

    <!-- Add Movie Modal start -->
    <div class="modal fade" id="add_movie_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Movie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="" id="insert_movie" action="exec/movies.php" method="post"
                          enctype="multipart/form-data" onsubmit="">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" name="movie-title" id="movie-title"
                                           placeholder="Movie Name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Director</label>
                                    <input class="form-control" name="movie-director" id="movie-director"
                                           placeholder="Director Name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Release Date</label>
                                    <input class="form-control" name="movie-release-date" id="movie-release-date"
                                           placeholder="director name" type="date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="genre">Genre</label>
                                    <select class="form-control" name="movie-genre-id" id="movie-genre-id">
                                        <?php
                                        $query = "SELECT id, genre_name FROM genre";
                                        $result = $conn->query($query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['id'] . '">' . $row['genre_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Language</label>
                                    <input type="text" name="movie-language" id="movie-language" class="form-control"
                                           placeholder="Enter Language" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Trailer Link</label>
                                    <input type="text" name="movie-trailer-link" id="movie-trailer-link"
                                           class="form-control"
                                           placeholder="Enter Trailer" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" name="movie-description" id="movie-description"
                                              class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="movie-status" id="movie-status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Running</label>
                                    <select class="form-control" name="movie-running" id="movie-running">
                                        <option value="0">Running</option>
                                        <option value="1">Upcoming</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <input type="file" name="movie-image" id="movie-image" value="img"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-12">

                                <input type="submit" name="add-movie-btn" id="add-movie-btn" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <div id="preview"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Movie Modal end -->

    <?php include_once("./templates/footer.php"); ?>

    </script>


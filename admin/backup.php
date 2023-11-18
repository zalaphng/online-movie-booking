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
                <form name="" id="insert_movie" action="insert_data.php" method="post"
                      enctype="multipart/form-data" onsubmit="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Movie Name</label>
                                <input class="form-control" name="movie_name" id="movie_name"
                                       placeholder="movie name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>director Name</label>
                                <input class="form-control" name="director_name" id="director_name"
                                       placeholder="director name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Release Date</label>
                                <input class="form-control" name="release_date" id="release_date"
                                       placeholder="director name">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>category</label>
                                <input class="form-control" name="category" id="category"
                                       placeholder="Enter category">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>language</label>
                                <input type="text" name="language" id="language" class="form-control"
                                       placeholder="Enter Language">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tailer</label>
                                <input type="text" name="tailer" id="tailer" class="form-control"
                                       placeholder="Enter Tailer">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Action</label>
                                <select class="form-control" name="action" id="action">
                                    <option value="">Action</option>
                                    <option value="upcoming">upcoming</option>
                                    <option value="running">running</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>description</label>
                                <textarea type="text" name="description" id="description"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Uplode Poster</label>
                                <input type="file" name="img" value="img" id="img" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="add_product" value="1">
                        <div class="col-12">

                            <input type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
                <div id="preview"></div>
            </div>
        </div>
    </div>
</div>


<div class="col-12">
    <div class="form-group">
        <label>Time</label>
        <?php
        $seats = explode(",", $row['show']);
        $sql = mysqli_query($conn, "SELECT * FROM showtimes");
        if (mysqli_num_rows($sql) > 0) {
            while ($fatch = mysqli_fetch_array($sql)) {
                $checked = $fatch['show'];
                ?>
                <font size="2"> <?php echo $fatch['show']; ?></font>
                <input type="checkbox" name="show[]" id="show"
                       value="<?php echo $fatch['show']; ?>" <?php
                if (in_array($checked, $seats)) {
                    echo "checked";
                }
                ?>>

                <?php
            }
        }
        ?>
    </div>
</div>
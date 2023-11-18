<?php

session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['add-showtime-btn'])) {
    $movie_id = mysqli_real_escape_string($conn, $_POST['showtime-movie-id']);
    $theater_id = mysqli_real_escape_string($conn, $_POST['showtime-theater-id']);
    $screen_id = mysqli_real_escape_string($conn, $_POST['showtime-screen-id']);
    $showtime = mysqli_real_escape_string($conn, $_POST['showtime-showtime']);
    $price = mysqli_real_escape_string($conn, $_POST['showtime-price']);

    $current_date = date("Y-m-d H:i:s");


    if (!empty($movie_id) && !($movie_id == 'null')) {
        if (!empty($theater_id) && !($theater_id == 'null')) {
            if (!empty($screen_id) && !($screen_id == 'null')) {
                if (strtotime($showtime) > strtotime($current_date)) {
                    try {
                        $insert_record = mysqli_query($conn, "INSERT INTO `moviebooking`.`showtimes` 
        (`movie_id`, `theater_id`, `screen_id`, `showtime`, `price`) 
        VALUES ('$movie_id', '$theater_id', '$screen_id', '$showtime', '$price')");

                        if ($insert_record) {
                            $msg = "Insert successful";
                            $error = 0;
                        } else {
                            throw new Exception("Insert unsuccessful");
                        }
                    } catch (Exception $e) {
                        $msg = "An error occurred: " . $e->getMessage();
                        $error = 1;
                    }
                } else {
                    $msg = "Showtime must be greater than the current date.";
                    $error = 1;
                }
            } else {
                $msg = "Not selected screen name.";
                $error = 1;
            }
        } else {
            $msg = "Not selected theater name.";
            $error = 1;
        }
    } else {
        $msg = "Not selected movie name.";
        $error = 1;
    }

    header("Location: ../showtimes.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['edit-showtime-btn'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e-id']);
    $edit_movie_id = mysqli_real_escape_string($conn, $_POST['edit-movie-id']);
    $edit_theater_id = mysqli_real_escape_string($conn, $_POST['edit-theater-id']);
    $edit_screen_id = mysqli_real_escape_string($conn, $_POST['edit-screen-id']);
    $edit_showtime = mysqli_real_escape_string($conn, $_POST['edit-showtime']);
    $edit_price = mysqli_real_escape_string($conn, $_POST['edit-showtime-price']);

    $query = "UPDATE `moviebooking`.`showtimes` 
        SET `movie_id` = '$edit_movie_id', 
            `theater_id` = '$edit_theater_id', 
            `screen_id` = '$edit_screen_id', 
            `showtime` = '$edit_showtime', 
            `price` = '$edit_price' 
        WHERE `id` = '$e_id'";

    $current_date = date("Y-m-d H:i:s");

    if (!empty($edit_movie_id) && !($edit_movie_id == 'null')) {
        if (!empty($edit_theater_id) && !($edit_theater_id == 'null')) {
            if (!empty($edit_screen_id) && !($edit_screen_id == 'null')) {
                if (strtotime($edit_showtime) > strtotime($current_date)) {
                    try {
                        $update_record = mysqli_query($conn, $query);

                        if ($update_record) {
                            $msg = "Update successful";
                            $error = 0;
                        } else {
                            throw new Exception("Update unsuccessful");
                        }
                    } catch (Exception $e) {
                        $msg = "An error occurred: " . $e->getMessage();
                        $error = 1;
                    }
                } else {
                    $msg = "Showtime must be greater than the current date.";
                    $error = 1;
                }
            } else {
                $msg = "Not selected screen name.";
                $error = 1;
            }
        } else {
            $msg = "Not selected theater name.";
            $error = 1;
        }
    } else {
        $msg = "Not selected movie name.";
        $error = 1;
    }

    header("Location: ../showtimes.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['delete-showtime-btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete-showtime-id']);
    try {
        $delete_record = mysqli_query($conn, "DELETE FROM `moviebooking`.`showtimes` WHERE `id` = $id");

        if ($delete_record) {
            $msg = "Delete successful";
            $error = 0;
        } else {
            throw new Exception("Delete unsuccessful");
        }
    } catch (Exception $e) {
        $msg = "An error occurred: " . $e->getMessage();
        $error = 1;
    }

    header("Location: ../showtimes.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}



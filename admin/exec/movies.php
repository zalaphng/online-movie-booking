<?php


session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['add-movie-btn'])) {
    $description = mysqli_real_escape_string($conn, $_POST['movie-description']);
    $trailer_link = mysqli_real_escape_string($conn, $_POST['movie-trailer-link']);
    $language = mysqli_real_escape_string($conn, $_POST['movie-language']);
    $genre_id = mysqli_real_escape_string($conn, $_POST['movie-genre-id']);
    $release_date = mysqli_real_escape_string($conn, $_POST['movie-release-date']);
    $director = mysqli_real_escape_string($conn, $_POST['movie-director']);
    $title = mysqli_real_escape_string($conn, $_POST['movie-title']);
//    $image = mysqli_real_escape_string($conn, $_POST['movie-image']);
    $status = mysqli_real_escape_string($conn, $_POST['movie-status']);
    $running = mysqli_real_escape_string($conn, $_POST['movie-running']);

    $filename = $_FILES['movie-image']['name'];
    $location = '../../uploads/' . $filename;

    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $image = '';

    try {
        if (in_array($file_extension, $image_ext)) {
            if (move_uploaded_file($_FILES['movie-image']['tmp_name'], $location)) {
                $image = $_FILES['movie-image']['name'];
            } else {
                throw new Exception("Image upload failed");
            }
        } else {
            throw new Exception("Invalid image format");
        }

        $insert_record = mysqli_query($conn, "INSERT INTO `movies` 
            (`description`, `trailer_link`, `language`, `genre_id`, `release_date`, `director`, `title`, `image`, `status`, `running`) 
            VALUES ('$description', '$trailer_link', '$language', '$genre_id', '$release_date', '$director', '$title', '$image', '$status', '$running')");

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
    header("Location: ../movies.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['edit-movie-btn'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['edit-movie-id']);
    $edit_description = mysqli_real_escape_string($conn, $_POST['edit-movie-description']);
    $edit_trailer_link = mysqli_real_escape_string($conn, $_POST['edit-movie-trailer-link']);
    $edit_language = mysqli_real_escape_string($conn, $_POST['edit-movie-language']);
    $edit_genre_id = mysqli_real_escape_string($conn, $_POST['edit-movie-genre-id']);
    $edit_release_date = mysqli_real_escape_string($conn, $_POST['edit-movie-release-date']);
    $edit_director = mysqli_real_escape_string($conn, $_POST['edit-movie-director']);
    $edit_title = mysqli_real_escape_string($conn, $_POST['edit-movie-title']);
//    $edit_image = mysqli_real_escape_string($conn, $_POST['edit-movie-image']);
    $edit_status = mysqli_real_escape_string($conn, $_POST['edit-movie-status']);
    $edit_running = mysqli_real_escape_string($conn, $_POST['edit-movie-running']);
    $edit_old_image = mysqli_real_escape_string($conn, $_POST['old_image']);
    $edit_filename = $_FILES['edit-movie-image']['name'];

    if ($edit_filename != '') {
        $edit_image = $edit_filename;
        $location = '../../uploads/' . $edit_image;


        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $edit_image_ext = array('jpg', 'png', 'jpeg', 'gif');

        $response = 0;

        if (in_array($file_extension, $edit_image_ext)) {
            if (move_uploaded_file($_FILES['edit-movie-image']['tmp_name'], $location)) {
                $response = $_FILES['edit-movie-image']['tmp_name'];
            }
        }
        echo $response;


    } else {
        $edit_image = $edit_old_image;
    }

    try {
        $update_record = mysqli_query($conn, "UPDATE `movies` 
        SET `description` = '$edit_description', 
            `trailer_link` = '$edit_trailer_link', 
            `language` = '$edit_language', 
            `genre_id` = '$edit_genre_id', 
            `release_date` = '$edit_release_date', 
            `director` = '$edit_director', 
            `title` = '$edit_title', 
            `image` = '$edit_image', 
            `status` = '$edit_status', 
            `running` = '$edit_running' 
        WHERE `id` = '$e_id'");

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
    header("Location: ../movies.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['delete-movie-btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete-movie-id']);
    try {
        $delete_record = mysqli_query($conn, "DELETE FROM `movies` WHERE `id` = $id");

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

    header("Location: ../movies.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}



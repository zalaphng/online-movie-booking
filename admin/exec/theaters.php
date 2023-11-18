<?php

session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['add-theater-btn'])) {
    $theater_name = mysqli_real_escape_string($conn, $_POST['theater-name']);
    $theater_address = mysqli_real_escape_string($conn, $_POST['theater-address']);
    $theater_phone = mysqli_real_escape_string($conn, $_POST['theater-phone']);

    try {

        $insert_record = mysqli_query($conn, "INSERT INTO theaters (`theater_name`, `theater_address`, `theater_phone`) VALUES ('" . $theater_name . "','" . $theater_address . "','" . $theater_phone . "')");

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
    header("Location: ../theaters.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['edit-theater-btn'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e-id']);
    $edit_theater_name = mysqli_real_escape_string($conn, $_POST['edit-theater-name']);
    $edit_theater_address = mysqli_real_escape_string($conn, $_POST['edit-theater-address']);
    $edit_theater_phone = mysqli_real_escape_string($conn, $_POST['edit-theater-phone']);


    try {

        $update_record = mysqli_query($conn, "UPDATE `theaters` SET `theater_name` = '$edit_theater_name', `theater_address` = '$edit_theater_address', `theater_phone` = '$edit_theater_phone' WHERE `id` = '$e_id'");

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
    header("Location: ../theaters.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

if (isset($_POST['delete-theater-btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete-theater-id']);

    try {

        $delete_record = mysqli_query($conn, "DELETE FROM theaters WHERE id=$id");

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
    header("Location: ../theaters.php?msg=" . urlencode($msg) . "&error=" . $error);
    exit();
}

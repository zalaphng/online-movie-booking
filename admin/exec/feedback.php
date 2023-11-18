<?php

session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['delete-feedback'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    try {
        $delete_record = mysqli_query($conn, "DELETE FROM feedback WHERE id=$id");

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

    header("Location: ../feedback.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}
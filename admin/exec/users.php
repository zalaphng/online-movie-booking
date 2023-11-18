<?php

session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['add-user-btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $filename = $_FILES['image']['name'];
    $location = '../../uploads/' . $filename;

    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $image = '';

    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $image = $filename;
        }
    }

    try {

        $insert_record = mysqli_query($conn, "INSERT INTO `users` (`username`, `name`, `email`, `password`, `phone`, `birthday`, `gender`, `image`) 
        VALUES ('$username', '$name', '$email', '$passwordHash', '$phone', '$birthday', '$gender', '$image')");

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

    header("Location: ../users.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}

if (isset($_POST['update-user-btn'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e-id']);
    $edit_username = mysqli_real_escape_string($conn, $_POST['edit-username']);
    $edit_name = mysqli_real_escape_string($conn, $_POST['edit-name']);
    $edit_email = mysqli_real_escape_string($conn, $_POST['edit-email']);
    $edit_phone = mysqli_real_escape_string($conn, $_POST['edit-phone']);
    $edit_birthday = mysqli_real_escape_string($conn, $_POST['edit-birthday']);
    $edit_gender = mysqli_real_escape_string($conn, $_POST['edit-gender']);
    $edit_old_image = mysqli_real_escape_string($conn, $_POST['old_image']);
    $edit_filename = $_FILES['edit-image']['name'];


    if ($edit_filename != '') {
        $edit_image = $edit_filename;
        $location = '../../uploads/' . $edit_image;


        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $edit_image_ext = array('jpg', 'png', 'jpeg', 'gif');

        $response = 0;

        if (in_array($file_extension, $edit_image_ext)) {
            if (move_uploaded_file($_FILES['edit-image']['tmp_name'], $location)) {
                $response = $_FILES['edit-image']['name'];
            }
        }
        echo $response;


    } else {
        $edit_image = $edit_old_image;
    }
    try {
        $query = "UPDATE `users` SET 
        `username` = '$edit_username', 
        `name` = '$edit_name', 
        `email` = '$edit_email', 
        `phone` = '$edit_phone', 
        `birthday` = '$edit_birthday', 
        `gender` = $edit_gender ,
        `image` = '$edit_image'
        WHERE `id` = '$e_id'";
        $update_record = mysqli_query($conn, $query);

        if ($update_record) {
            $msg = "Update successful $query";
            $error = 0;
        } else {
            throw new Exception("Update unsuccessful");
        }
    } catch (Exception $e) {
        $msg = "An error occurred: " . $e->getMessage();
        $error = 1;
    }

    header("Location: ../users.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}

if (isset($_POST['change-password'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['ep-id']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new-password']);
    $password = password_hash($new_password, PASSWORD_DEFAULT);

    try {

        $update_record = mysqli_query($conn, "
        UPDATE `users` SET 
        `password` = '$password' 
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

    header("Location: ../users.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}

if (isset($_POST['delete-user-btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    try {

        $delete_record = mysqli_query($conn, "DELETE FROM `users` WHERE `id` = $id");


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

    header("Location: ../users.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}


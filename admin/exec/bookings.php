<?php

session_start();

require_once('../../config/db_connect.php');

if (isset($_POST['add-booking-btn'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user-id']);
    $seats = mysqli_real_escape_string($conn, $_POST['booking-seats']);
    $total_seats = mysqli_real_escape_string($conn, $_POST['booking-total-seats']);
    $booking_date = date("Y-m-d H:i:s");
    $showtime_id = mysqli_real_escape_string($conn, $_POST['showtime-id']);
    $total_price = mysqli_real_escape_string($conn, $_POST['booking-total-price']);


    if (!empty($user_id) && !($user_id == 'null')) {
        if (!empty($showtime_id) && !($showtime_id == 'null')) {
            try {
                $insert_record = mysqli_query($conn, "INSERT INTO `moviebooking`.`booking` 
        (`user_id`, `seats`, `total_seats`, `booking_date`, `showtime_id`, `total_price`) 
        VALUES ('$user_id', '$seats', '$total_seats', '$booking_date', '$showtime_id', '$total_price')");

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
            $msg = "Not selected showtime id.";
            $error = 1;
        }
    } else {
        $msg = "Not selected user name.";
        $error = 1;
    }

    header("Location: ../bookings.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}

if (isset($_POST['delete-booking-btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    try {

        $delete_record = mysqli_query($conn, "DELETE FROM booking WHERE id=$id");


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

    header("Location: ../bookings.php?msg=" . urlencode($msg) . "&error=" . $error);

    exit();
}
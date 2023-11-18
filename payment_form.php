<?php
session_start();
require_once ("config/db_connect.php");

    $showtimeId = mysqli_real_escape_string($conn, $_POST['showtimeId']);
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $seats = mysqli_real_escape_string($conn, $_POST['seats']);
    $total_seats = mysqli_real_escape_string($conn, $_POST['total_seats']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);

	$result = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$_SESSION['username']."'");
	 if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
      	    $uid=$row['id'];
      	}
      }

      
//      $_SESSION['user_id'] = $userId;

    $insertQuery = "INSERT INTO booking (showtime_id, user_id, seats, total_seats, total_price, booking_date) VALUES ('$showtimeId', '$userId', '$seats', '$total_seats', '$total_price', '$booking_date')";

    $insert_record = mysqli_query($conn, $insertQuery);

	if(!$insert_record)
	{
		echo 0;
	}else{
        $_SESSION['booking_id'] = mysqli_insert_id($conn);
		echo 1;
    }

<?php
require_once('../../config/db_connect.php');

try {
    if (isset($_GET['showtime_id'])) {
        $showtimeId = mysqli_real_escape_string($conn, $_GET['showtime_id']);

        $result = mysqli_query($conn, "SELECT price FROM showtimes WHERE id = $showtimeId");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            echo $row['price'];
        } else {
            echo "Error, can't get price";
        }
    }
}
catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

?>

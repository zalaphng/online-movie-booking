<?php
include_once('../config/db_connect.php');

if (isset($_GET['date']) && isset($_GET['movieId'])) {
    $selectedDate = $_GET['date'];
    $movieId = $_GET['movieId'];

    $theaterQuery = "SELECT DISTINCT t.theater_name FROM showtimes st
                     INNER JOIN theaters t ON st.theater_id = t.id
                     WHERE st.movie_id = '$movieId' AND DATE(st.showtime) = '$selectedDate'";

    $theaterResult = mysqli_query($conn, $theaterQuery);

    if ($theaterResult) {
        while ($theaterRow = mysqli_fetch_assoc($theaterResult)) {
            $theaterName = $theaterRow['theater_name'];

            echo "<div class='row mb-3'>
                      <div class='col-md-12'>
                          <h5>{$theaterName}</h5>";

            $screenQuery = "SELECT DISTINCT s.screen_name FROM showtimes st
                             INNER JOIN screens s ON st.screen_id = s.id
                             WHERE st.movie_id = '$movieId' AND DATE(st.showtime) = '$selectedDate' AND st.theater_id IN
                             (SELECT t.id FROM theaters t WHERE t.theater_name = '$theaterName')";

            $screenResult = mysqli_query($conn, $screenQuery);

            if ($screenResult) {
                while ($screenRow = mysqli_fetch_assoc($screenResult)) {
                    $screenName = $screenRow['screen_name'];

                    echo "<div class='row'>
                              <h6>{$screenName} Screen</h6>";

                    $showtimeQuery = "SELECT st.id as showtime_id, st.showtime 
                                      FROM showtimes st 
                                      INNER JOIN theaters t ON st.theater_id = t.id
                                      INNER JOIN screens s ON st.screen_id = s.id
                                      WHERE st.movie_id = '$movieId' AND DATE(st.showtime) = '$selectedDate' 
                                      AND t.theater_name = '$theaterName' AND s.screen_name = '$screenName'";

                    $showtimeResult = mysqli_query($conn, $showtimeQuery);

                    if ($showtimeResult) {
                        while ($showtimeRow = mysqli_fetch_assoc($showtimeResult)) {
                            echo "<a class='btn btn-primary btn-sm float-right' 
                                         href='seatbooking.php?movieId={$movieId}&showtimeId={$showtimeRow['showtime_id']}'>
                                         " . date('H:i A', strtotime($showtimeRow['showtime'])) . "
                                      </a>";
                        }
                    }

                    echo '</div>';
                }
            }

            echo '</div></div>';
        }
    } else {
        echo '<p>No showtimes available.</p>';
    }
} else {
    echo 'Invalid parameters';
}
?>

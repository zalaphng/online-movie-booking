<?php
include_once('../config/db_connect.php');

if (isset($_GET['date']) && isset($_GET['movieId'])) {
$selectedDate = $_GET['date'];
$movieId = $_GET['movieId'];

$query = "SELECT t.theater_name, s.screen_name, st.id as showtime_id, st.showtime
              FROM showtimes st
              INNER JOIN theaters t ON st.theater_id = t.id
              INNER JOIN screens s ON st.screen_id = s.id
              WHERE st.movie_id = '$movieId' AND DATE(st.showtime) = '$selectedDate'
              ORDER BY t.theater_name, s.screen_name, st.showtime";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
$currentTheater = '';
$currentScreen = '';

while ($row = mysqli_fetch_assoc($result)) {
if ($row['theater_name'] !== $currentTheater) {
if ($currentTheater !== '') {
    echo '</div></div></div>';
}
$currentTheater = $row['theater_name'];
$currentScreen = '';
?>
<div class="card my-3 border-0 shadow-lg rounded">
    <div class="card-body">
        <h5 class="card-title mt-1"><?php echo $currentTheater; ?></h5>
        <?php
        }

        if ($row['screen_name'] !== $currentScreen) {
        if ($currentScreen !== '') {
            echo '</div>';
        }
        $currentScreen = $row['screen_name'];
        ?>
        <div class="col-md-12 mb-2 d-flex align-items-center justify-content-start">
            <h6 class="mr-5">Screen: <?php echo $currentScreen; ?> </h6>
            <?php
            }
            ?>
            <a class="btn btn-light border-dark border btn-sm mt-0 mr-3 d-flex align-items-center"
               href="seatbooking.php?movieId=<?php echo $movieId; ?>&showtimeId=<?php echo $row['showtime_id']; ?>">
                <span><?php echo date('H:i A', strtotime($row['showtime'])); ?></span>
            </a>
            <?php
            }
            echo '</div></div></div>';

            } else {
                echo '<p>No showtimes available.</p>';
            }
            // Close the last theater and screen
            } else {
                echo '<p>No showtimes available.</p>';
            }
            //} else {
            //    echo 'Invalid parameters';
            //}


            ?>

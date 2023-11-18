<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Information user</title>

    <?php
    include_once('templates/styles.php')
    ?>
</head>
<body>

<?php

include("templates/header.php");

?>


<?php
    if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $queryUser = "SELECT username, `name`, image FROM users WHERE id = $user_id";
    $resultUser = $conn->query($queryUser);
    $user = $resultUser->fetch_assoc();

?>


<div class="container-fluid mt-5 mb-5 px-lg-5">
    <div class="row">
        <div class="col-xl-11 offset-xl-1">
            <h2 class="part-line ml-lg-4">User Information</h2>
        </div>
    </div>
    <?php
    if (isset($_GET['msg']) && (isset($_GET['error']))) {
        ?>

        <div class="row px-1">
            <div class="col-lg-10 offset-1">
                <?php
                include_once ('templates/error.php')
                ?>
            </div>
        </div>

        <?php
    }
    ?>
    <div class="row my-5">
        <div class="offset-xl-1 col-xl-3 px-xl-4">
            <div class="card border-0 shadow-lg mb-4 px-xl-4">
                <img src="uploads/<?php echo $user['image']; ?>" alt="User Image"
                     class="card-img-top rounded-circle mx-auto d-block mt-3"
                     style="width: 250px; height: 250px; object-fit: cover;">
                <div class="card-body text-center">
                    <h3 class="card-title mt-1"><?php echo $user['name']; ?></h3>
                    <p class="card-text text-muted text-uppercase">@<?php echo $user['username']; ?></p>
                    <ul class="list-unstyled text-left">
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Hotline:</strong> 1900 ...</span> <i
                                    class="fa fa-angle-right"></i></li>
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Email:</strong> support@azircinema.com</span>
                            <i class="fa fa-angle-right"></i></li>
                        <hr>
                        <li class="d-flex justify-content-between"><span><strong>Q&A</strong></span> <i
                                    class="fa fa-angle-right"></i></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-11">
                    <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4 rounded"
                         style="border-bottom: 1px solid rgb(160 163 167);">
                        <ul class="navbar-nav w-100 d-flex justify-content-between font-weight-bold text-capitalize">
                            <li class="nav-item">
                                <a class="nav-link active" href="">Booking History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./user_info.php">Personal Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gifts</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-11">
                    <div class="card border-0 shadow-lg mb-4 rounded-0">
                        <div class="card-body">
                            <h4 class="mb-4">Booking History</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Showtime</th>
                                        <th>Booking Date</th>
                                        <th>Seats</th>
                                        <th>Total Seats</th>
                                        <th>Title</th>
                                        <th>Theater</th>
                                        <th>Total Price</th>
                                        <th>Screen Number</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $queryBooking = "SELECT
                                    booking.id,
                                    showtimes.showtime,
                                    booking.booking_date,
                                    booking.seats,
                                    booking.total_seats,
                                    movies.title,
                                    theaters.theater_name,
                                    booking.total_price,
                                    screens.screen_name
                                FROM
                                    booking
                                    INNER JOIN users ON booking.user_id = users.id
                                    INNER JOIN showtimes ON booking.showtime_id = showtimes.id
                                    INNER JOIN movies ON showtimes.movie_id = movies.id
                                    INNER JOIN theaters ON showtimes.theater_id = theaters.id
                                    INNER JOIN screens ON showtimes.screen_id = screens.id
                                WHERE user_id = $user_id";
                                    $booking_list = $conn->query($queryBooking);

                                if ($booking_list && mysqli_num_rows($booking_list) > 0) {
                                    while ($booking = $booking_list->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$booking['showtime']}</td>";
                                        echo "<td>{$booking['booking_date']}</td>";
                                        echo "<td>{$booking['seats']}</td>";
                                        echo "<td>{$booking['total_seats']}</td>";
                                        echo "<td>{$booking['title']}</td>";
                                        echo "<td>{$booking['theater_name']}</td>";
                                        echo "<td>{$booking['total_price']}</td>";
                                        echo "<td>{$booking['screen_name']}</td>";
                                        echo "<td><a class='btn btn-info' href='ticket_show.php?bookingId=".$booking['id']."'>Ticket</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No records found</td></tr>";
                                }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("templates/footer.php");
?>

</body>
</html>
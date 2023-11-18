<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Summary</title>

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>


    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">

</head>
<body>

<div class="container py-5">
    <!-- For demo purpose -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6 text-capitalize">YOUR TICKET</h1>
        </div>
    </div> <!-- End -->

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <?php
                if(isset($_GET['msg'])) { ?>
                    <div class="alert alert-success">
                        <?php echo $_GET['msg'] ?>
                    </div>
            <?php
                }
            ?>
            <div class="card ">
                <div class="card-header">
                    <center><img src="assets/images/logo.png" width="40%">
                        <h6> Nha Trang, Khanh Hoa</h6></center>
                    <?php
                    require_once("config/db_connect.php");

                    $userid = $_SESSION['user_id'];

                    $bookingid = 'test';

                    if (!isset($_GET['bookingId'])) {
                        if(isset($_SESSION['booking_id'])) {
                            $bookingid = $_SESSION['booking_id'];
                        }
                    } else {
                        $bookingid = $_GET['bookingId'];
                    }

                    $query = "SELECT
                        	showtimes.id,
                            showtimes.showtime,
                            booking.booking_date,
                            booking.seats,
                            booking.id,
                            booking.total_seats,
                            users.`name`,
                            users.`email`,
                            users.`phone`,
                            booking.id,
                            showtimes.id AS showtime_id,
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
                        WHERE users.id = $userid AND booking.id = $bookingid";

                    try {


                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_array($result);

                    ?>
                    <table>
                        <tr>
                            <td>+84 123-456-7890</td>
                            <td style="padding: 12px 2px 12px 155px;">Booking
                                Id: <?php echo $row['id']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding: 1px 2px 1px 155px;">Date: <?php echo $row['booking_date']; ?></td>
                        </tr>
                    </table>
                    <hr>

                    <center><h3>Movie Name</h3><h3><?php echo $row['title']; ?></h3><br></center>

                    <table>
                        <tr>
                            <th>Name</th>
                            <th style="padding: 1px 105px;">Email</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td style="padding: 12px 105px;"><?php echo $row['email']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th style="padding: 1px 105px;">Phone</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['email']; ?></td>
                            <td style="padding: 12px 105px;"><?php echo $row['phone']; ?></td>
                        </tr>
                        <tr>
                            <th>Payment Date</th>
                            <th style="padding: 1px 105px;">Payment Amount</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td style="padding: 12px 105px;">RS. <?php echo $row['total_price']; ?>/-</td>
                        </tr>
                    </table>

                    <hr>

                    <h4>BOOKING DETAILS:</h4>
                    <table>
                        <tr>
                            <th>Theater</th>
                            <th style="padding: 0px 2px 0px 60px">Date</th>
                            <th style="padding-left: 30px;">Time</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['theater_name']; ?></td>
                            <td style="padding: 12px 2px 12px 60px"><?php echo $row['booking_date']; ?> </td>
                            <td style="padding-left: 30px;"> <?php echo $row['showtime']; ?></td>
                        </tr>
                        <tr>
                            <th colspan="2">Seats</th>
                            <th style="padding: 0px 2px 0px 60px;">Total Seats</th>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-right: 150px;"><?php echo $row['seats']; ?></td>
                            <td style="padding: 12px 2px 12px 60px"><?php echo $row['total_seats']; ?></td>
                        </tr>

                    </table>
                    <?php }

                    } catch (Exception $e) {
                         ?>
                        <h3 class="text-center text-danger">Cannot Get Ticket!</h3>
                        <?php
                    }

                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <a href="index.php" class="btn btn-primary">Back to main page</a>
    </div>
</div>
</body>
</html>
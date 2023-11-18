<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Customer Page</title>


    <?php session_start();
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">

            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Booking</h2>
                </div>
                <div class="col-2">
                    <button data-toggle="modal" data-target="#add_booking_modal" class="btn btn-primary btn-sm">
                        Booking
                    </button>
                </div>
            </div>

            <?php 
                include_once ('templates/error.php');
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer name</th>
                        <th>Movie</th>
                        <th>Theater</th>
                        <th>Screen</th>
                        <th>Screening time</th>
                        <th>Seats</th>
                        <th>Overall chair</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody id="customer_list">
                    <?php
                    require_once("../config/db_connect.php");

                    $query = "SELECT
                        	showtimes.id,
                            showtimes.showtime,
                            booking.booking_date,
                            booking.seats,
                            booking.total_seats,
                            users.`name`,
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
                        INNER JOIN screens ON showtimes.screen_id = screens.id";

                    $result = $conn->query($query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['theater_name']; ?></td>
                                <td><?php echo $row['screen_name']; ?></td>
                                <td><?php echo $row['showtime_id']; ?></td>
                                <td><?php echo $row['seats']; ?></td>
                                <td><?php echo $row['total_seats']; ?></td>
                                <td><?php echo $row['booking_date']; ?></td>
                                <td><?php echo $row['total_price']; ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#delete_booking<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm">Delete Booking
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete_booking<?php echo $row['id']; ?>" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Bookings</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="insert_movie" action="exec/bookings.php" method="post">
                                                <h4> Are you sure want to delete  "<?php echo $row['id']; ?>" ? </h4>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="submit" name="delete-booking-btn" id="delete-booking-btn" value="OK"
                                                       class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
    </div>


    <div class="modal fade" id="add_booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myform" id="insert_movie" action="exec/bookings.php" method="post"
                          enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                <label>Username Id</label>
                                <select class="form-control category_list" name="user-id">
                                    <option value="null">Select Username</option>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM users");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Showtime ID</label>
                                    <select class="form-control category_list" name="showtime-id" id="showtime-select">
                                        <option value="null">Select Showtime ID</option>
                                        <?php
                                        $resultShowtimes = mysqli_query($conn, "SELECT id FROM showtimes");

                                        if (mysqli_num_rows($resultShowtimes) > 0) {
                                            while ($rowShowtimes = mysqli_fetch_array($resultShowtimes)) {
                                                ?>
                                                <option value="<?php echo $rowShowtimes['id']; ?>"><?php echo $rowShowtimes['id']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Seats</label>
                                    <input type="text" name="booking-seats" class="form-control" placeholder="Enter Seats" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Total Seats</label>
                                    <input type="number" name="booking-total-seats" class="form-control" id="total-seat"
                                           placeholder="Enter Total Seat" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" id="price" name="booking-total-price" class="form-control" placeholder="Enter Price" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" name="add-booking-btn" class="btn btn-primary add-product"
                                       value="Booking">
                            </div>
                        </div>

                    </form>
                    <div id="preview"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/bookings.js"></script>

    <?php include_once("./templates/footer.php"); ?>



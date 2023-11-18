<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css"
          rel="stylesheet">
    <style>
        .front {
            margin: 5px 4px 45px 0;
            background-color: #EDF979;
            color: #000000;
            padding: 9px 0;
            border-radius: 3px;
        }
    </style>
</head>

<body>
<div class="container py-5">

    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">BOOKING SUMMARY</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <p id="msg" class="pl-3 text-danger"></p>
            <div class="card bill-card">
                <div class="card-header bill-header">
                    <div class="row">
                        <h5 class="card-title">Booking Details</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        require_once("config/db_connect.php");

                        $showTimeId = $_POST['showtimeId'];
                        $selected_seats = $_POST['selected-seats'];
                        $total_seats = $_POST['total-seats'];

                        $username = $_SESSION['username'];
                        if (isset($_POST['submit'])) {
//                                $queryUser = "SELECT u.username, u.email, u.mobile, u.city, t.theater FROM users u INNER JOIN theater_show t ON u.username = '" . $username . "' WHERE t.show = '" . $show . "'"
                            $queryUser = "SELECT * from users WHERE username = '" . $username . "'";
                            $resultUser = mysqli_query($conn, $queryUser);
                            $queryShowTimeInfo = "SELECT
                                        screens.screen_name,
                                        movies.title,
                                        movies.image as movie_image,
                                        theaters.theater_name,
                                        theaters.theater_address,
                                        DATE_FORMAT(st.showtime, '%Y-%m-%d') AS show_date, 
                                        DATE_FORMAT(st.showtime, '%H:%i') AS show_time
                                FROM showtimes st
                                INNER JOIN movies ON st.movie_id = movies.id
                                INNER JOIN theaters ON st.theater_id = theaters.id
                                INNER JOIN screens ON st.screen_id = screens.id
                                WHERE st.id='" . $showTimeId . "'";


                            $resultInfo = $conn->query($queryShowTimeInfo)->fetch_array();

                            $movieTitle = $resultInfo['title'];
                            $movie_image = $resultInfo['movie_image'];
                            $theater_name = $resultInfo['theater_name'];
                            $theater_address = $resultInfo['theater_address'];
                            $showDate = $resultInfo['show_date'];
                            $showTime = $resultInfo['show_time'];
                            $seats = explode(",", $selected_seats);
                            $price = 0;
                            if (mysqli_num_rows($resultUser) > 0) {
                                $row = mysqli_fetch_array($resultUser);
                                    ?>
                                    <div class="col-lg-12">
                                        <p>Your Name: <?= $row['name'] ?><br></p>
                                        <p>Phone number.: <?= $row['phone'] ?><br></p>
                                        <p>Email: <?= $row['email'] ?><br></p>
                                        <p>Gender: <?= (($row['gender'] == 0) ? "Male" : "Female") ?><br></p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4 pl-3">
                                                <img src="uploads/<?= $movie_image ?>" alt="" class="rounded img-fluid h-100" style="object-fit: cover">
                                            </div>
                                            <div class="col-lg-8 p-3">
                                                <p>Movie Name: <?= $movieTitle ?><br></p>
                                                <p>Theater: <?= $theater_name ?><br></p>
                                                <p>Show Date: <?= $showDate ?></p>
                                                <p>Time: <?= $showTime ?><br></p>
                                                <hr>
                                                <p>Seats: <?= $selected_seats ?> <br></p>
                                                <p>Total Seats: <?= $_POST['total-seats'] ?> <br></p>
                                                <p>Booking Date: <?= date("l, d-m-Y", strtotime('today')) ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <p align="right">Total Price: <?= $_POST['total_price'] ?>$</p>
                                    </div>

                                    <?php
                                }
                        }
                        ?>
                        <input type="hidden" id="showtimeId" value="<?php echo $showTimeId; ?>">
                        <input type="hidden" id="userId" value="<?php echo $row['id']; ?>">
                        <input type="hidden" id="seats" value="<?php echo $selected_seats; ?>">
                        <input type="hidden" id="total-seats" value="<?php echo $total_seats ?>">
                        <input type="hidden" id="total-price" value="<?php echo $_POST['total_price'] ?>">
                        <input type="hidden" id="booking-date" value="<?php echo date("Y-m-d", strtotime('today')) ?>">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" id="payment"
                            class="subscribe btn btn-primary btn-block shadow-sm">
                        Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery.nicescroll.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.slicknav.js"></script>
<script src="assets/js/mixitup.min.js"></script>
<script src="assets/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#payment").click(function () {
            let showtimeId = $("#showtimeId").val().trim();
            let userId = $("#userId").val().trim();
            let seats = $("#seats").val().trim();
            let total_seats = $("#total-seats").val().trim();
            let total_price = $("#total-price").val().trim();
            let booking_date = $("#booking-date").val().trim();

            $.ajax({
                url: 'payment_form.php',
                type: 'post',
                data: {
                    showtimeId : showtimeId,
                    userId : userId,
                    seats : seats,
                    total_seats : total_seats,
                    total_price : total_price,
                    booking_date : booking_date
                },
                success: function (response) {
                    console.log(response)
                    if (response == 1) {
                        window.location = "ticket_show.php?msg=Booking successful";
                    } else {
                        let error = "Booking unsuccessful";
                        document.getElementById("msg").innerHTML = error;
                        return false;
                    }
                    $("#message").html(response);
                }
            });
        });
    });
</script>
</body>

</html>

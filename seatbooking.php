<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seat Booking</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Recursive&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/seatbooking.css" type="text/css">


    <style>
        .body{
            background-color: white;
        }
    </style>
</head>
<style>
    .text{
        color: black;
    }
     body {
        background-color: white;
    }
    .screen {
        background-color: black;
    }
    .seat {
        width: 35px;
        height: 30px;
        margin: 5px;
        background-color: #ccc;
        border: 1px solid #000;
    }
    .seat-sample{
        width: 30px;
        height: 30px;
        margin: 5px;
    }
    .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .back-link {
        margin: 25px;
        margin-right: 150px;
    }
    h2{
        margin: 5px;
    }
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Azir movie</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Chọn phim/Rạp/Suất <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link">Chọn ghế</a>
            <a class="nav-item nav-link">Chọn thức ăn</a>
            <a class="nav-item nav-link">Thanh toán</a>
            </div>
        </div>
</nav>



<h2 class="mt-5">BOOK YOUR SEAT NOW</h2>

<?php
require_once("config/db_connect.php");
if (isset($_GET['showtimeId']) && isset($_GET['movieId'])) {
    $showtimeId = $_GET['showtimeId'];
    $date = date("Y-m-d");

    $result = mysqli_query($conn, "SELECT * FROM booking WHERE showtime_id = '" . $showtimeId . "' && booking_date = '" . $date . "'");

    $queryMovie = "SELECT movies.title, movies.image, showtimes.price, DATE_FORMAT(showtimes.showtime, '%Y-%m-%d') AS show_date, DATE_FORMAT(showtimes.showtime, '%H:%i') AS show_time
              FROM showtimes
              INNER JOIN movies ON showtimes.movie_id = movies.id
              WHERE showtimes.id = $showtimeId";

    $resultMovie = mysqli_query($conn, $queryMovie);

    if ($row = mysqli_fetch_assoc($resultMovie)) {
        $movieTitle = $row['title'];
        $movieImage = $row['image'];
        $showDate = $row['show_date'];
        $showTime = $row['show_time'];
        $showPrice = $row['price'];
    }

    $occupiedSeats = array();

    while ($row = mysqli_fetch_array($result)) {
        $seats = explode(",", $row['seats']);
        $occupiedSeats = array_merge($occupiedSeats, $seats);
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<div class="container">
    <form action="payment.php" method="POST">

        <div class="row">
            <div class="col-lg-7">
                <div class="screen mb-5"></div>

                <div class="seats-container mx-auto">
                <div class="row d-flex justify-content-center align-items-center">
                    <?php
                    $seats = array("A1", "A2", "A3", "A4", "B1", "B2", "B3", "B4");
                    foreach ($seats as $seat) {
                        $seatClass = in_array($seat, $occupiedSeats) ? 'occupied' : '';
                        echo '<div class="seat ' . $seatClass . '" data-seat="' . $seat . '"></div>';
                    }
                    ?>
                </div>

                <div class="row d-flex justify-content-center align-items-center">
                        <?php
                        $seats = array("C1", "C2", "C3", "C4", "D1", "D2", "D3", "D4");

                        foreach ($seats as $seat) {
                            $seatClass = in_array($seat, $occupiedSeats) ? 'occupied' : '';
                            echo '<div class="seat ' . $seatClass . '" data-seat="' . $seat . '"></div>';
                        }
                        ?>
                    </div>

                    <div class="row d-flex justify-content-center align-items-center">
                        <?php
                        $seats = array("E1", "E2", "E3", "E4", "F1", "F2", "F3", "F4");
                        foreach ($seats as $seat) {
                            $seatClass = in_array($seat, $occupiedSeats) ? 'occupied' : '';
                            echo '<div class="seat ' . $seatClass . '" data-seat="' . $seat . '"></div>';
                        }
                        ?>
                    </div>
                </div>

                <ul class="showcase mt-5">
                    <li>
                        <div class="seat"></div>
                        <small class="text-white">Available</small>
                    </li>
                    <li>
                        <div class="seat-sample selected" style="background-color: #00FFFF"></div>
                        <small class="text-white">Selected</small>
                    </li>
                    <li>
                        <div class="seat-sample occupied" style="background-color: white"></div>
                        <small class="text-white">Occupied</small>
                    </li>
                </ul>
                <p class="text text-center mt-3">You have selected <span id="selected-count">0</span> seats for the price of $<span
                            id="selected-price">0</span></p>

                <input type="hidden" name="total_price" value="">
                <input type="hidden" name="showtimeId" value="<?php echo $showtimeId; ?>">
                <div class="hr" style="border-bottom: 3px solid #FFA500;"></div>

            </div>
            <div class="col-lg-5">
                <div class="hr" style="border-bottom: 3px solid #FFA500; margin:10px"></div>
                <table>
                    <tr>
                        <td><img src="uploads/<?php echo $movieImage; ?>"width="200" height="300"></td>
                        <td>
                            <font size=6 style="font-family: Shruti; color:black"><?php echo $movieTitle ?></font>
                            <font size="3px" style="display: block; color:black">2D phụ đề</font>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <font size="4px" style="font-weight: bold; color:black">Suất:</font>
                            <font size=3 style="color:black"><?php echo $showTime ?></font>
                        </td>
                        <td>
                            <font size="4px" style="font-weight: bold; color:black">- Ngày:</font>
                            <font size=3 style="color:black"><?php echo $showDate ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #FFA500">------------------------------</td>
                        <td style="color: #FFA500">------------------------------</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="selected-seats" name="selected-seats" placeholder="selected checkboxs" readonly></td>
                        <td><input type="text" id="count" name="total-seats" placeholder="Total Seats" readonly></td>
                    </tr>
<!--                    <input type="hidden" name="movie" value="--><?php //echo $movieTitle ?><!--">-->
<!--                    <input type="hidden" name="show" value="--><?php //echo $showtime ?><!--">-->
                </table>

            <!-- check login -->
            <?php
            if (!isset($_SESSION['username'])) {
                ?>
                <div class="col-lg-12">
                    <div class="form-group">
                        <a data-toggle="modal" data-target="#need-login"
                           class="form-control btn btn-primary py-2"><font style="color:white;">Payment Now</a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="col-lg-6">
                    <div class="form-group">
                        <div class="button-group">
                            <a href="javascript:window.history.back(-1);" class="back-link">Back</a>
                            <input type="submit" value="Payment Now" name="submit" class="form-control btn btn-primary py-2">
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="need-login" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-dark">You need to login</h3>
                <a class="btn btn-primary btn-sm" href="login.php">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script src="index.js"></script>-->
<script>

    $(document).ready(function() {
        var selectedSeats = [];
        var maxSeats = 8;
        var showPrice = <?php echo $showPrice; ?>;
        var selectedPrice = 0; // Thêm biến selectedPrice

        $('.seat').click(function() {
        var seat = $(this).data('seat');

        if ($(this).hasClass('occupied')) {
        return;
    }

        if (selectedSeats.length >= maxSeats) {
        if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        selectedSeats = selectedSeats.filter(function(value) {
        return value !== seat;
    });
        selectedPrice -= showPrice;
    } else {
        document.getElementById('notvalid').innerHTML = "Maximum seat select 8";
        return;
    }
    } else {
        $(this).toggleClass('selected');

        if (selectedSeats.includes(seat)) {
        selectedSeats = selectedSeats.filter(function(value) {
        return value !== seat;
    });
        selectedPrice -= showPrice;
    } else {
        selectedSeats.push(seat);
        selectedPrice += showPrice;
    }

        let $sLength = selectedSeats.length;

        $('#selected-count').text($sLength);
        $('#count').val($sLength);
        $('#selected-seats').val(selectedSeats.join(","));

        $('input[name="total_price"]').val(selectedPrice.toFixed(2));
    }

        $('#selected-price').text(selectedPrice.toFixed(2));
    });
    });
</script>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<!--<script src="assets/js/bootstrap.min.js"></script>-->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery.nicescroll.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>
<script src="assets/js/jquery.slicknav.js"></script>
<script src="assets/js/mixitup.min.js"></script>
<!--<script src="js/owl.carousel.min.js"></script>-->
<script src="assets/js/main.js"></script>


</body>
</html>
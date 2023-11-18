<?php
session_start();

require_once("config/db_connect.php");
$id = $_GET['pass'];
$result = mysqli_query($conn, "SELECT * FROM movies WHERE id = '" . $id . "'");
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Css Styles -->
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $row['title']; ?> Movie Details</title>


    <?php
    include_once('templates/styles.php')
    ?>

    <style>

        .container h2 {
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #222;
            font-size: 30px;
        }

        .part-line {
            border-bottom: solid 2px red;
            margin-bottom: 25px;
            margin-top: 25px;
        }

        .image-container {
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay-buttons {
            text-align: center;
            display: none;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }

        .image-container:hover .overlay-buttons {
            display: block;
        }

        .overlay-buttons a {
            color: #fff;
            padding: 10px 20px;
            margin-right: 10px;
            text-decoration: none;
            border: 1px solid #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .overlay-buttons a:hover {
            background-color: #fff;
            color: #000;
        }

        .image-container h6 {
            text-align: right;
        }

        .overlay-button {
            width: 150px;
        }

        .modal-dialog {
            max-width: 1500px;
            margin-top: -1rem;
        }

        @media (min-width: 992px) {
            .movie-detail-image {
                position: absolute;
                top: -120px;
                left: -30px;
                border: 5px solid white;
            }

            .showing-movie {
                height: 200px;
                object-fit: cover;
            }
        }

        @media (min-width: 576px) and (max-width: 992px) {

            .showing-movie {
                object-fit: contain;
            }

        }


    </style>

</head>
<body>
<?php
include("templates/header.php");
require_once("config/db_connect.php");
$movieId = $_GET['pass'];

$query = "SELECT * FROM movies m JOIN genre g ON m.genre_id = g.id WHERE m.id = '" . $id . "'";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_array($result)) {
$id = $row['id'];
?>

<section id="aboutUs">
    <div class="fluid-container">
        <!-- Trailer Embed -->
        <div class="row mt-4" style="background-color: black;">
            <div class="d-flex justify-content-center w-100">
                <img src="uploads/<?php echo $row['image']; ?>" class="img-fluid"
                     style="height: 500px; width: 600px;" alt="Movie Image">
                <button type="button"
                        class="btn bg-white btn-play position-absolute rounded-circle d-flex align-items-center justify-content-center"
                        style="top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 24px; width: 64px; height: 64px;"
                        data-toggle="modal" data-target="#trailer_modal<?php echo $row['id']; ?>">
                    <i class="fa fa-play"></i>
                </button>
            </div>
        </div>

        <div class="modal fade" id="trailer_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog vh-100 vw-100 d-flex align-items-center justify-content-center" role="document">
                <div class="modal-content mx-auto" style="height: 80%; width: 100%;">
                    <iframe src="<?php echo $row['trailer_link']; ?>" frameborder="0" class="modal-iframe w-100 h-100"
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"></iframe>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-10 offset-lg-1">
        <div class="row feature design">
            <div class="col-lg-8">
                <div class="row">
                    <div class="offset-lg-1 col-lg-4"><img src="uploads/<?php echo $row['image']; ?>"
                                                           class="rounded shadow-lg movie-detail-image resize-detail object-fit-cover"
                                                           alt="" width="100%"></div>
                    <div class="col-lg-7 mb-lg-5">
                        <div>
                            <h2 class="mt-3"><?php echo $row['title']; ?></h2>
                            <div class="mb-4">
                                <ion-icon class="text-warning"
                                          name="calendar-outline"></ion-icon> <?php echo $row['release_date']; ?>
                            </div>
                            <div class="mb-4">
                                <h4>Director: <?php echo $row['director']; ?></h4>
                            </div>
                            <div class="mb-4">
                                <h4>Category: <?php echo $row['genre_name']; ?></h4>
                            </div>

                            <div class="mb-4">
                                <h4>Language: <?php echo $row['language']; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <?php if ($row['running'] == 1) { ?>
                        <div class="col-md-12">
                            <div class="row px-sm-4 px-lg-0">
                                <div class="col-md-12 pb-2 mb-4 text-black border-bottom border-danger">
                                    <h4>Showtime</h4>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-12">
                                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                        <div class="collapse navbar-collapse" id="navbarNav">
                                            <ul class="navbar-nav">
                                                <?php
                                                for ($i = 0; $i < 4; $i++) {
                                                    $date = date('Y-m-d', strtotime("+$i days"));
                                                    ?>
                                                    <li class="nav-item rounded mr-3">
                                                        <button class="nav-link date-btn font-weight-bold" data-date="<?php echo $date; ?>">
                                                            <?php echo date('D, M j', strtotime($date)); ?>
                                                        </button>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>

                                            <div class="ml-auto d-flex">
                                                <?php

                                                $queryTheaters = "SELECT id, theater_name FROM theaters";

                                                $resultTheaters = mysqli_query($conn, $queryTheaters);

                                                if ($resultTheaters) {
                                                    echo '<select id="theaterSelect" class="form-control selected-fix">';
                                                    echo '<option value="">Select a Theater</option>';

                                                    while ($rowTheaters = mysqli_fetch_assoc($resultTheaters)) {
                                                        $selectTheaterId = $rowTheaters['id'];
                                                        $slectTheaterName = $rowTheaters['theater_name'];

                                                        echo "<option value=\"$selectTheaterId\">$slectTheaterName</option>";
                                                    }

                                                    echo '</select>';
                                                } else {
                                                    echo 'Error fetching theaters';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </nav>
                                    <div class="col-md-12 mt-3" id="showtimes-section">

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="row px-sm-4 px-lg-0 mb-sm-5 mb-lg-0">
                    <div class="description">
                        <h4>Description</h4>
                        <p>
                            <!--                                            Jeff Lang (Tobey Maguire), an OBGYN, and his wife Nealy (Elizabeth Banks), who owns a small-->
                            <!--                                            shop, live in Seattle with their two-year-old son named Miles. Considering a second child, they-->
                            <!--                                            decide to enlarge their small home and lay expensive new grass in their backyard. Worms in the-->
                            <!--                                            grass attract raccoons, who destroy the grass, and Jeff goes to great lengths to get rid of the-->
                            <!--                                            raccoons, mixing poison with a can of tuna. Their neighbor Lila (Laura Linney) tells Jeff that-->
                            <!--                                            her cat Matthew is missing, and Jeff does not yet realize he may be responsible.-->
                            <?php echo $row['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-lg-3">
                <div class="h4 pb-2 mb-4 text-black border-bottom border-danger">
                    Phim đang chiếu
                </div>
                <div class="row">
                    <div class="offset-lg-1 col-lg-10 justify-content-center flex-column">
                        <?php
                        $currentMoviesQuery = "SELECT id, title, image FROM movies WHERE running = 1 LIMIT 3";
                        $currentMoviesResult = mysqli_query($conn, $currentMoviesQuery);

                        if (mysqli_num_rows($currentMoviesResult) > 0) {
                            while ($currentMovie = mysqli_fetch_assoc($currentMoviesResult)) {
                                ?>
                                <div class="card shadow-lg mb-3 p-3 border-0">
                                    <div class="col-md-12">
                                        <div class="image-container">
                                            <img src="uploads/<?php echo $currentMovie['image']; ?>" alt=""
                                                 class="w-100 img-fluid image-resize2 showing-movie">
                                            <div class="overlay">
                                                <div class="overlay-buttons">
                                                    <div class="col">
                                                        <div class="row">
                                                            <a href="movie_details.php?pass=<?php echo $currentMovie['id']; ?>"
                                                               class="btn btn-primary mx-auto overlay-button">
                                                                <i class="fa fa-ticket"></i>
                                                                Book Now
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mt-2 mb-1"><b><?php echo $currentMovie['title']; ?></b></h5>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "No currently running movies.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
        }
        ?>
    </div>
</section>

<script>
    let movieId = <?php echo $movieId ?>;
</script>

<?php
include("templates/footer.php");
?>

<script src="ajax/movie_details.js"></script>

</body>
</html>     
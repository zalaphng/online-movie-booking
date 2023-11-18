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
    <title>Movie Ticket Booking</title>

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

    </style>

</head>
<body>

<?php

include("templates/header.php");

?>

<div class="container">
    <img src="assets/images/theatre_2.jpg" alt="" class="image-resize" style="width: 100%; height: 400px;">
</div>

<div class="container">
    <h2 class="part-line">Running Movies</h2>
    <div class="row">
        <?php
        require_once("config/db_connect.php");
        $movieIds = array();
        $movieNames = array();

        $result = $conn->query("SELECT * FROM movies");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
//                $row = mysqli_fetch_array($result);

                $movieNames[] = $row['title'];
                $movieIds[] = $row['id'];
                if ($row['running'] == 1 && $row['status'] == 1) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                        <div class="image-container position-relative">
                            <img src="uploads/<?php echo $row['image']; ?>" alt=""
                                 class="w-100 img-fluid image-resize2 object-fit-cover">
                            <div class="overlay">
                                <div class="overlay-buttons">
                                    <div class="col">
                                        <div class="row">
                                            <a href="movie_details.php?pass=<?php echo $row['id']; ?>"
                                               class="btn btn-primary mx-auto overlay-button">
                                                <i class="fa fa-ticket"></i>
                                                Book Now
                                            </a>
                                        </div>
                                        <div class="row">
                                            <a class="mt-3 btn btn-dark text-center mx-auto overlay-button"
                                               data-toggle="modal"
                                               data-target="#trailer_modal<?php echo $row['id']; ?>">
                                                <i class="fa fa-play"></i>
                                                Trailer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

<!--                         IMDB Rating - Php   -->
                            <?php
//                            $curl = curl_init();
//                            $imdbId = '';
//
//                            $title = $row['title'];
//
//                            $apiKey = '4bdcb7a19dmshce4a80fc1d42f9ap1dcb6bjsn4e67866c3247';
//
//                            curl_setopt_array($curl, [
//                                CURLOPT_URL => "https://imdb8.p.rapidapi.com/title/find?q=$title",
//                                CURLOPT_RETURNTRANSFER => true,
//                                CURLOPT_ENCODING => "",
//                                CURLOPT_MAXREDIRS => 10,
//                                CURLOPT_TIMEOUT => 30,
//                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                                CURLOPT_CUSTOMREQUEST => "GET",
//                                CURLOPT_HTTPHEADER => [
//                                    "X-RapidAPI-Host: imdb8.p.rapidapi.com",
//                                    "X-RapidAPI-Key: $apiKey"
//                                ],
//                            ]);
//
//                            $response = curl_exec($curl);
//                            $err = curl_error($curl);
//
//                            curl_close($curl);
//
//                            if ($err) {
//                                echo "cURL Error #:" . $err;
//                            } else {
//                                $responseData = json_decode($response, true);
//
//                                if (!empty($responseData['results'][0]['id'])) {
//                                    $imdbId = $responseData['results'][0]['id'];
//                                    preg_match('/\/title\/(tt\d+)/', $imdbId, $matches);
//                                    $imdbId = $matches[1];
//                                    $curl = curl_init();
//
//                                    curl_setopt_array($curl, [
//                                        CURLOPT_URL => "https://imdb8.p.rapidapi.com/title/get-ratings?tconst=$imdbId",
//                                        CURLOPT_RETURNTRANSFER => true,
//                                        CURLOPT_ENCODING => "",
//                                        CURLOPT_MAXREDIRS => 10,
//                                        CURLOPT_TIMEOUT => 30,
//                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                                        CURLOPT_CUSTOMREQUEST => "GET",
//                                        CURLOPT_HTTPHEADER => [
//                                            "X-RapidAPI-Host: imdb8.p.rapidapi.com",
//                                            "X-RapidAPI-Key: $apiKey"
//                                        ],
//                                    ]);
//
//                                    $response = curl_exec($curl);
//                                    $err = curl_error($curl);
//
//                                    curl_close($curl);
//
//                                    if ($err) {
//                                        echo "cURL Error #:" . $err;
//                                    } else {
//                                        $responseData = json_decode($response, true);
//                                        $rating = $responseData['rating'];
//                                    }
//                                }
//                            }
//
//                            if(isset($rating)) {
//                                 ?>
<!--                                <div class="rate-overlay position-absolute p-2" style="top: 0; right: 0">-->
<!--                                    <span id="rating_--><?php //echo $row['id'] ?><!--" class="badge bg-warning text-white"-->
<!--                                          style="font-size: 22px;">--><?php //echo $rating ?><!--</span>-->
<!--                                </div>-->
<!--                                --><?php
//                            }
//
//                            ?>

                            <!--                            JS-->

                            <div class="rate-overlay position-absolute p-2" style="top: 0; right: 0">
                                <span id="rating_<?php echo $row['id'] ?>" class="badge bg-warning text-white"
                                      style="font-size: 22px;"></span>
                            </div>

                            <!--                            JS -->
                        </div>
                        <div class="row">
                            <h5 class="mt-2 mb-1 col-lg-8"><b><?php echo $row['title']; ?></b></h5>
                            <h6 class="mt-2 mb-1 col-lg-2 offset-lg-1 pl-lg-0"><?php echo $row['language']; ?></h6>
                        </div>
                    </div>


                    <div class="modal fade" id="trailer_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog vh-100 vw-100 d-flex align-items-center justify-content-center"
                             role="document">
                            <div class="modal-content mx-auto" style="height: 80%; width: 100%;">
                                <iframe src="<?php echo $row['trailer_link']; ?>" frameborder="0"
                                        class="modal-iframe w-100 h-100"
                                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"></iframe>
                            </div>
                        </div>
                    </div>


                    <?php
                }
            }
        }

        ?>
    </div>
</div>

<div class="container">
    <h2 class="part-line">Upcoming Movies</h2>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM movies");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row['running'] == 0 && $row['status'] == 1) {
                    ?>
                    <div class="image-box">
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="card" style="width: 12rem;">
                                <img class="card-img-top image-resize4 w-100"
                                     src="uploads/<?php echo $row['image']; ?> "
                                     alt="Card image cap">

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                    <p class="card-text">Director: <?php echo $row['director']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>

    </div>
</div>


<?php
include("templates/footer.php");
?>

<script>
    //$(document).ready(function () {
    //    let movieIds = <?php //echo json_encode($movieIds); ?>//;
    //    let movieNames = <?php //echo json_encode($movieNames); ?>//;
    //    let apiKey = '4bdcb7a19dmshce4a80fc1d42f9ap1dcb6bjsn4e67866c3247';
    //
    //    async function getRating(title, id) {
    //        try {
    //            let url = `https://imdb8.p.rapidapi.com/title/find?q=${title}`
    //
    //            let response = await $.ajax({
    //                url: url,
    //                method: 'GET',
    //                headers: {
    //                    'X-RapidAPI-Key': apiKey,
    //                    'X-RapidAPI-Host': 'imdb8.p.rapidapi.com'
    //                }
    //            });
    //
    //            let imdbId = response.results[0].id;
    //
    //            let parts = imdbId.split('/');
    //
    //            imdbId = parts[parts.length - 2];
    //
    //            let ratingResponse = await $.ajax({
    //                url: `https://imdb8.p.rapidapi.com/title/get-ratings?tconst=${imdbId}`,
    //                method: 'GET',
    //                headers: {
    //                    'X-RapidAPI-Key': apiKey,
    //                    'X-RapidAPI-Host': 'imdb8.p.rapidapi.com'
    //                }
    //            });
    //
    //            let rating = ratingResponse.rating;
    //            $('#rating_' + id).text(rating);
    //            console.log(rating);
    //        } catch (error) {
    //            console.error('Error:', error);
    //        }
    //    }
    //
    //    for (let i = 0; i < movieNames.length; i++) {
    //        getRating(movieNames[i], movieIds[i]);
    //    }
    //});
</script>


</body>
</html>
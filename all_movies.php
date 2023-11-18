<?php
session_start();

require_once('config/db_connect.php');

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All movie page</title>

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
            border-bottom: solid 1px #111;
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

        .card img {
            height: 350px;
        }

        .text-info-container {
            flex-grow: 1;
        }

    </style>

    </style>

</head>

<body>

<?php
include("templates/header.php");
?>
<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class="col-md-3 left rounded">
            <div class="card border-1 ml-3 rounded">
                <div class="list-group px-3 py-1">
                    <h3 class="part-line">Search</h3>
                    <div class="input-group mb-3">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Enter keywords..."
                               aria-label="Search" aria-describedby="search-icon">
                    </div>
                </div>


                <div class="list-group px-3 py-1">
                    <h3 class="part-line">Category</h3>
                    <div class="card border-0">
                        <?php
                        $query = "
                        SELECT DISTINCT g.genre_name, genre_id
                        FROM movies m
                        JOIN genre g ON m.genre_id = g.id
                        WHERE m.status = '1'
                        ORDER BY g.genre_name DESC;
                    ";
                        $statement = $conn->query($query);
                        $result = $statement->fetch_all(MYSQLI_ASSOC);
                        foreach ($result as $row) {
                            ?>
                            <div class="list-group-item">
                                <input id="genre_id_<?= $row['genre_id'] ?>" type="checkbox"
                                       class="common_selector genre checkbox__input"
                                       value="<?php echo $row['genre_id']; ?>">
                                <label for="genre_id_<?= $row['genre_id'] ?>" class="ml-2"><span
                                            class="checkbox__label"></span> <?php echo $row['genre_name']; ?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="list-group px-3 py-1 mb-3">
                    <h3 class="part-line">Language</h3>
                    <div class="card border-0">
                        <?php
                        $query = "
                        SELECT DISTINCT(language) FROM movies WHERE status = '1' ORDER BY language DESC
                        ";
                        $statement = $conn->query($query);
                        $result = $statement->fetch_all(MYSQLI_ASSOC);
                        foreach ($result as $row) {
                            $language_id = 1;
                            ?>
                            <div class="list-group-item">
                                <input id="language_<?= $language_id ?>" type="checkbox" class="common_selector language checkbox__input"
                                       value="<?php echo $row['language']; ?>">
                                <label for="language_<?= $language_id ?>" class="ml-2"><span
                                            class="checkbox__label"></span> <?php echo $row['language']; ?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-1 ml-3 rounded">
                <div class="card-body">
                    <div class="row filter_data"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php

include("templates/footer.php");
?>

<script src="assets/js/jquery-1.10.2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>

<script>
    $(document).ready(function () {

        filter_data();

        function filter_data() {
            $('.filter_data').html('<div id="loading" style="" ></div>');
            var action = 'fetch_data';
            var search = $('#search').val();
            var director = get_filter('director');
            var genre_id = get_filter('genre');
            var language = get_filter('language');
            $.ajax({
                url: "all_movies_fetch.php",
                method: "POST",
                data: {action: action, search: search, director: director, genre_id: genre_id, language: language},
                success: function (data) {
                    $('.filter_data').html(data);
                }
            });
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function () {
                filter.push($(this).val());
            });
            return filter;
        }

        var delayTimer;

        $('#search').keyup(function () {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function () {
                filter_data();
            }, 500);
        });

        $('.common_selector').click(function () {
            filter_data();
        });

        $('#show_range').slider({
            range: true,
            min: 1000,
            max: 65000,
            values: [1000, 65000],
            step: 500,
            stop: function (event, ui) {
                $('#show_show').html(ui.values[0] + ' - ' + ui.values[1]);
                filter_data();
            }
        });

    });
</script>

</body>

</html>

<?php

require_once('config/db_connect.php');

if (isset($_POST["action"])) {
    $query = "
    SELECT movies.*, genre.genre_name
    FROM movies
	INNER JOIN genre ON movies.genre_id = genre.id
    WHERE status = '1'
	";

    if (isset($_POST['search'])) {
        $search_filter = $_POST["search"];
        $query .= "
            AND (title LIKE '%$search_filter%')
        ";
    }

    if (isset($_POST["genre_id"])) {
        $category_filter = implode("','", $_POST["genre_id"]);
        $query .= "
		 AND genre_id IN('" . $category_filter . "')
		";
    }
    if (isset($_POST["language"])) {
        $language_filter = implode("','", $_POST["language"]);
        $query .= "
		 AND language IN('" . $language_filter . "')
		";
    }

    $statement = $conn->query($query);
    $result = $statement->fetch_all(MYSQLI_ASSOC);
    $total_row = $statement->num_rows;
    $output = '';
    if ($total_row > 0) {
        foreach ($result as $row) {
            if ($row['running'] == 1 && $row['status'] == 1) {
                $output .= '
			<div class="col-lg-4 col-md-5 col-sm-6 mb-3 bg-white p-1 d-flex flex-column">
                <div class="image-container">
                    <img src="uploads/' . $row['image'] . '" alt="" class="object-fit-cover w-100 img-fluid image-resize2">
                    <div class="overlay">
                        <div class="overlay-buttons">
                            <div class="col">
                                <div class="row">
                                    <a href="movie_details.php?pass=' . $row['id'] . '" class="btn btn-primary mx-auto overlay-button">
                                        <i class="fa fa-ticket"></i>
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="p-2 bg-dark text-white rounded text-info-container">
                    Title : ' . $row['title'] . ' <br />
					Director : ' . $row['director'] . ' <br />
					Category : ' . $row['genre_name'] . '<br />
					Language : ' . $row['language'] . '
                </div>
            </div>
			';
            }

            if ($row['running'] == 0 && $row['status'] == 1) {
                $output .= '
            <div class="col-lg-4 col-md-5 col-sm-6 mb-3 p-1 d-flex flex-column">
				<div class="image-container">
                    <img src="uploads/' . $row['image'] . '" alt="" class="object-fit-cover w-100 img-fluid image-resize2">
                    <div class="overlay">
                        <div class="overlay-buttons">
                            <div class="col">
                                <div class="row">
                                    <a href="" class="btn btn-primary mx-auto overlay-button disabled">
                                        <i class="fa fa-spinner"></i>
                                        Upcomming
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 bg-dark text-white rounded text-info-container">
                    Title : ' . $row['title'] . ' <br />
					Director : ' . $row['director'] . ' <br />
					Category : ' . $row['genre_name'] . '<br />
					Language : ' . $row['language'] . '</p>
				</div>
			</div>
			';
            }
        }
    } else {
        $output = '<h3>No Data Found</h3>';
    }
    echo $output;
}

?>
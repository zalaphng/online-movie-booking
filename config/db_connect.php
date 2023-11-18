<?php
const DBHOST = 'localhost';
const DBUSER = 'root';
const DBPASS = '';
const DBNAME = 'moviebooking';

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die('Could not connect to the database!' . $conn->connect_error);
}

mysqli_set_charset($conn, 'UTF8');
?>



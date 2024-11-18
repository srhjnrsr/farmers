<?php
require 'constant.php';

//connection to database

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_errno($connection)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die(mysqli_error($connection));
}

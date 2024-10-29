<?php

include_once "config/database.php";
if (isset($_SESSION['user_id'])) {
    $outgoing_id = $_SESSION['user_id'];
    $searchTerm = mysqli_real_escape_string($connection, $_POST['searchTerm']);
    $sql2 = "SELECT * FROM personal_info WHERE NOT user_id = {$outgoing_id} AND (firstname LIKE '%{$searchTerm}%' OR surname LIKE '%{$searchTerm}%') ";
    $output = "";
    $sql = mysqli_query($connection, $sql2);
}

if (mysqli_num_rows($sql) > 0) {
    include_once "data.php";
} else {
    $output .= 'No user found related to your search term';
}
echo $output;

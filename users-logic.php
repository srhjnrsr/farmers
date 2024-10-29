<?php
require "config/database.php";
if (isset($_SESSION['user_id'])) {
    $outgoing_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM personal_info WHERE NOT user_id=$outgoing_id";
    $sql = mysqli_query($connection, $query);
    $output = "";
}
if (mysqli_num_rows($sql) == 0) {
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($sql) > 0) {
    require "data.php";
}
echo $output;

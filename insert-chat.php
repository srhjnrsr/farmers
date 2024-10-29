<?php
include_once "config/database.php";
if (isset($_SESSION['user_id'])) {
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);
    if (!empty($message)) {
        $sql = mysqli_query($connection, "INSERT INTO messages (incoming_id, outgoing_id, message)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
    }
} else {
    header('location: ' . ROOT_URL . 'signin.php');
}

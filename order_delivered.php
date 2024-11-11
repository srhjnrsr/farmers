<?php

require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $order_id = $_GET['order_id'];
    $status = 'Delivered';

    if (empty($order_id) || empty($status)) {
        echo "Order ID and status are required.";
        exit();
    }

    $query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('si', $status, $order_id);


    if ($stmt->execute()) {
        //route back to the order page
        header('location: notification.php');
    } else {
        header('location: notification.php');
    }

    $stmt->close();
    $connection->close();
}

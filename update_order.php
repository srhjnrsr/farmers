<?php

require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];


    if (empty($order_id) || empty($status)) {
        echo "Order ID and status are required.";
        exit();
    }


    $query = "UPDATE orders SET status = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $status, $order_id, $user_id);

    if ($stmt->execute()) {
        echo "Order updated successfully.";
    } else {
        echo "Error updating order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

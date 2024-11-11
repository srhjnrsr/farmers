<?php

require 'config/database.php';


function approveOrder($orderId)
{
    global $connection;


    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $updateSql = "UPDATE orders SET order_status = 'Approve' WHERE order_id = ?";
        $updateStmt = $connection->prepare($updateSql);
        $updateStmt->bind_param("i", $orderId);
        if ($updateStmt->execute()) {

            header("location: notification.php");
        } else {
            echo "Error approving order: {$connection->error}";
        }
    } else {
        echo "Order not found.";
    }

    $stmt->close();
    $connection->close();
}


if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);
    approveOrder($orderId);
} else {
    echo "No order ID provided.";
}

<?php
session_start();
require_once 'config/database.php'; // Adjust path as needed

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Start transaction
    $connection->begin_transaction();

    // Delete from farm_info table
    $delete_farm = "DELETE FROM farm_info WHERE user_id = ?";
    $stmt_farm = $connection->prepare($delete_farm);
    $stmt_farm->bind_param("i", $user_id);
    $stmt_farm->execute();

    // Delete from personal_info table
    $delete_personal = "DELETE FROM personal_info WHERE user_id = ?";
    $stmt_personal = $connection->prepare($delete_personal);
    $stmt_personal->bind_param("i", $user_id);
    $stmt_personal->execute();

    // Delete from users table
    $delete_users = "DELETE FROM users WHERE user_id = ?";
    $stmt_users = $connection->prepare($delete_users);
    $stmt_users->bind_param("i", $user_id);
    $stmt_users->execute();

    $connection->commit();

    // Destroy session and redirect to login page
    session_destroy();
    header('Location: home.html');
    exit();
} catch (Exception $e) {
    $_SESSION['error'] = "Error deleting profile: " . $e->getMessage();
    header('Location: profile.php');
    exit();
}

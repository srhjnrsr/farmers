<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: seller_login.html");
    exit();
}

// Check if the ID is set and is a valid integer
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $product_id = (int)$_POST['id'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Successfully deleted
        echo "<script>alert('Product deleted successfully.'); window.location.href='seller_dashboard.php';</script>";
    } else {
        // Error deleting the product
        echo "<script>alert('Error deleting product. Please try again.'); window.location.href='seller_dashboard.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If ID is not valid
    echo "<script>alert('Invalid product ID.'); window.location.href='seller_dashboard.php';</script>";
}
?>

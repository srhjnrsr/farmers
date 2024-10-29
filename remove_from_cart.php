<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: buyer_login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product_id is set and sanitize it
if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // Prepare the SQL statement to remove the item from the cart
    $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
        if ($stmt->execute()) {
            // Successfully removed the item
            $_SESSION['message'] = "Product removed from cart successfully.";
        } else {
            // Error executing the query
            $_SESSION['message'] = "Error removing product: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "No product ID provided.";
}

// Close the database connection
$conn->close();

// Redirect back to the buyer product list
header("Location: buyer_dashboard.php"); // Change to the correct redirect page
exit();
?>

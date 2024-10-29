<?php
session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the cart session is set, if not, initialize it
if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}

// Get the product ID and quantity from the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the product is already in the cart
    $product_found = false;
    foreach ($_SESSION['cart_items'] as &$item) {
        if ($item['product_id'] == $product_id) {
            // Update quantity if product is already in the cart
            $item['quantity'] += $quantity;
            $product_found = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$product_found) {
        $_SESSION['cart_items'][] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];

        // Insert into the cart_items database
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
        $stmt->close();
    } else {
        // Update the quantity in the database if the item was already in the cart
        $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}

// Redirect back to the buyer dashboard
header("Location: buyer_dashboard.php");
exit();
?>

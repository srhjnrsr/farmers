<?php
session_start();

// Check if the user is logged in and if they are a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: buyer_login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted properly
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $buyer_id = $_SESSION['user_id'];  // Get buyer's user_id from session

    // Fetch product price to calculate total
    $sql = "SELECT price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product is found
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $price = $product['price'];  // Fetch product price

        // Debugging: Check if the price is correct
        if ($price === null) {
            echo "Error: Product price not found or is null.";
            exit();
        }

        // Calculate total amount
        $total_price = $price * $quantity;

        // Debugging: Check if total amount is calculated correctly
        if ($total_price === null || $total_price <= 0) {
            echo "Error: Total amount is invalid.";
            exit();
        }

        // Set order status
        $order_status = 'Pending'; // Set the initial order status

        // Insert the order into the orders table, including order_status and total_price
        $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_status) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiids", $buyer_id, $product_id, $quantity, $total_price, $order_status);

        // Execute the query and check for success
        if ($stmt->execute()) {
            // Success: Order placed
            echo "Order confirmed successfully! Total Amount: ₱" . number_format($total_price, 2);
            // Redirect to order confirmation page (optional)
            header("Location: order_success.php?order_id=" . $stmt->insert_id);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Product not found.";
        exit();
    }
} else {
    echo "Error: Invalid request.";
    exit();
}

$conn->close();
?>

<?php
session_start();

// Check if the user is logged in and if they are a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: buyer_login.html");
    exit();
}

// Check if the order ID is provided in the URL
if (!isset($_GET['order_id'])) {
    echo "Invalid order.";
    exit();
}

$order_id = $_GET['order_id'];

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the order details from the database
$sql = "SELECT orders.*, products.product_name, products.product_photo FROM orders 
        JOIN products ON orders.product_id = products.product_id 
        WHERE orders.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}
$stmt->close();

// Fetch buyer details (name, mobile) based on the user ID
$user_id = $_SESSION['user_id'];
$sql = "SELECT surname, firstname, middlename FROM personal_info WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$buyer_result = $stmt->get_result();

if ($buyer_result->num_rows > 0) {
    $buyer = $buyer_result->fetch_assoc();
} else {
    echo "Buyer details not found.";
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="order_success.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
        </div>
    </header>
    <main>
        <h1>Order Confirmed!</h1>
        <p>Thank you for your purchase, <?php echo htmlspecialchars("{$buyer['firstname']}"); ?>!</p>
        <p>Your order has been placed successfully. Here are your order details:</p>

        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
        <img src="<?php echo htmlspecialchars($order['product_photo']); ?>" alt="<?php echo htmlspecialchars($order['product_name']); ?>" style="max-width: 200px; height: auto;">
        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?> kg</p>
        <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_price'], 2); ?></p>

        <h2>Next Steps</h2>
        <p>Your order is currently being processed. Payment will be made via cash on delivery, so please have the total amount ready upon arrival.
             Delivery is expected within 2 to 3 days, depending on your location.</p>

        <p>If you have any questions, feel free to contact us.</p>

        <a href="buyer_dashboard.php">Return to Dashboard</a>
    </main>
</body>
</html>

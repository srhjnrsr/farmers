<?php
session_start();

// Check if the user is logged in and if they are a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: buyer_login.html");
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders for the logged-in user
$sql = "SELECT orders.order_id, orders.quantity, orders.total_price, orders.order_status, products.product_name, products.product_photo 
        FROM orders 
        JOIN products ON orders.product_id = products.product_id 
        WHERE orders.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

// Check if the user has any orders
if ($order_result->num_rows > 0): ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Orders</title>
        <link rel="stylesheet" href="track_order.css">
    </head>

    <body>
        <header>
            <div class="logo">
                <img src="Logo.png" alt="Logo" class="logo-img">
                <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
            </div>

            <nav class="navigation">
                <a href="buyer_dashboard.php">Home</a>
                <a href="track_order.php" class="active">My Order</a>
                <a href="a_products.php">
                    <img src="message.png" alt="Message" title="Message">
                </a>
                <a href="buyer_profile.php">
                    <img src="profile-account.png" alt="Profile" title="Profile">
                </a>
                <a href="#" onclick="confirmLogout()" class="logout-icon">
                    <img src="logout.png" alt="Log Out" title="Log Out">
                </a>
            </nav>
        </header>
        <main>
            <h1>My Orders</h1>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $order_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($order['product_name']); ?><br>
                                <img src="<?php echo htmlspecialchars($order['product_photo']); ?>" alt="<?php echo htmlspecialchars($order['product_name']); ?>" style="max-width: 100px; height: auto;">
                            </td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?> kg</td>
                            <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="buyer_dashboard.php">Return to Dashboard</a>
        </main>
    </body>

    </html>
<?php else: ?>
    <p>No orders found for your account.</p>
    <a href="buyer_dashboard.php">Return to Dashboard</a>
<?php endif;

$stmt->close();
$conn->close();
?>
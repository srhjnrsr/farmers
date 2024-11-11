<?php
require 'layout/header.php';
// Fetch all orders for the logged-in user
$sql = "SELECT orders.order_id, orders.quantity, orders.total_price, orders.order_status, products.product_name, products.product_photo 
        FROM orders 
        JOIN products ON orders.product_id = products.product_id 
        WHERE orders.user_id = ?";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$order_result = $stmt->get_result();

// Check if the user has any orders
if ($order_result->num_rows > 0): ?>

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
$connection->close();
?>
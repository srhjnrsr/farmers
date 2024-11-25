<?php
require 'layout/header.php';

// Load cart items from the database for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT product_id, quantity FROM cart_items WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$_SESSION['cart_items'] = [];
while ($row = $result->fetch_assoc()) {
    $_SESSION['cart_items'][] = $row;
}
$stmt->close();

// Fetch product data
$sql = "SELECT products.*, farm_info.shop_name FROM products JOIN farm_info ON products.user_id = farm_info.user_id";
$result = $connection->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Product List</title>
    <link rel="stylesheet" href="buyer_dashboard.css">

</head>

<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="buyer_dashboard.php" class="active">Home</a>
            <a href="track_order.php">My Order</a>
            <a href="message.php">
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
    <h1>Welcome, Buyers!</h1>
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>Shop Name</th>
                <th>No</th>
                <th>Image</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                                <td>{$row['shop_name']}</td>
                                <td>{$count}</td>
                                <td><img src='{$row['product_photo']}' alt='Product Image'></td>
                                <td>{$row['product_id']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['price']}</td>
                                <td>
                                    <form action='add_to_cart.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                                        <input type='number' name='quantity' value='1' min='1'>/kg
                                        <button type='submit' class='add-to-cart'>
                                            <img src='add-to-cart.png' alt='Add to Cart' class='button-img'> Add to Cart
                                        </button>
                                    </form>
                                    <form action='buy_now.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                                        <input type='number' name='quantity' value='1' min='1' required>/kg
                                        <button type='submit' class='buy_now'>
                                            <img src='bag.png' alt='Buy Now' class='button-img'> Buy Now
                                        </button>
                                    </form>
                                    <form action='message.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                                        <button type='submit' class='message'>
                                            <img src='messages.png' alt='Message' class='button-img'> Message
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='9'>No products available</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Display the cart at the bottom -->
    <?php
    if (!empty($_SESSION['cart_items'])) {
        echo "<h2>Your Cart</h2>";
        echo "<table>";
        echo "<thead>
                    <tr>
                        <th>No</th>
                        <th>Product ID</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity/kg</th>
                        <th>Action</th>
                    </tr>
                  </thead>";
        echo "<tbody>";
        $count = 1;
        foreach ($_SESSION['cart_items'] as $item) {
            // Fetch product details from the database based on product ID
            $sql = "SELECT product_name, product_photo, price FROM products WHERE product_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $item['product_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                echo "<tr>
                            <td>{$count}</td>
                            <td>{$item['product_id']}</td>
                            <td><img src='{$product['product_photo']}' alt='Product Image' style='width: 50px; height: auto;'></td>
                            <td>{$product['product_name']}</td>
                            <td>{$product['price']}</td>
                            <td>{$item['quantity']}</td>
                            <td>
                                <!-- Remove from Cart Form -->
                                <form action='remove_from_cart.php' method='POST' style='display: inline;'>
                                    <input type='hidden' name='product_id' value='{$item['product_id']}'>
                                    <button type='submit' class='remove-from-cart'>Remove</button>
                                </form>

                                <!-- Buy Now Form -->
                                <form action='buy_now.php' method='POST' style='display: inline;'>
                                    <input type='hidden' name='product_id' value='{$item['product_id']}'>
                                    <input type='hidden' name='quantity' value='{$item['quantity']}'>
                                    <button type='submit' class='buy-now'>Buy Now</button>
                                </form>
                            </td>
                          </tr>";
                $count++;
            }
            $stmt->close();
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</main>
</body>
<script>
    function confirmLogout() {
        var confirmAction = confirm("Are you sure you want to log out?");
        if (confirmAction) {
            window.location.href = "logout.php";
        }
    }
</script>

</html>

<?php
$connection->close();
?>
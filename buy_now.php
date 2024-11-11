<?php
require 'layout/header.php';
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1; // Default to 1 if not set

if ($product_id === null) {
    echo "No product selected.";
    exit();
}

// Validate quantity
if (!is_numeric($quantity) || $quantity < 1) {
    echo "Invalid quantity.";
    exit();
}

// Fetch product details
$sql = "SELECT products.*, farm_info.shop_name FROM products 
        JOIN farm_info ON products.user_id = farm_info.user_id 
        WHERE products.product_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows > 0) {
    $product = $product_result->fetch_assoc();
} else {
    echo "Product not found.";
    exit();
}
$stmt->close();

// Fetch buyer details (name, mobile) based on the user ID
$user_id = $_SESSION['user_id'];
$sql = "SELECT surname, firstname, middlename, mobile_number, street, barangay, municipality, province FROM personal_info WHERE user_id = ?";
$stmt = $connection->prepare($sql);
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

$connection->close();
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Now Confirmation</title>
    <link rel="stylesheet" href="buy_now.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
        </div>
    </header> -->
<main>
    <h1>Confirm Your Purchase</h1>
    <h2>Product Details</h2>
    <p><strong>Product Name:</strong> <?php echo $product['product_name']; ?></p>
    <p><strong>Product Photo:</strong></p>
    <img src="<?php echo htmlspecialchars($product['product_photo']); ?>" alt="
        <?php echo htmlspecialchars($product['product_name']); ?>" style="max-width: 200px; height: auto;">

    <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
    <p><strong>Price:</strong> ₱<?php echo number_format($product['price'], 2); ?> each</p>
    <p><strong>Quantity :</strong> <?php echo htmlspecialchars($quantity); ?> /kg</p> <!-- Show quantity here -->
    <p><strong>Total Amount:</strong> ₱<?php echo number_format($product['price'] * $quantity, 2); ?></p>

    <h2>Buyer Details</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars("{$buyer['firstname']} {$buyer['middlename']} {$buyer['surname']}"); ?></p>
    <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($buyer['mobile_number']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars("{$buyer['street']} {$buyer['barangay']} {$buyer['municipality']} {$buyer['province']}"); ?></p>
    <p><strong>Note: The mode of payment was available at cash on delivery only. </strong></p>

    <form action="order_confirmation.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
        <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <input type="hidden" name="buyer_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <button type="submit">Confirm Purchase</button>
    </form>

    <form action="buyer_dashboard.php" method="GET">
        <button type="submit" class="cancel">Cancel</button>
    </form>
</main>
</body>

</html>
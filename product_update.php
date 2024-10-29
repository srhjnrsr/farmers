<?php
// Connect to the database
$host = 'localhost';
$dbname = 'lagonoy_farmers';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the products record based on the ID passed in POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $products = $result->fetch_assoc();
    } else {
        echo "No products found with this ID.";
        exit;
    }
} else {
    echo "No products ID provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Products</title>
    <link rel="stylesheet" href="a_update.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="Logo.png" alt="Logo" class="logo-img">
        <h5>Department of Agriculture Office<br>
            Lagonoy Calamansi Farmer Agri-Coop<br>
            Municipality of Lagonoy, Camarines Sur</h5>
    </div>
</header>
<main>
    <div class="form-container">
        <!-- Back Button -->
        <a href="javascript:history.back()" class="back-button">✖</a>

        <h2>Update products Information</h2>
        <form action="product_update_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $products['id']; ?>">

            <label for="product_id">Products ID:</label>
            <input type="text" id="product_id" name="product_id" value="<?php echo htmlspecialchars($products['product_id']); ?>" required>
            
            <label for="product_name">Products Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($products['product_name']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($products['description']); ?></textarea>

            
            <label for="price">Price /kg:  ₱</label>
            <input type="number" min="0" id="price" name="price" value="<?php echo htmlspecialchars($products['price']); ?>" required><br>

            <label for="product_photo">Product Image (Optional):</label>
            <input type="file" id="product_photo" name="product_photo">

            <button type="submit" name="update">Update Products</button>
        </form>
    </div>
</main>
</body>
</html>

<?php
$conn->close();
?>

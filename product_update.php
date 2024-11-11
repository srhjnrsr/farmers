<?php
require 'layout/header.php';


// Fetch the products record based on the ID passed in POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $connection->prepare($sql);
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


        <label for="price">Price /kg: ₱</label>
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
$connection->close();
?>
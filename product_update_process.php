<?php
if (isset($_POST['update'])) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Check if an image file was uploaded
    if (isset($_FILES['product_photo']) && $_FILES['product_photo']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['product_photo']['name'];
        $imageTmpName = $_FILES['product_photo']['tmp_name'];
        $imageFolder = 'products' . $imageName; // Directory for storing uploaded images

        // Move the uploaded file to the target folder
        if (move_uploaded_file($imageTmpName, $imageFolder)) {
            // Image successfully uploaded
            $sql = "UPDATE products SET product_id=?, product_name=?, description=?, price=?, product_photo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssssi', $product_id, $product_name, $description, $price, $imageName, $id);
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // If no image was uploaded, update the other fields without changing the image
        $sql = "UPDATE products SET product_id=?, product_name=?, description=?, price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $product_id, $product_name, $description, $price, $id);
    }

    if ($stmt->execute()) {
        echo "Products updated successfully!";
        header("Location: seller_dashboard.php"); // Redirect to the fertilizers page
        exit;
    } else {
        echo "Error updating products: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
    $conn->close();

?>

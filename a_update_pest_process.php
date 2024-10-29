<?php
if (isset($_POST['update'])) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $causes = $_POST['causes'];
    $solutions = $_POST['solutions'];
    
    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'pests' . $imageName; // Directory for storing uploaded images

        // Move the uploaded file to the target folder
        if (move_uploaded_file($imageTmpName, $imageFolder)) {
            // Image successfully uploaded
            $sql = "UPDATE pest SET name=?, causes=?, solutions=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $name, $causes, $solutions, $imageName, $id);
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // If no image was uploaded, update the other fields without changing the image
        $sql = "UPDATE pest SET name=?, causes=?, solutions=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $name, $causes, $solutions, $id);
    }

    if ($stmt->execute()) {
        echo "Pest updated successfully!";
        header("Location: a_pest.php"); // Redirect to the fertilizers page
        exit;
    } else {
        echo "Error updating pest: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
    $conn->close();

?>

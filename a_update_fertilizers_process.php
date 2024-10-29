<?php
if (isset($_POST['update'])) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $applications = $_POST['applications'];
    $method = $_POST['method'];
    $best_for = $_POST['best_for'];
    
    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'fertilizer' . $imageName; // Directory for storing uploaded images

        // Move the uploaded file to the target folder
        if (move_uploaded_file($imageTmpName, $imageFolder)) {
            // Image successfully uploaded
            $sql = "UPDATE fertilizers SET name=?, description=?, applications=?, method=?, best_for=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssi', $name, $description, $applications, $method, $best_for, $imageName, $id);
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // If no image was uploaded, update the other fields without changing the image
        $sql = "UPDATE fertilizers SET name=?, description=?, applications=?, method=?, best_for=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $name, $description, $applications, $method, $best_for, $id);
    }

    if ($stmt->execute()) {
        echo "Fertilizer updated successfully!";
        header("Location: a_fertilizers.php"); // Redirect to the fertilizers page
        exit;
    } else {
        echo "Error updating fertilizer: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
    $conn->close();

?>

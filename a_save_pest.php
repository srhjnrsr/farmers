<?php
// Database connection
$host = 'localhost';
$dbname = 'lagonoy_farmers';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$name = $_POST['name'];
$causes = $_POST['causes'];
$solutions = $_POST['solutions'];

// Handle image upload
$target_dir = "pests/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
}

$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is an actual image
$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check === false) {
    die("File is not an image.");
}

// Check if the file already exists
if (file_exists($target_file)) {
    die("Sorry, file already exists.");
}

// Allow only specific image formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    die("Sorry, only JPG, JPEG, and PNG files are allowed.");
}

// Move the uploaded file to the target directory
if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    die("Sorry, there was an error uploading your file.");
}

// Insert the data into the fertilizers table, including the image path
$sql = "INSERT INTO pest (name, causes, solutions, image)
        VALUES ('$name', '$causes', '$solutions', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "New pest record created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();

// Redirect back to the fertilizer page
header("Location: a_pest.php");
exit();
?>

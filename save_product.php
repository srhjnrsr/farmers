<?php
session_start(); // Start the session to access the logged-in user

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: seller_dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Database connection
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize form data
$productId = mysqli_real_escape_string($conn, $_POST['productId']);
$productName = mysqli_real_escape_string($conn, $_POST['productName']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);

// Handle image upload
$target_dir = "products/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
}

$target_file = $target_dir . basename($_FILES["productPhoto"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check for upload errors
if ($_FILES["productPhoto"]["error"] != UPLOAD_ERR_OK) {
    die("File upload error: " . $_FILES["productPhoto"]["error"]);
}

// Check if file is an actual image
$check = getimagesize($_FILES["productPhoto"]["tmp_name"]);
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
if (!move_uploaded_file($_FILES["productPhoto"]["tmp_name"], $target_file)) {
    die("Sorry, there was an error uploading your file.");
}


// Insert product into the database, including user_id
$sql = "INSERT INTO products (user_id, product_id, product_name, description, price, product_photo)
        VALUES ('$user_id', '$productId', '$productName', '$productDescription', '$price', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "New product added successfully";
    header("Location: seller_dashboard.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

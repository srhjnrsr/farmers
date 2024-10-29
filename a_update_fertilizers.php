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

// Fetch the fertilizer record based on the ID passed in POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM fertilizers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $fertilizer = $result->fetch_assoc();
    } else {
        echo "No fertilizer found with this ID.";
        exit;
    }
} else {
    echo "No fertilizer ID provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Fertilizer</title>
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

        <h2>Update Fertilizer Information</h2>
        <form action="a_update_fertilizers_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $fertilizer['id']; ?>">

            <label for="name">Fertilizer Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($fertilizer['name']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($fertilizer['description']); ?></textarea>

            <label for="applications">Applications:</label>
            <textarea id="applications" name="applications" required><?php echo htmlspecialchars($fertilizer['applications']); ?></textarea>

            <label for="method">Method:</label>
            <textarea id="method" name="method" required><?php echo htmlspecialchars($fertilizer['method']); ?></textarea>

            <label for="best_for">Best For:</label>
            <textarea id="best_for" name="best_for" required><?php echo htmlspecialchars($fertilizer['best_for']); ?></textarea>

            <label for="image">Fertilizer Image (Optional):</label>
            <input type="file" id="image" name="image">

            <button type="submit" name="update">Update Fertilizer</button>
        </form>
    </div>
</main>
</body>
</html>

<?php
$conn->close();
?>

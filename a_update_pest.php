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
    $sql = "SELECT * FROM pest WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $pest = $result->fetch_assoc();
    } else {
        echo "No pest found with this ID.";
        exit;
    }
} else {
    echo "No pest ID provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Pest</title>
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

        <h2>Update Pest Information</h2>
        <form action="a_update_pest_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $pest['id']; ?>">

            <label for="name">Pest Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($pest['name']); ?>" required>

            <label for="causes">Causes:</label>
            <textarea id="causes" name="causes" required><?php echo htmlspecialchars($pest['causes']); ?></textarea>

            <label for="solutions">Solutions:</label>
            <textarea id="solutions" name="solutions" required><?php echo htmlspecialchars($pest['solutions']); ?></textarea>

            <label for="image">Pest Image (Optional):</label>
            <input type="file" id="image" name="image">

            <button type="submit" name="update">Update Pest</button>
        </form>
    </div>
</main>
</body>
</html>

<?php
$conn->close();
?>

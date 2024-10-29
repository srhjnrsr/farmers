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

// Check if the fertilizer ID is provided for archiving
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Check current state
    $check_sql = "SELECT is_archived FROM pest WHERE id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $new_state = $row['is_archived'] ? 0 : 1; // Toggle the state
        $update_sql = "UPDATE pest SET is_archived = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_state, $id);
        $update_stmt->execute();
    }

    header("Location: a_pest.php"); // Redirect back to the list
    exit(); // Ensure no further code is executed after redirection
}

$conn->close();
?>

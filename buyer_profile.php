<?php
session_start(); // Start session to track logged-in users

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: buyer_login.html");
    exit();
}

// Check if the user is logged in and if they are a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: buyer_login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch buyer details from the database
$user_id = $_SESSION['user_id']; // Get the user ID from session
$sql = "SELECT * FROM personal_info WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $buyer = $result->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Product List</title>
    <link rel="stylesheet" href="buyer_profile.css">
    <script>
        function confirmLogout() {
            var confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="buyer_dashboard.php" >Home</a>
            <a href="track_order.php">My Order</a>
            <a href="a_products.php">
                <img src="message.png" alt="Message" title="Message">
            </a>
            <a href="buyer_profile.php" class="active">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a>
            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header>

    <main>
        <section class="profile-container">
            <h1>Welcome, <?php echo $buyer['firstname']; ?>!</h1><br>
            <h2>Profile Information</h2>

            <p><strong>Full Name:</strong> <?php echo $buyer['firstname'] . " " . $buyer['middlename'] . " " . $buyer['surname']; ?></p>
            <p><strong>Address:</strong> <?php echo $buyer['street'] . ", " . $buyer['barangay'] . ", " . $buyer['municipality'] . ", " . $buyer['province']; ?></p>
            <p><strong>Mobile Number:</strong> <?php echo $buyer['mobile_number']; ?></p>
            <p><strong>Sex:</strong> <?php echo ucfirst($buyer['sex']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $buyer['dob']; ?></p>
        </section>
    </main>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch buyer by username
    $sql = "SELECT id, password FROM buyers WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $buyer = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $buyer['password'])) {
            $_SESSION['user_id'] = $buyer['id']; // Store user ID in session
            header("Location: buyer_profile.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

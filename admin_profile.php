<?php
session_start(); // Start session to track logged-in users

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin details from the database
$user_id = $_SESSION['user_id']; // Get the user ID from session
$sql = "SELECT * FROM admin WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}

// Handle password update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $admin['password'])) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Hash new password and update the database
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE admin SET password = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $user_id);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password updated successfully!');</script>";
                echo "<script>window.location.href = 'admin_dashboard.php';</script>"; // Redirect to dashboard
                exit();
            } else {
                echo "Error updating password.";
            }
        } else {
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="admin_profile.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>Lagonoy Calamansi Farmer Agri-Coop<br>Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="admin_dashboard.php">Home</a>
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="users.png" alt="Icon">Users</button>
                <div class="dropdown-content">
                    <a href="#" onclick="goToLoginPage('Farmer')">Farmer</a>
                    <a href="#" onclick="goToLoginPage('Buyer')">Buyer</a>
                </div>
            </div>
            <a href="a_fertilizers.php">Fertilizer</a>
            <a href="a_pest.php">Pest</a>
            <a href="admin_profile.php">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a>
            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header>

    <main>
        <section class="profile-container">
            <h1>Welcome, <?php echo $admin['username']; ?>!</h1>
            <h2>Profile Information</h2>

            <p><strong>Username:</strong> <?php echo $admin['username']; ?></p>

            <!-- Update Password Form -->
            <h2>Update Password</h2>
            <form method="POST" action="admin_profile.php">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="update_password">Update Password</button>
            </form>
        </section>
    </main>

    <script>
        function confirmLogout() {
            var confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>

</html>
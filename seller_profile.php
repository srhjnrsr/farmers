<?php
// session_start(); // Start session to track logged-in users

// // Redirect to login page if not logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: seller_login.html");
//     exit();
// }

// // Check if the user is logged in and if they are a Farmer
// if ($_SESSION['role'] !== 'Farmer') {
//     header("Location: seller_login.html");
//     exit();
// }

// // Connect to the database
// $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

require 'layout/header.php';

$user_id = $_SESSION['user_id']; // Ensure you have the user_id from the session

// Fetch seller details from the personal_info table
$sql_personal = "SELECT * FROM personal_info WHERE user_id = ?";
$stmt_personal = $connection->prepare($sql_personal);
$stmt_personal->bind_param("i", $user_id);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();

if ($result_personal->num_rows > 0) {
    $farmer = $result_personal->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}

// Fetch farm details from the farm_info table
$sql_farm = "SELECT * FROM farm_info WHERE user_id = ?";
$stmt_farm = $connection->prepare($sql_farm);
$stmt_farm->bind_param("i", $user_id);
$stmt_farm->execute();
$result_farm = $stmt_farm->get_result();

if ($result_farm->num_rows > 0) {
    $farm = $result_farm->fetch_assoc();
} else {
    echo "No farm information found!";
    exit();
}
?>
<style>
    button {
        padding: 8px 16px;
        margin: 4px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        background-color: #45a049;
        transition: background-color 0.3s ease;
    }
</style>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Profile</title>
    <link rel="stylesheet" href="seller_profile.css">
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
            <a href="seller_dashboard.php">Home</a>
            <a href="message.php">
                <img src="message.png" alt="Products" title="Products">
            </a>
            <a href="seller_profile.php" class="active">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a>
            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header> -->

<main>
    <section class="profile-container">
        <h1>Welcome, <?php echo $farmer['firstname']; ?>!</h1><br>
        <h2>Profile Information</h2>
        <p><strong>Full Name:</strong> <?php echo $farmer['firstname'] . " " . $farmer['middlename'] . " " . $farmer['surname']; ?></p>
        <p><strong>Sex:</strong> <?php echo $farmer['sex']; ?></p>
        <p><strong>Civil Status:</strong> <?php echo $farmer['civil_status']; ?></p>
        <p><strong>Address:</strong> <?php echo $farmer['street'] . ", " . $farmer['barangay'] . ", " . $farmer['municipality'] . ", " . $farmer['province']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $farmer['mobile_number']; ?></p>
        <p><strong>Household Member:</strong> <?php echo $farmer['household_members']; ?></p>
        <p><strong>Educational Attainment:</strong> <?php echo $farmer['educational_attainment']; ?></p>
        <br>
        <p><strong>Shop Name:</strong> <?php echo $farm['shop_name']; ?></p>

        <h2>Farm Information</h2>
        <p><strong>Farm Address:</strong> <?php echo $farm['farm_street'] . ", " . $farm['farm_barangay']; ?></p>
        <p><strong>Physical Area (HA):</strong> <?php echo $farm['physical_area']; ?> Hectare</p>
        <p><strong>Farm Production (HA):</strong> <?php echo $farm['total_production']; ?> Hectare</p>
        <p><strong>Tenurial Status:</strong> <?php echo $farm['tenurial_status']; ?></p>
        <p><strong>Soil Type:</strong> <?php echo $farm['soil_type']; ?></p>
    </section>
    <!-- edit button -->
    <button type="submit" class="button">
        <a href="edit_profile.php" style="color: whitesmoke;">Edit Profile</a>
    </button>

</main>
</body>

</html>
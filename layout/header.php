<?php

require 'config/database.php';


// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: seller_login.html");
    exit();
}


$current_user_id = $_SESSION['user_id']; // Ensure you have the user_id from the session
$role = $_SESSION['role'];
// Fetch seller details from the personal_info table

$sql_personal = "SELECT * FROM personal_info WHERE user_id = ?";

$stmt_personal = $connection->prepare($sql_personal);
$stmt_personal->bind_param("i", $current_user_id);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();


if ($result_personal->num_rows > 0) {
    $farmer = $result_personal->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= ROOT_URL ?>css\style5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function confirmLogout() {
            var confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <style>
        body {
            background-color: white;
        }

        /* Header styling */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: green;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 99;
            padding: 20px 20px;
            flex-grow: 1;
        }

        .logo {
            display: flex;
            align-items: center;
            color: white;
            user-select: none;
        }

        .logo h4 {
            margin: 0;
            font-size: 1.2em;
        }

        .logo-img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .navigation {
            display: flex;
            padding: 10px;
            align-items: center;
            position: relative;
        }

        .navigation a {
            position: relative;
            font-size: 1.1em;
            color: white;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }

        .navigation a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 100%;
            height: 3px;
            background: orange;
            border-radius: 5px;
            transform-origin: right;
            transform: scaleX(0);
            transition: transform .5s;
        }

        .navigation a:hover::after {
            transform-origin: left;
            transform: scaleX(1);
        }

        .navigation a.active {
            color: orange;
            font-weight: 700;
        }

        /* Dropdown button styling */
        .dropbtn {
            background-color: green;
            color: white;
            padding: 10px;
            font-size: 1.1em;
            border: none;
            cursor: pointer;
            margin-left: 40px;
        }

        /* Dropdown container styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown content styling */
        .dropdown-content {
            border-radius: 20px;
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
            color: black;
        }

        /* Dropdown links */
        .dropdown-content a {
            border-radius: 20px;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 1.1em;
            border-bottom: 1px solid lightgray;
        }

        /* Dropdown hover effect */
        .dropdown-content a:hover {
            background-color: dimgrey;
            color: white;

        }

        /* Show dropdown content on hover */
        .dropdown:hover .dropdown-content {
            display: block;

        }

        /* Dropdown button hover effect */
        .dropdown:hover .dropbtn {
            background-color: orange;
            color: black;
        }

        .dropbtn img.icon-img {
            width: 64px;
            /* Adjust the size */
            height: 64px;
            vertical-align: middle;
            margin-right: 8px;
            /* Space between the image and text */
        }

        .logout-icon img {
            width: 32px;
            height: 32px;
            vertical-align: middle;
            cursor: pointer;
        }

        .logout-icon img:hover {
            opacity: 0.7;
        }

        .h {
            overflow: auto;
            position: relative;
            top: 100px;
        }
    </style>

</head>

<body class="h">
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <div>
                <h4>Department of Agriculture Office Lagonoy<br>Calamansi Farmer Agri-Coop<br></h4>
                <h5>Municipality of Lagonoy, Camarines Sur</h5>
            </div>

        </div>
        <nav class="navigation">
            <a href="admin_dashboard.php">Home</a>
            <div class="dropdown">
                <button class="dropbtn">
                    Users</button>
                <div class="dropdown-content">
                    <?php if ($role == 'Admin'): ?>
                        <a href="#" onclick="goToLoginPage('Farmer')">Farmer</a>
                        <a href="#" onclick="goToLoginPage('Buyer')">Buyer</a>
                    <?php endif; ?>
                    <?php if ($role == 'Farmer'): ?>
                        <a href="#" onclick="goToLoginPage('Buyer')">Buyer</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="a_fertilizers.php">Fertilizer</a>
            <a href="a_pest.php">Pest</a>
            <a href="message.php">
                Messages
            </a>
            <a href="admin_profile.php">
                <img src="profile-account.png" style="width: 100%; height: 100%;" alt="Profile" title="Profile">
            </a>

            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" style="width: 100%; height: 100%;" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header>
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

// Fetch all fertilizers from the database
$sql = "SELECT * FROM pest WHERE is_archived = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pest</title>
    <link rel="stylesheet" href="pests.css"> <!-- Link to your CSS file -->
    <script>
        function goToLoginPage(role) {
            if (role === 'Buyer') {
                window.location.href = 'buyer_login.html';
            } else if (role === 'Admin') {
                window.location.href = 'admin_login.html';
            } else {
                window.location.href = 'seller_login.php?role=' + role;
            }
        }
    </script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>
                Lagonoy Calamansi Farmer Agri-Coop<br>
                Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="home.html">Home</a>
            <a href="fertilizer.php">Fertilizer</a>
            <a href="pest.php" class="active">Pest</a>
            <!-- Dropdown for Farmer and Buyer -->
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="shopping.png" alt="Icon">Farmers & Buyers Hub</button>
                <div class="dropdown-content">
                    <a href="#" onclick="goToLoginPage('Seller')">Farmer</a>
                    <a href="#" onclick="goToLoginPage('Buyer')">Buyer</a>
                </div>
            </div>
            <a href="#" onclick="goToLoginPage('Admin')">Municipal Agriculturist</a>
        </nav>
    </header>

    <main>
        <h2>Pest Data</h2>
        <div class="pest-list">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="pest-item">
                        <div class="pest-content">
                            <img src="<?php echo $row['image']; ?>" alt="Pest Image">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><strong>Causes:</strong> <?php echo $row['causes']; ?></p>
                            <p><strong>Solutions:</strong> <?php echo $row['solutions']; ?></p>
                        </div>
                    </div>
                    <hr>
            <?php
                }
            } else {
                echo "<p>No pest found.</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>
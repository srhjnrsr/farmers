<?php
require_once('config/database.php');
// Fetch all non-archived fertilizers from the database
$sql = "SELECT * FROM fertilizers WHERE is_archived = 0"; // Updated query
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fertilizer</title>
    <link rel="stylesheet" href="fertilizer.css"> <!-- Link to your CSS file -->
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
            <a href="fertilizer.php" class="active">Fertilizer</a>
            <a href="pest.php">Pest</a>
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
        <h2>Fertilizer Data</h2>
        <div class="fertilizer-list">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="fertilizer-item">
                        <div class="fertilizer-content">
                            <img src="<?php echo $row['image']; ?>" alt="Fertilizer Image">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                            <p><strong>Applications:</strong> <?php echo $row['applications']; ?></p>
                            <p><strong>Method of Application:</strong> <?php echo $row['method']; ?></p>
                            <p><strong>Best For:</strong> <?php echo $row['best_for']; ?></p>
                        </div>
                    </div>
                    <hr>
            <?php
                }
            } else {
                echo "<p>No fertilizers found.</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>
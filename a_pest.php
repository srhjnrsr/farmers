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
$sql = "SELECT * FROM pest";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Pest Input</title>
    <link rel="stylesheet" href="a_pest_fertilizer.css"> <!-- Link to the fertilizers-specific CSS -->
    <script>
        function confirmSubmission() {
            var confirmation = confirm("Are you sure you want to submit this form?");
            if (confirmation) {
                return true;
            } else {
                return false;
            }
        }

        function confirmLogout() {
            var confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>

    <script>
        function goToLoginPage(role) {
            if (role === 'Farmer') {
                window.location.href = 'a_farmers.php';
            } else if (role === 'Buyer') {
                window.location.href = 'a_buyers.php';
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
            <a href="a_pest.php" class="active">Pest</a>
            <a href="admin_profile.php">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a>
            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>

    </header>

    <main>
        <!-- Add New Record Button at the Top Left -->
        <button onclick="window.location.href='a_add_pest.html'" style="position: absolute; top: 85px; left: 20px; background-color: lightcoral;">
            Add New Record
        </button>
        <h2>Pest Data</h2>
        <div class="pest_fertilizer-list">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Image</th>
                            <th>Pest Name</th>
                            <th>Causes</th>
                            <th>Solutions</th>
                            <th>Actions</th>
                        </tr>
                      </thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><img src="<?php echo $row['image']; ?>" alt="Pest Image" width="100"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['causes']; ?></td>
                        <td><?php echo $row['solutions']; ?></td>

                        <td>
                            <form action="a_update_pest.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="update-btn">Update</button>
                            </form>

                            <?php if ($row['is_archived']) { ?>
                                <form action="a_archived_pest.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to unarchive this record?');" class="unarchive-btn">Unarchive</button>
                                </form>
                            <?php } else { ?>
                                <form action="a_archived_pest.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to archive this record?');" class="archive-btn">Archive</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
            <?php
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p>No pests found.</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>
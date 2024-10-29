<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Account</title>
    <link rel="stylesheet" href="a_table.css">
    <script>
        function goToLoginPage(role) {
            if (role === 'Farmer') {
                window.location.href = 'a_farmers.php';
            } else if (role === 'Buyer') {
                window.location.href = 'a_buyers.php';
            }
        }

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
            <h5>Department of Agriculture Office<br>
                Lagonoy Calamansi Farmer Agri-Coop<br>
                Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="admin_dashboard.html">Home</a>
            <div class="dropdown">
                <button class="dropbtn">
                    <img src="users.png" alt="Icon">Users</button>
                <div class="dropdown-content">
                    <a href="#" onclick="goToLoginPage('Farmer')">Farmer</a>
                    <a href="#" onclick="goToLoginPage('Buyer')" class="active">Buyer</a>
                </div>
            </div>
            <a href="a_fertilizers.php">Fertilizer</a>
            <a href="a_pest.php">Pest</a>
            <a href="admin_profile.php">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a> <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header>
    <main>
        <?php
        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lagonoy_farmers";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch only buyers
        $sql = "SELECT users.user_id, users.username, users.role, users.created_at,
                       personal_info.surname, personal_info.firstname, personal_info.middlename, personal_info.extension, 
                       personal_info.sex, personal_info.dob, personal_info.street, 
                       personal_info.barangay, personal_info.municipality, personal_info.province, personal_info.mobile_number
                FROM users
                LEFT JOIN personal_info ON users.user_id = personal_info.user_id
                WHERE users.role = 'Buyer'"; // Filter for buyers

        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Role</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Surname</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Extension</th>
                        <th>Sex</th>
                        <th>Date of Birth</th>
                        <th>Address (Street)</th>
                        <th>Addres (Barangay)</th>
                        <th>Address (Municipality)</th>
                        <th>Address (Province)</th>
                        <th>Mobile No.</th>
                    </tr>";
            // Fetch each row and display it
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['role']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['created_at']}</td>
                        <td>{$row['surname']}</td>
                        <td>{$row['firstname']}</td>
                        <td>{$row['middlename']}</td>
                        <td>{$row['extension']}</td>
                        <td>{$row['sex']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['street']}</td>
                        <td>{$row['barangay']}</td>
                        <td>{$row['municipality']}</td>
                        <td>{$row['province']}</td>
                        <td>{$row['mobile_number']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No buyers found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </main>
</body>
</html>

<?php

require 'layout/header.php';
?>
<main>
    <?php


    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connetion->connect_error);
    }

    // SQL query to fetch only buyers
    $sql = "SELECT users.user_id, users.username, users.role, users.created_at,
                       personal_info.surname, personal_info.firstname, personal_info.middlename, personal_info.extension, 
                       personal_info.sex, personal_info.dob, personal_info.street, 
                       personal_info.barangay, personal_info.municipality, personal_info.province, personal_info.mobile_number
                FROM users
                LEFT JOIN personal_info ON users.user_id = personal_info.user_id
                WHERE users.role = 'Buyer'"; // Filter for buyers

    $result = $connection->query($sql);

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

    ?>
</main>
</body>

</html>
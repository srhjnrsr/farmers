<?php

require 'layout/header.php';

?>


<main>
    <?php


    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // SQL query to fetch data from users, personal_info, and farm_info
    $sql = "SELECT users.user_id, users.username, users.role, users.created_at,
               personal_info.surname, personal_info.firstname, personal_info.middlename, personal_info.extension, 
               personal_info.sex, personal_info.civil_status, personal_info.dob, personal_info.street, 
               personal_info.barangay, personal_info.municipality, personal_info.province, personal_info.mobile_number,
               personal_info.household_members, personal_info.educational_attainment,
               farm_info.farm_street, farm_info.farm_barangay, farm_info.physical_area, farm_info.total_production, 
               farm_info.tenurial_status, farm_info.soil_type
        FROM users
        LEFT JOIN personal_info ON users.user_id = personal_info.user_id
        LEFT JOIN farm_info ON users.user_id = farm_info.user_id
        WHERE users.role = 'Farmer'"; // Filter for farmers



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
                        <th>Civil Status</th>
                        <th>Date of Birth</th>
                        <th>Address (Street)</th>
                        <th>Address (Barangay)</th>
                        <th>Address (Municipality)</th>
                        <th>Address (Province)</th>
                        <th>Mobile No.</th>
                        <th>Household Members</th>
                        <th>Educational Attainment</th>
                        <th>Farm Street</th>
                        <th>Farm Barangay</th>
                        <th>Physical Area</th>
                        <th>Total Production</th>
                        <th>Tenurial Status</th>
                        <th>Soil Type</th>
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
                        <td>{$row['civil_status']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['street']}</td>
                        <td>{$row['barangay']}</td>
                        <td>{$row['municipality']}</td>
                        <td>{$row['province']}</td>
                        <td>{$row['mobile_number']}</td>
                        <td>{$row['household_members']}</td>
                        <td>{$row['educational_attainment']}</td>
                        <td>{$row['farm_street']}</td>
                        <td>{$row['farm_barangay']}</td>
                        <td>{$row['physical_area']}</td>
                        <td>{$row['total_production']}</td>
                        <td>{$row['tenurial_status']}</td>
                        <td>{$row['soil_type']}</td>
                      </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }

    // Close the database connection
    $connection->close();
    ?>
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
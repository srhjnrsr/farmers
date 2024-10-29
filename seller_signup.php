<?php 
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lagonoy_farmers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data to prevent SQL injection
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input
    $role = sanitize_input($_POST["role"]);
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $confirm_password = sanitize_input($_POST["confirm_password"]);

    // Password confirmation
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username already exists
    $check_username = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_username);
    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
        $conn->close();
        exit();
    }

    // Personal information
    $surname = sanitize_input($_POST["surname"]);
    $firstname = sanitize_input($_POST["firstname"]);
    $middlename = sanitize_input($_POST["middlename"]);
    $extension = sanitize_input($_POST["extension"]);
    $sex = sanitize_input($_POST["sex"]);
    $civil_status = sanitize_input($_POST["civil_status"]);
    $dob = sanitize_input($_POST["dob"]);
    $street = sanitize_input($_POST["street"]);
    $barangay = sanitize_input($_POST["barangay"]);
    $municipality = sanitize_input($_POST["municipality"]);
    $province = sanitize_input($_POST["province"]);
    $mobile_number = sanitize_input($_POST["mobile_number"]);
    $household_members = isset($_POST["household_members"]) ? sanitize_input($_POST["household_members"]) : null;
    $educational_attainment = sanitize_input($_POST["educational_attainment"]);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert user data
        $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
        if ($conn->query($sql_user) === TRUE) {
            $user_id = $conn->insert_id; // Get the last inserted user ID
            
            // Store user ID in session to keep them logged in
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username; // Optional: to store more info in session

            // Insert personal information
            $sql_personal_info = "INSERT INTO personal_info (user_id, surname, firstname, middlename, extension, sex, civil_status, dob, street, barangay, municipality, province, mobile_number, household_members, educational_attainment)
                                  VALUES ('$user_id', '$surname', '$firstname', '$middlename', '$extension', '$sex', '$civil_status', '$dob', '$street', '$barangay', '$municipality', '$province', '$mobile_number', '$household_members', '$educational_attainment')";
            $conn->query($sql_personal_info);

            // Insert farm information for sellers
            if ($role == 'Farmer') {
                $shop_name = sanitize_input($_POST["shop_name"]); // Collect the shop name
                $farm_street = sanitize_input($_POST["farm_street"]);
                $farm_barangay = sanitize_input($_POST["farm_barangay"]);
                $physical_area = sanitize_input($_POST["physical_area"]);
                $total_production = sanitize_input($_POST["total_production"]);
                $tenurial_status = sanitize_input($_POST["tenurial_status"]);
                $soil_type = sanitize_input($_POST["soil_type"]);

                $sql_farm_info = "INSERT INTO farm_info (user_id, shop_name, farm_street, farm_barangay, physical_area, total_production, tenurial_status, soil_type)
                                  VALUES ('$user_id', '$shop_name', '$farm_street', '$farm_barangay', '$physical_area', '$total_production', '$tenurial_status', '$soil_type')";

                $conn->query($sql_farm_info);
            }

            // Commit transaction if everything is successful
            $conn->commit();

            // Redirect to seller dashboard after signup
            header("Location: seller_dashboard.php");
            exit();
        } else {
            throw new Exception("Error inserting user data: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Registration failed: " . $e->getMessage();
    }

    // Close the connection
    $conn->close();
}
?>

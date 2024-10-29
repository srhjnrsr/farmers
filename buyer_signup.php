<?php
session_start(); // Start the session at the beginning

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
    // User information
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
    $dob = sanitize_input($_POST["dob"]);
    $street = sanitize_input($_POST["street"]);
    $barangay = sanitize_input($_POST["barangay"]);
    $municipality = sanitize_input($_POST["municipality"]);
    $province = sanitize_input($_POST["province"]);
    $mobile_number = sanitize_input($_POST["mobile_number"]);

    // Insert user data
    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    
    if ($conn->query($sql_user) === TRUE) {
        $user_id = $conn->insert_id;

        // Store user ID and role in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        // Insert personal information
        $sql_personal_info = "INSERT INTO personal_info (user_id, surname, firstname, middlename, extension, sex, dob, street, barangay, municipality, province, mobile_number)
                              VALUES ('$user_id', '$surname', '$firstname', '$middlename', '$extension', '$sex', '$dob', '$street', '$barangay', '$municipality', '$province', '$mobile_number')";

        if ($conn->query($sql_personal_info) === TRUE) {
            // Success message for buyer
            echo "Buyer registered successfully.";
            // Redirect to buyer dashboard
            header("Location: buyer_dashboard.php");
            exit(); // Prevent further script execution
        } else {
            echo "Error: " . $sql_personal_info . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }
}
$conn->close();
?>

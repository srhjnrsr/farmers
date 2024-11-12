<?php
require_once('config/constant.php');

// Sanitize input data to prevent SQL injection
function sanitize_input($data)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $submitted_role = sanitize_input($_POST["role"]); // Get role from form

    // Retrieve the stored hash and role for the user
    $sql = "SELECT user_id, password, role FROM users WHERE username = '$username'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hash = $row['password'];
        $db_role = $row['role'];

        if (password_verify($password, $stored_hash)) {
            if ($submitted_role === $db_role) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $db_role;

                if ($db_role == 'Farmer') {
                    header("Location: seller_dashboard.php");
                } else {
                    header("Location: buyer_dashboard.php");
                }
                exit();
            } else {
                echo "Incorrect login. Please log in as a $db_role.";
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username.";
    }
}

$connection->close();

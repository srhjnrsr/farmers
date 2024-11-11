<?php
require 'config/database.php';

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $surname = $_POST['surname'];
    $mobile_number = $_POST['mobile_number'];
    $household_members = $_POST['household_members'];
    $role = $_SESSION['role'];
    $user_id = $_SESSION['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Start transaction
    $connection->begin_transaction();

    try {
        // Update users table
        $update_users = "UPDATE users SET username = ?, password = ? WHERE user_id = ?";
        $stmt_users = $connection->prepare($update_users);
        $stmt_users->bind_param("ssi", $username, $password, $user_id);
        $stmt_users->execute();

        // Update personal_info table
        $update_personal = "UPDATE personal_info SET firstname = ?, middlename = ?, surname = ?, mobile_number = ?, household_members = ? WHERE user_id = ?";
        $stmt_personal = $connection->prepare($update_personal);
        $stmt_personal->bind_param("sssssi", $firstname, $middlename, $surname, $mobile_number, $household_members, $user_id,);
        $stmt_personal->execute();

        // If user is farmer, update farm_info
        if ($role == 'Farmer') {

            $educational_attainment = $_POST['educational_attainment'];
            $farm_street = $_POST['farm_street'];
            $farm_barangay = $_POST['farm_barangay'];
            $update_farm = "UPDATE farm_info SET farm_street = ?, farm_barangay = ? WHERE user_id = ?";
            $stmt_farm = $connection->prepare($update_farm);
            $stmt_farm->bind_param("ssi", $farm_street, $farm_barangay, $user_id);
            $stmt_farm->execute();
        }

        $connection->commit();
        //redirect to profile page
        header('location: seller_profile.php');
        exit();
    } catch (Exception $e) {
        $connection->rollback();
        echo "<div class='alert alert-danger'>Error updating profile: " . $e->getMessage() . "</div>";
    }
}

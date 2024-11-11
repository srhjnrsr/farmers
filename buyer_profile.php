<?php
require 'layout/header.php';

// Fetch buyer details from the database
$user_id = $_SESSION['user_id']; // Get the user ID from session
$sql = "SELECT * FROM personal_info WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $buyer = $result->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}
?>

<main>
    <section class="profile-container">
        <h1>Welcome, <?php echo $buyer['firstname']; ?>!</h1><br>
        <h2>Profile Information</h2>

        <p><strong>Full Name:</strong> <?php echo $buyer['firstname'] . " " . $buyer['middlename'] . " " . $buyer['surname']; ?></p>
        <p><strong>Address:</strong> <?php echo $buyer['street'] . ", " . $buyer['barangay'] . ", " . $buyer['municipality'] . ", " . $buyer['province']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $buyer['mobile_number']; ?></p>
        <p><strong>Sex:</strong> <?php echo ucfirst($buyer['sex']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $buyer['dob']; ?></p>
    </section>
</main>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch buyer by username
    $sql = "SELECT id, password FROM buyers WHERE username = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $buyer = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $buyer['password'])) {
            $_SESSION['user_id'] = $buyer['id']; // Store user ID in session
            header("Location: buyer_profile.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
<?php
require 'layout/header.php';
// Fetch user data

$user_id = $_SESSION['user_id'];
$query = "SELECT users.username, personal_info.*, farm_info.farm_street, farm_info.farm_barangay FROM personal_info LEFT JOIN users ON personal_info.user_id = users.user_id LEFT JOIN farm_info ON personal_info.user_id = farm_info.user_id WHERE personal_info.user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


?>
<style type="text/css">
    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        width: 100%;
    }

    label {
        margin-bottom: 0.5rem;
    }

    input {
        padding: 0.5rem;
        margin-bottom: 1rem;
    }

    input[type="submit"] {
        padding: 0.5rem 1rem;
        width: 50%;
        align-self: center;
    }
</style>
<main>
    <h2 style="margin-bottom: 0.5rem;">Edit Profile</h2>
    <form method="post" action="update_profile.php">
        <div style="display: grid;">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>" required><br>
        </div>
        <div style="display: grid;">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required><br>
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required><br>
        </div>
        <div style="display: grid;">
            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>" required><br>


        </div>
        <div style="display: grid;">
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>" required><br>
        </div>
        <?php if ($role == 'Farmer') { ?>
            <div style="display: grid;">
                <label for="household_members">Household Members:</label>
                <input type="text" id="household_members" name="household_members" value="<?php echo htmlspecialchars($user['household_members']); ?>" required><br>
            </div>
            <div style="display: grid;">
                <label for="educational_attainment">Educational Attainment:</label>
                <input type="text" id="educational_attainment" name="educational_attainment" value="<?php echo htmlspecialchars($user['educational_attainment']); ?>" required><br>
            </div>
            <!-- famrm info -->
            <div style="display: grid;">
                <label for="farm_street">Farm Street:</label>
                <input type="text" id="farm_street" name="farm_street" value="<?php echo htmlspecialchars($user['farm_street']); ?>" required><br>
                <label for="farm_barangay">Farm Barangay:</label>
                <input type="text" id="farm_barangay" name="farm_barangay" value="<?php echo htmlspecialchars($user['farm_barangay']); ?>" required><br>
            </div>
        <?php } ?>
        <div style="display: grid;">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

        </div>
        <div style="width: 500px;">
            <input type="submit" value="Update Profile">
        </div>

    </form>
    <!--- delete button here -->
    <button style="
    background-color: #f44336;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    "
        onclick="onDeleteProfile()">
        >
        Delete Profile
    </button>
    <div style="margin-top: 1rem;">
        <a href="seller_profile.php">Back to Profile</a>
    </div>
</main>
</body>
<script>
    function onDeleteProfile() {
        var confirmAction = confirm("Are you sure you want to delete your profile?");
        if (confirmAction) {
            window.location.href = "delete_profile.php";
        }
    }
</script>

</html>
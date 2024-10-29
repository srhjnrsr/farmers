<?php
require 'config/database.php';

// Ensure no output before this point
if (!isset($_GET['user_id'])) {
    header("location: users.php");
    exit();
}

$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
$sql = mysqli_query($connection, "SELECT * FROM personal_info WHERE user_id = {$user_id}");

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    header("location: users.php");
    exit();
}

require 'layout/header.php';
?>
<section class="chat-area">
    <!-- add the name of the user you are chatting with -->
    <h5><?php echo $row['firstname'] . " " . $row['surname']; ?></h5>
    <div class="chat-box">
        <!-- Chat messages will be loaded here -->
    </div>
    <form method="POST" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo htmlspecialchars($user_id); ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button type="submit">Send</button>
    </form>
</section>
</div>
<script src="javascript/chat.js"></script>
</body>

</html>
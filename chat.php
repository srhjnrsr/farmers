<?php

require 'layout/header.php';

?>


<div class="wrapper">
    <section class="chat-area">
        <header>
            <?php
            $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
            $sql = mysqli_query($connection, "SELECT * FROM users WHERE unique_id = {$user_id}");

            if (mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
            } else {
                header("location: users.php");
            }
            ?>
            <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <img src="../images/<?php echo $row['avatar']; ?>" alt="">
            <div class="details">
                <span><?php echo $row['firstname'] . " " . $row['lastname'] ?></span>
                <p><?php echo $row['status']; ?></p>
            </div>
        </header>
        <div class="chat-box">
            w
        </div>
        <form action="POST" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
            <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
            <button><i class="fab fa-telegram-plane"></i></button>
        </form>
    </section>
</div>
<script src="javascript/chat.js"></script>
</body>

</html>
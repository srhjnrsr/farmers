<?php

require 'layout/header.php';
?>
<div class="wrapper">
    <section class="users">
        <div class="search">
            <span class="text">Select an user to start chat</span>
            <input type="text" placeholder="Enter name to search...">
            <button><i class="fas fa-search"></i></button>
        </div>
        <a href=".users-logic.php">
            <div class="users-list">

            </div>
        </a>
    </section>
</div>

<script src="javascript/users.js"></script>

</body>

</html>
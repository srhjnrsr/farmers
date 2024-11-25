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
<style>
    .wrapper{
        width: 100%;
        height: 500px;
        /* position: absolute; */
        align-items: center;
        justify-content: center;
        display: flex;
        margin-top: 7%;
    }
    .users{
        border: 2px solid green;
        padding: 30px;
        border-radius: 20px;
    }
</style>
</html>
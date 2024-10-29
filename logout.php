<?php
session_start();
session_destroy(); // Destroy all sessions

// Redirect to login page
header("Location: home.html");
exit();
?>

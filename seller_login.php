<?php
//i did refractor the header to single file and just reuse it in the other login page
require 'layout/login-header.php';

?>
<main>
    <section class="form-container">
        <a href="javascript:history.back()" class="back-button">✖</a> <!-- X button to go back -->
        <h2>Farmers Log In</h2>

        <form action="submit_login.php" method="post">
            <input type="hidden" name="role" value="Farmer">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="input-field" required>
            </div>
            <button type="submit">Log In</button>
        </form>

        <div class="signup-link">
            <p>Don't have an account? <a href="seller_signup.html">Register</a></p>
        </div>
    </section>
</main>
</body>

</html>
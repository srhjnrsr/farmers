<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard - Products</title>
    <link rel="stylesheet" href="seller_dashboard.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Logo.png" alt="Logo" class="logo-img">
            <h5>Department of Agriculture Office<br>
                Lagonoy Calamansi Farmer Agri-Coop<br>
                Municipality of Lagonoy, Camarines Sur</h5>
        </div>
        <nav class="navigation">
            <a href="seller_dashboard.php" class="active">Home</a>
            <a href="seller_profile.php">
                <img src="message.png" alt="Message" title="Message">
            </a>
            <a href="seller_profile.php">
                <img src="profile-account.png" alt="Profile" title="Profile">
            </a>
            <a href="#" onclick="confirmLogout()" class="logout-icon">
                <img src="logout.png" alt="Log Out" title="Log Out">
            </a>
        </nav>
    </header>

    <main>
        <h1>Welcome, Farmers!</h1><br>
        <h2>Add New Product</h2><br>
        <form action="save_product.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit this form?');">
            <div class="form-group">
                <label for="productId">Product ID:</label>
                <input type="text" id="productId" name="productId" required>
            </div>

            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>

            <div class="form-group">
                <label for="price">Price /kg:</label>
                <input type="number" min="0" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="productDescription">Description:</label>
                <textarea id="productDescription" name="productDescription" rows="4" cols="50" required></textarea>
            </div>

            <div class="form-group full-width">
                <label for="productPhoto">Upload Product Photo:</label>
                <input type="file" id="productPhoto" name="productPhoto" accept="image/*" required>
            </div>

            <div class="form-group full-width">
                <button type="submit">Submit</button><br>
            </div>
        </form>

        <h2><br>Product List</h2>
        <div class="product-list">
            <?php
            session_start(); // Make sure session is started

            if (!isset($_SESSION['user_id'])) {
                // If user_id is not set, redirect to login page or show an error message
                header("Location: seller_login.html"); // Redirect to login page
                exit(); // Stop further execution of the script
            }

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'lagonoy_farmers');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the logged-in user's ID from the session
            $user_id = $_SESSION['user_id'];

            // Use prepared statements to fetch products
            $stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ?");
            $stmt->bind_param("i", $user_id); // Assuming user_id is an integer
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Image</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price /kg</th>
                            <th>Actions</th>
                        </tr>
                      </thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($row['product_photo']); ?>" alt="Product Image" width="100"></td>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>₱<?php echo htmlspecialchars($row['price']); ?></td>
                        <td>
                            <form action="product_update.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="update-btn">Update</button>
                            </form>

                            <form action="delete_product.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this product?');" class="delete-btn">Delete</button>
                            </form>

                        </td>
                    </tr>
                    <?php
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p>No products found.</p>";
            }

            $stmt->close(); // Close the statement
            $conn->close(); // Close the connection
            ?>
        </div>
    </main>

    <script>
        function confirmLogout() {
            var confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>

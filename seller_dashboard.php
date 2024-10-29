<?php
require 'layout/header.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}

//get the total sales of the products of farmers per month
$sql = "SELECT SUM(total_price) as total_sales, MONTH(order_date) as month FROM orders WHERE order_status = 'Paid' GROUP BY MONTH(order_date)";
$query = mysqli_query($connection, $sql);
$months = [];
$sales = [];
while ($row = mysqli_fetch_assoc($query)) {
    $months[] = $row['month'];
    $sales[] = $row['total_sales'];
}

$years = [];
$yearly_sales = [];

$sql = "SELECT SUM(total_price) as total_sales, YEAR(order_date) as year FROM orders WHERE order_status = 'Paid' GROUP BY YEAR(order_date)";
$query = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($query)) {
    $years[] = $row['year'];
    $yearly_sales[] = $row['total_sales'];
}

?>
<main>
    <h1>Welcome, Farmers!</h1><br>
    <?php if (count($months) > 0) : ?>
        <div id="month">
            <div class="chart">
                <h2>Monthly Reports</h2>
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div id="year" style="display: none;">
            <div class="chart">
                <h2>Yearly Reports</h2>
                <canvas id="yearlyChart"></canvas>
            </div>
        </div>

        <!-- button to change the category -->
        <div class="category">
            <label for="category">Select Category:</label>
            <select id="category" onchange="changeCategory()">
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
    <?php endif; ?>

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

        // Get the logged-in user's ID from the session
        $user_id = $_SESSION['user_id'];

        // Use prepared statements to fetch products
        $stmt = $connection->prepare("SELECT * FROM products WHERE user_id = ?");
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
<script>
    function confirmLogout() {
        var confirmAction = confirm("Are you sure you want to log out?");
        if (confirmAction) {
            window.location.href = "logout.php";
        }
    }

    //code for the button that change the category if year or month
    function changeCategory() {
        var category = document.getElementById("category").value;
        if (category == "month") {
            document.getElementById("month").style.display = "block";
            document.getElementById("year").style.display = "none";
        } else {
            document.getElementById("month").style.display = "none";
            document.getElementById("year").style.display = "block";
        }
    }





    // Chart.js Code
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'line', 'pie', etc.
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Sales Per Farmer',
                    data: <?php echo json_encode($sales); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'green',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });
        var ctx2 = document.getElementById('yearlyChart').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar', // You can change this to 'line', 'pie', etc.
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [{
                    label: 'Sales Per Farmer',
                    data: <?php echo json_encode($yearly_sales); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'green',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
</body>

</html>
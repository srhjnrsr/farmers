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

?>
<style>
    main {

        background-color: whitesmoke;
        /* Light green background with slight transparency */
        padding: 50px;
        /* Adds padding inside the main section */
        border-radius: 10px;
        /* Rounds the corners of the main section */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Adds subtle shadow for depth */

        /* Adds top margin and centers the section horizontally */
        width: 70%;
        /* Sets the main section width to 70% of the container */
        max-width: 800px;
        /* Limits the max width of the section */
        border: 2px solid green;
    }

    .welcome-message {
        text-align: center;
        /* Centers the text inside the welcome message */
        margin-bottom: 30px;
        /* Adds space below the welcome message */
    }

    .welcome-message h1 {
        font-size: 2em;
        /* Increases the font size for the main heading */
        color: green;
        /* Sets green color for the heading */
    }

    .welcome-message p {
        font-size: 1.2em;
        /* Slightly increases the font size for the paragraph */
        color: black;
        /* Sets paragraph text color to black */
    }
</style>
<main>
    <div class="welcome-message">
        <h1>Welcome, Admin!</h1><br>
        <p>"Thank you for joining the Calamansi Farmers Dashboard. You have the tools to manage records, update pest and fertilizer details.
            Your efforts are vital in supporting our farmers. Together, we can enhance productivity and sustainability. "</p>
    </div>


    <div class="chart">
        <h2>Reports</h2>
        <canvas id="myChart"></canvas>
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
    });
</script>


</body>


</html>
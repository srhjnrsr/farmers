<?php

require 'layout/header.php';

if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'Farmer') {
    header("location: farmer_login.php");
    exit();
}

$sql = "SELECT o.order_id, p.product_name, o.quantity, o.total_price, o.order_status
        FROM orders o
        JOIN products p ON o.product_id = p.product_id
        WHERE p.user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);

$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result === false) {
    die('Error executing query: ' . $stmt->error);
}


?>
<style>
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Form styling */
    /* Form styling */
    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        /* Adjust the spacing between fields */
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    textarea {
        grid-column: span 2;
        /* Make the description span both columns */
    }

    button {
        padding: 8px 16px;
        margin: 4px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        background-color: #45a049;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }

    .full-width {
        grid-column: span 2;
        /* Span across both columns for full-width fields */
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }


    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #c0d3f5;
        ;
    }

    /* Action icons */
    .actions img {
        width: 20px;
        cursor: pointer;
        margin: 0 5px;
    }

    /* Update Button Specific Style */
    .update-btn {
        background-color: #4CAF50;
        /* Green for update */
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .update-btn:hover {
        background-color: #45a049;
        /* Darker green on hover */
    }

    /* Delete Button Specific Style */
    .delete-btn {
        background-color: #d9534f;
        /* Red for delete */
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #c9302c;
        /* Darker red on hover */
    }

    h1 {
        text-align: left;
    }
</style>
<main>
    <div class="product-list">
        <h1>Orders</h1>

    </div>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Order Status</th>
            <th>Action</th>
        </tr>
        <?php while ($order = $order_result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo $order['order_status']; ?></td>
                <?php if ($order['order_status'] === 'Pending') : ?>
                    <td>
                        <form action="order_approve.php" method="GET" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" class="update-btn">Approve</button>
                        </form>
                    </td>
                <?php else : ?>
                    <td>
                        <?php if ($order['order_status'] !== 'Delivered') : ?>
                            <button class="update-btn">
                                <a href="order_delivered.php?order_id=<?php echo $order['order_id']; ?>" style="color:white;">Mark as
                                    Delivered</button>
                        <?php endif; ?>

                        <button type="submit" class="update-btn" onclick="updateOrder(<?php echo $order['order_id']; ?>)">Update</button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>
</main>
</body>
<script>
    function updateOrder(order_id) {
        var confirmAction = confirm("Are you sure you want to update this order?");
        if (confirmAction) {
            var newStatus = prompt("Please enter enter any remarks:");
            if (newStatus) {
                window.location.href = "order_update.php?order_id=" + order_id + "&new_status=" + encodeURIComponent(newStatus);
            }
        }
        if (confirmAction) {
            window.location.href = "order_update.php?order_id=" + order_id + "&new_status=" + encodeURIComponent(newStatus);
        }
    }
</script>

</html>
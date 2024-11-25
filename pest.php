<?php
require 'layout/header.php'; // Include the header file
$sql = "SELECT * FROM pest WHERE is_archived = 0";
$result = $connection->query($sql);
?>

<main>
    <h2>Pest Data</h2>
    <div class="pest-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="pest-item">
                    <div class="pest-content">
                        <img src="<?php echo $row['image']; ?>" alt="Pest Image">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><strong>Causes:</strong> <?php echo $row['causes']; ?></p>
                        <p><strong>Solutions:</strong> <?php echo $row['solutions']; ?></p>
                    </div>
                </div>
                <hr>
        <?php
            }
        } else {
            echo "<p>No pest found.</p>";
        }
        ?>
    </div>
</main>
</body>

</html>
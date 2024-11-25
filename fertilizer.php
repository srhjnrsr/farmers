<?php
require 'layout/header.php'; // Include the header file
$sql = "SELECT * FROM fertilizers WHERE is_archived = 0"; // Updated query
$result = $connection->query($sql);
?>

<main>
    <h2>Fertilizer Data</h2>
    <div class="fertilizer-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="fertilizer-item">
                    <div class="fertilizer-content">
                        <img src="<?php echo $row['image']; ?>" alt="Fertilizer Image">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                        <p><strong>Applications:</strong> <?php echo $row['applications']; ?></p>
                        <p><strong>Method of Application:</strong> <?php echo $row['method']; ?></p>
                        <p><strong>Best For:</strong> <?php echo $row['best_for']; ?></p>
                    </div>
                </div>
                <hr>
        <?php
            }
        } else {
            echo "<p>No fertilizers found.</p>";
        }
        ?>
    </div>
</main>
</body>

</html>
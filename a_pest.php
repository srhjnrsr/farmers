<?php
require 'layout/header.php';
$sql = "SELECT * FROM pest";
$result = $connection->query($sql);
?>
<main style="margin-top: 40px;">
    <!-- Add New Record Button at the Top Left -->
    <button onclick="window.location.href='a_add_pest.html'" style="position: absolute; top: 150px; left: 20px; background-color: lightcoral;">
        Add New Record
    </button>
    <h2>Pest Data</h2>
    <div class="pest_fertilizer-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            echo '<table border="1">';
            echo '<thead>
                        <tr>
                            <th>Image</th>
                            <th>Pest Name</th>
                            <th>Causes</th>
                            <th>Solutions</th>
                            <th>Actions</th>
                        </tr>
                      </thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><img src="<?php echo $row['image']; ?>" alt="Pest Image" width="100"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['causes']; ?></td>
                    <td><?php echo $row['solutions']; ?></td>

                    <td>
                        <form action="a_update_pest.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="update-btn">Update</button>
                        </form>

                        <?php if ($row['is_archived']) { ?>
                            <form action="a_archived_pest.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to unarchive this record?');" class="unarchive-btn">Unarchive</button>
                            </form>
                        <?php } else { ?>
                            <form action="a_archived_pest.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to archive this record?');" class="archive-btn">Archive</button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
        <?php
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p>No pests found.</p>";
        }
        ?>
    </div>
</main>
</body>

</html>
<?php
require 'layout/header.php';
$sql = "SELECT * FROM fertilizers";
$result = $connection->query($sql);
?>
<main>

    <h2 style="margin: 15px 0;">Fertilizers Data</h2>
    <div class="pest_fertilizer-list">
        <?php
        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<thead>
                        <tr>
                            <th>Image</th>
                            <th>Fertilizer Name</th>
                            <th>Description</th>
                            <th>Applications</th>
                            <th>Method</th>
                            <th>Best For</th>
                            <th>Actions</th>
                        </tr>
                      </thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><img src="<?php echo $row['image']; ?>" alt="Fertilizer Image" width="100"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['applications']; ?></td>
                    <td><?php echo $row['method']; ?></td>
                    <td><?php echo $row['best_for']; ?></td>
                    <td>
                        <form action="a_update_fertilizers.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="update-btn">Update</button>
                        </form>

                        <?php if ($row['is_archived']) { ?>
                            <form action="a_archived_fertilizer.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to unarchive this record?');" class="unarchive-btn">Unarchive</button>
                            </form>
                        <?php } else { ?>
                            <form action="a_archived_fertilizer.php" method="POST" style="display: inline;">
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
            echo "<p>No fertilizers found.</p>";
        }
        ?>
        <button class="btn-record" onclick="window.location.href='a_add_fertilizers.html'" style="position: absolute; top: 150px; left: 70px; background-color: lightcoral; padding: 10px; border-radius: 5px;">
            Add New Record
        </button>
    </div>
</main>
</body>
<style>
    .update-btn,
    .unarchive-btn,
    .archive-btn{
        background: #60e758;
        border-radius: 5px;
        padding: 2px;
        margin-top: 5px;
        border-style: none;
        outline: 1px solid #858585;
        color: #1f1f20;
    }
    .update-btn{
        background: #5868e7;}
    .unarchive-btn{
        background: #dd2929;}
    .archive-btn{
        background: #60e758;}
</style>
</html>
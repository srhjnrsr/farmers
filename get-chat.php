
<?php

require "config/database.php";

if (isset($_SESSION['user_id'])) {
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = filter_var($_POST['incoming_id']);
    $output = "";
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.user_id = messages.outgoing_id
                WHERE (outgoing_id = {$outgoing_id} AND incoming_id = {$incoming_id})
                OR (outgoing_id = {$incoming_id} AND incoming_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($connection, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['outgoing_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['message'] . '</p>
                                </div>
                                </div>';
            } else {
                $output .= '<div class="chat incoming">
                               
                                <div class="details">
                                    <p>' . $row['message'] . '</p>
                                </div>
                                </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    header('location: ' . ROOT_URL . 'signin.php');
}

?>

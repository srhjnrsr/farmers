<?php
while ($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT * FROM messages WHERE(incoming_id = {$row['user_id']}
                OR outgoing_id = {$row['user_id']}) AND (outgoing_id = {$outgoing_id} 
                OR incoming_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result = "No message available";
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
    if (isset($row2['outgoing_id'])) {
        ($outgoing_id == $row2['outgoing_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }
    (isset($row['status']) && $row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
    ($outgoing_id == $row['user_id']) ? $hid_me = "hide" : $hid_me = "";

    $output .= '<a id="openChat" href="message.php?user_id=' . $row['user_id'] . '">
                    <div class="content">
                   
                    <div class="details">
                        <span>' . ucfirst($row['firstname']) . " " . ucfirst($row['surname']) . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
 // <img src="../images/' . $row['avatar'] . '" alt="">
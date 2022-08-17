<?php
function confirmetionreplay($chat_id)
{
    global $botAPI;
    global $con;
    $systemOwner = "SELECT * FROM system_owner ";
    $systemOwnerQuery = mysqli_query($con, $systemOwner);

    while ($ro = mysqli_fetch_array($systemOwnerQuery)) {

        $admin_id = $ro['telegram_id'];
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text=Dear Admin, There are a request for registration you need to approve");
    }
    disable($chat_id);
}
// $info = "";
//     $info .= "Your request have been received please await.";
//     file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $info . "&parse_mode=html");
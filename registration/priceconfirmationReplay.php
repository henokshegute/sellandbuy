<?php
function priceConfirmationReply($chat_id)
{
    global $botAPI;
    global $con;
    $companyowner = "SELECT * FROM company";
    $companyOwnerQuery = mysqli_query($con, $companyowner);

    while ($ro = mysqli_fetch_array($companyOwnerQuery)) {

        $admin_id = $ro['telegram_id'];
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text=Dear Admin, There are a request for registration you need to approve");
    }
    $info = "";
    $info .= "Your price request have successfully been sent.";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $info . "&parse_mode=html");
    buyerAdminMainMenu($chat_id);
}
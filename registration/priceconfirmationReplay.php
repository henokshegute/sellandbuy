<?php
function priceConfirmationReply($chat_id)
{
    global $botAPI;
    global $con;
    $companyowner = "SELECT * FROM company";
   $companyOwnerQuery = mysqli_query($con, $companyowner);

    while ($ro = mysqli_fetch_array($companyOwnerQuery)) {

        $admin_id = $ro['telegram_id'];
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text=Dear Owner, There is a price request you need to approve.");
    }
    $info = "";
    $info .= "Your price request have been sent.";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $info . "&parse_mode=html");
    buyerAdminMainMenu($chat_id);
} 
function pickingConfirmationReply($chat_id)
{
    global $botAPI;
    global $con;
    $companyowner = "SELECT * FROM company";
   $companyOwnerQuery = mysqli_query($con, $companyowner);

    while ($ro = mysqli_fetch_array($companyOwnerQuery)) {

        $admin_id = $ro['telegram_id'];
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text=Dear Owner, There is a price request you need to approve.");
    }
    $info = "";
    $info .= "Your price request have been sent.";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $info . "&parse_mode=html");
    buyerAdminMainMenu($chat_id);
} 
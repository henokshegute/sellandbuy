<?php
function ownerMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Approve Company"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function  companyAdminMainMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register Admin")); ///, array("Register Buyer"), array("Buy"), array("Report")
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerAdminMainMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register Buyer"), array("Report"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Buy"), array("Add New Seller"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
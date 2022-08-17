<?php
function ownerMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Approve Company"));
    print_r($keyboard);
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function  companyAdminMainMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register Admin"), array("Approve Price"));
    ///, array("Register Buyer"), array("Buy"), array("Report")
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerAdminMainMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register New Buyer","Add Scale Man"), array("Report", "Request Price"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Buy"), array("Add Scale Man"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function reportSorting($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Daily"), array("By Contarct"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please choose the type of report you want &reply_markup=" . $reply);
}

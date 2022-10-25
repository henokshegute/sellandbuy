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
    $keyboard = array(array("Register Admin"), array("Approve Price", "Approve Rate"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function superAdminMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register Scale Man", "Add New Seller"), array("Report", "Request Price"), array("Add New Farm", "Picking Rate"), array("Add Farm Admin"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerAdminMainMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Add New Seller"), array("Register Scale Man"), array("Report"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function buyerMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Buy", "Collect"), array("Add New Picker", "Add New Seller"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Welcome &reply_markup=" . $reply);
}
function reportType($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Picking", "Transaction"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please choose the type of report you want &reply_markup=" . $reply);
}
function reportSorting($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Daily", "By Farm"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please choose the type of report you want &reply_markup=" . $reply);
}
function gender($chat_id)
{
    global $botAPI;
    $keyboard = array(array("MALE"), array("FEMALE"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Gender. &reply_markup=" . $reply);
}

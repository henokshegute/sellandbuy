<?php
function search($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("🔍 Search"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please press the search button from the menu to access registered sellers. &reply_markup=" . $reply);
}
    

<?php
function companyRegitsrationMenu($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Register"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= Crossroads PLC welcomes you please register &reply_markup=" . $reply);
}

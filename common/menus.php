<?php
function disable($chat_id)
{
    global $botAPI;
    $keyboard = array(array(" "));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text= when you get notification you press start from the left menu with three Icon &reply_markup=" . $reply);
}
function disableForwarding($chat_id)
{
    global $botAPI;
    $keyboard = array(array("/start"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=you can't forward location!please send the location directly &reply_markup=" . $reply);
}
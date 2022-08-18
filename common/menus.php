<?php
function disable($chat_id)
{
    global $botAPI;
    $keyboard = array(array(" "));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    $info = "Your company details have been successfully recived. Please await response.";

    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $info . "&reply_markup=" . $reply);
}
function disableForwarding($chat_id)
{
    global $botAPI;
    $keyboard = array(array("/start"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=you can't forward location!please send the location directly &reply_markup=" . $reply);
}
$message = "please press the" . " " . "/start" . " " . "command from the left hand-side menu with three bars.";

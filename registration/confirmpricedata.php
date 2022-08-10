<?php
function priceConfirmation($chat_id)
{
    global $con;
    global $botAPI;
    $keyboard = array(array("Confirm Request", "Discard Request"));
    $listStatement = "SELECT * From price_temp";
    $listQuery = mysqli_query($con, $listStatement);

    while ($ro = mysqli_fetch_array($listQuery)) {
        $price_id = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $contract_name = $ro['contract_name'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Coffee contract name:- </b>" . strtolower($contract_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $hel = "<b>CONFIRM</b>%0A";
    $hel .= $marksHTML;
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&reply_markup=" . $reply."&parse_mode=html");
}

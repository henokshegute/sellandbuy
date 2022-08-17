<?php
function listRequestedPrice($chat_id)
{
    global $con;
    global $botAPI;
    $listStatement = "SELECT * From price_temp";
    $listQuery = mysqli_query($con, $listStatement);

    if (mysqli_num_rows($listQuery) > 0) {

        while ($ro = mysqli_fetch_array($listQuery)) {
            $telegram_id = $ro['telegram_id'];
            $price = $ro['price'];
            $contract_name = $ro['contract_name'];
            $date_registered = $ro['date_registered'];
            $marksHTML = "";

            $marksHTML .= "<b>Coffee contract name:-</b>" . strtolower($contract_name) . "%0A";
            $marksHTML .= "<b>Requested Price:-</b>" . strtolower($price) . "%0A";
            $hel = "<b>Aprove:</b>%0A";
            $hel .= $marksHTML;
            $acceptCompany = "a ";
            $acceptCompany .=  $telegram_id;
            $delete = "n ";
            $delete .= $telegram_id;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " ✔️ Accept", "callback_data" => $acceptCompany],
                ["text" => " ❌ Decline", "callback_data" => $delete],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no requestes");
    }
}

function accept($id, $chat_id, $message_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From price_temp ";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {
        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $contract_name = $ro['contract_name'];
        $date_registered = $ro['date_registered'];
    }
    $updatePriceTable = "INSERT INTO price(telegram_id,contract_name,price,date_registered) VALUES('$telegram_id','$contract_name','$price','$today')";
    mysqli_query($con,  $updatePriceTable);
    $del = "DELETE FROM price_temp WHERE telegram_id='$id' && id='$priceid'";
    mysqli_query($con, $del);
    $marksHTML = "";
    $marksHTML .= "<b>Coffee contract name:- </b>" . strtolower($contract_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Price request is approved!!!" . "%0A";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $approve_as_user = "a ";
    $approve_as_user .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "✔️ Approved", "callback_data" => $approve_as_user],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}
function declinePrice($id, $chat_id, $message_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From price_temp ";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {

        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $contract_name = $ro['contract_name'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Coffee contract name:- </b>" . strtolower($contract_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Price request is not approved!!!" . "%0A";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $del = "DELETE FROM price_temp WHERE telegram_id='$id' && id='$priceid'";
    mysqli_query($con, $del);
    
    //file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text=Your price request is not approved!!!");
    $approve_as_user = "n ";
    $approve_as_user .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "❌ Declined", "callback_data" => $approve_as_user],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}

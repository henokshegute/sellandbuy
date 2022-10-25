<?php
function listRequestedPrice($chat_id)
{
    global $con;
    global $botAPI;
    $listStatement = "SELECT * From price_temp";
    $listQuery = mysqli_query($con, $listStatement);

    if (mysqli_num_rows($listQuery) > 0) {

        while ($ro = mysqli_fetch_array($listQuery)) {
            $priceId=$ro['id'];
            $telegram_id = $ro['telegram_id'];
            $price = $ro['price'];
            $contract_name = $ro['contract_name'];
            $date_registered = $ro['date_registered'];
            $marksHTML = "";
            $marksHTML .= "<b>Farm name:-</b>" . strtolower($contract_name) . "%0A";
            $marksHTML .= "<b>Requested Price:-</b>" . strtolower($price) . "%0A";
            $hel = "<b>APPROVE:</b>%0A";
            $hel .= $marksHTML;
            $acceptCompany = "a ";
            $acceptCompany .=  $telegram_id." ".$priceId;
            $delete = "n ";
            $delete .= $telegram_id." ".$priceId;
            $change = "c ";
            $change .= $telegram_id." ".$priceId;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " ✔️ Accept", "callback_data" => $acceptCompany],
                ["text" => " ❌ Decline", "callback_data" => $delete],
                ["text" => " 📝 Change", "callback_data" => $change],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no price requests at this time.");
    }
}

function accept($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From price_temp where id='$priceId'";
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
    $marksHTML .= "<b>Farm name:- </b>" . strtolower($contract_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Price request is approved." . "%0A";
    $marksHTML .= "NOTE:- This price is only valid for 30 days.";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $approve_as_user = "a ";
    $approve_as_user .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "✔️ Approved", "callback_data" => $approve_as_user],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}
function declinePrice($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From price_temp where id='$priceId' ";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {

        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $contract_name = $ro['contract_name'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Farm name:- </b>" . strtolower($contract_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Price request is not approved, please contact owner." . "%0A";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $del = "DELETE FROM price_temp WHERE telegram_id='$id' && id='$priceid'";
    mysqli_query($con, $del);
    $approve_as_user = "n ";
    $approve_as_user .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "❌ Declined", "callback_data" => $approve_as_user],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}
function changeprice($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From price_temp where id='$priceId' ";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {

        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
      //  $admin_telegram_id = $ro['admin_telegram_id'];
        $price = $ro['price'];
        $contract_name = $ro['contract_name'];
        $date_registered = $ro['date_registered'];
    }
    $con->query("INSERT INTO edit_price(telegram_id,admin_telegram_id,contract_name,date_registered) VALUES('$chat_id',$id,'$contract_name','$today')");
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the change in price.");
    $con->query("DELETE FROM price_temp WHERE telegram_id='$id' && id='$priceid'");
}


/////////////////////////////////////
function listPickengRate($chat_id)
{
    global $con;
    global $botAPI;
    $listStatement = "SELECT * From picking_ratetemp ";
    $listQuery = mysqli_query($con, $listStatement);

    if (mysqli_num_rows($listQuery) > 0) {

        while ($ro = mysqli_fetch_array($listQuery)) {
            $telegram_id = $ro['telegram_id'];
            $price = $ro['price'];
            $farm_name = $ro['farm_name'];
            $date_registered = $ro['date_registered'];
            $marksHTML = "";
            $marksHTML .= "<b>Farm name:-</b>" . strtolower($farm_name) . "%0A";
            $marksHTML .= "<b>Requested rate:-</b>" . strtolower($price) . "%0A";
            $hel = "<b>Aprove:</b>%0A";
            $hel .= $marksHTML;
            $acceptRate = "acceptRate ";
            $acceptRate .=  $telegram_id;
            $deleteRate = "declineRate ";
            $deleteRate .= $telegram_id;
            $changeRate = "changeRate ";
            $changeRate .= $telegram_id;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " ✔️ Accept", "callback_data" => $acceptRate],
                ["text" => " ❌ Decline", "callback_data" => $deleteRate],
                ["text" => " 📝 Change", "callback_data" => $changeRate],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no picknig rate requests at this time.");
    }
}
//////////////////////////////////////////////
function acceptRate($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From picking_ratetemp where='$priceId'";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {
        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $farm_name = $ro['farm_name'];
        $date_registered = $ro['date_registered'];
    }
    $updatePriceTable = "INSERT INTO picking_rate(telegram_id,farm_name,price,date_registered) VALUES('$telegram_id','$farm_name','$price','$today')";
    mysqli_query($con,  $updatePriceTable);
    $del = "DELETE FROM picking_ratetemp WHERE telegram_id='$id' && id='$priceid'";
    mysqli_query($con, $del);
    $marksHTML = "";
    $marksHTML .= "<b>Farm name:- </b>" . strtolower($farm_name) . "%0A";
    $marksHTML .= "<b>Requested price:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Picking Rate request is approved." . "%0A";
    $marksHTML .= "NOTE:- This rate is only valid for 30 days.";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $acceptRate = "acceptRate ";
    $acceptRate .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "✔️ Approved", "callback_data" => $acceptRate],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}

function declineRate($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From picking_ratetemp id='$priceId'";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {

        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $price = $ro['price'];
        $farm_name = $ro['farm_name'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Farm name:- </b>" . strtolower($farm_name) . "%0A";
    $marksHTML .= "<b>Requested rate:-</b>" . strtolower($price) . "%0A";
    $marksHTML .= "Picking rate request is not approved, please contact owner." . "%0A";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text= " . $marksHTML . "&parse_mode=html");
    $del = "DELETE FROM picking_ratetemp WHERE telegram_id='$id' && id='$priceid'";
    mysqli_query($con, $del);
    $changeRate = "declineRate ";
    $changeRate .= $chat_id;
    $keyboard = json_encode(["inline_keyboard" => [[
        ["text" => "❌ Declined", "callback_data" => $changeRate],
    ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
    file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
}
function changerate($id, $chat_id, $message_id,$priceId)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listStatement = "SELECT * From picking_ratetemp where ='$priceId'";
    $listQuery = mysqli_query($con, $listStatement);
    while ($ro = mysqli_fetch_array($listQuery)) {

        $priceid = $ro['id'];
        $telegram_id = $ro['telegram_id'];
        $admin_telegram_id = $ro['admin_telegram_id'];
        $price = $ro['price'];
        $farm_name = $ro['farm_name'];
        $date_registered = $ro['date_registered'];
    }
    $con->query("INSERT INTO edit_rate(telegram_id,admin_telegram_id,farm_name,date_registered) VALUES('$chat_id',$id,'$farm_name','$today')");
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the change in price.");
    $con->query("DELETE FROM picking_ratetemp WHERE telegram_id='$id' && id='$priceid'");
}

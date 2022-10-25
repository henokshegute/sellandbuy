<?php
function confirmTransaction($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Transaction", "Discard Transaction"));
    $marksHTML = "";
    $hel = "<b>Confirm</b>%0A";
    $checkTransactionExistance = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
        $buyer_telegram_id = $ro['buyer_telegram_id'];
        $zone = $ro['zone'];
        $neighborhood = $ro['neighborhood'];
        $contract_name = $ro['contract_name'];
        // $process = $ro['process'];
        $seller_name = $ro['seller_name'];
        // $coffee_grade = $ro['coffee_grade'];
        $quantity = $ro['quantity'];
        $price = $ro['price'];
        $location = $ro['location'];
        $total = $ro['total'];
        $picture = $ro['picture'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Seller name :- </b>" . strtolower($seller_name) . "%0A";
    $marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
    $marksHTML .= "<b>Zone :- </b>" . strtolower($zone) . "%0A";
    $marksHTML .= "<b>Neighborhood :- </b>" . strtolower($neighborhood) . "%0A";
    $marksHTML .= "<b>Origin:- </b>" . strtolower($contract_name) . "%0A";
    // $marksHTML .= "<b>Process:- </b>" . strtolower($process) . "%0A";
    // $marksHTML .= "<b>Coffee_grade:- </b>" . strtolower($coffee_grade) . "%0A";
    $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
    $marksHTML .= "<b>1kg price :- </b>" . strtolower($price) . "%0A";
    $marksHTML .= "<b>Total price :- </b>" . strtolower($total) . "%0A";
    $hel .= $marksHTML;
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&parse_mode=html" . "&reply_markup=" . $reply);
}
function confirmCollecting($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Process", "Discard Process"));
    $marksHTML = "";
    $hel = "<b>Confirm</b>%0A";
    $checkCollectingExistance = "SELECT * FROM collecting_temp WHERE buyer_telegram_id='$chat_id'";
    $checkcollectingExistanceQuery = mysqli_query($con, $checkCollectingExistance);
    while ($ro = mysqli_fetch_array($checkcollectingExistanceQuery)) {
        $buyer_telegram_id = $ro['buyer_telegram_id'];
        $farm_name = $ro['farm_name'];
        $picker_name = $ro['picker_name'];
        $quantity = $ro['quantity'];
        $price = $ro['rate'];
        $total = $ro['total'];
        $picture = $ro['picture'];
        // $zone = $ro['zone'];
        // $neighborhood = $ro['neighborhood'];
        // $process = $ro['process'];
        // $coffee_grade = $ro['coffee_grade'];
        // $location = $ro['location'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Picker name :- </b>" . strtolower($picker_name) . "%0A";
    $marksHTML .= "<b>Origin:- </b>" . strtolower($farm_name) . "%0A";
    // $marksHTML .= "<b>Process:- </b>" . strtolower($process) . "%0A";
    // $marksHTML .= "<b>Coffee_grade:- </b>" . strtolower($coffee_grade) . "%0A";
    $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
    $marksHTML .= "<b>1kg Rate :- </b>" . strtolower($price) . "%0A";
    $marksHTML .= "<b>Total Picking price :- </b>" . strtolower($total) . "%0A";
    $hel .= $marksHTML;
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&parse_mode=html" . "&reply_markup=" . $reply);
}

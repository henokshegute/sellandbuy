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
        $origion = $ro['origion'];
        $process = $ro['process'];
        $seller_name = $ro['seller_name'];
        $coffee_grade = $ro['coffee_grade'];
        $quantity = $ro['quantity'];
        $price = $ro['price'];
        $location = $ro['location'];
    }
    $marksHTML = "";
    $marksHTML .= "seller_name :- " . strtolower($seller_name) . "%0A";
    $marksHTML .= "location :- " . strtolower($location) . "%0A";
    $marksHTML .= "Zone :- " . strtolower($zone) . "%0A";
    $marksHTML .= "neighborhood :- " . strtolower($neighborhood) . "%0A";
    $marksHTML .= "origin:- " . strtolower($origion) . "%0A";
    $marksHTML .= "process:- " . strtolower($process) . "%0A";
    $marksHTML .= "coffee_grade:- " . strtolower($coffee_grade) . "%0A";
    $marksHTML .= "quantity :- " . strtolower($quantity) . "%0A";
    $marksHTML .= "price per kg :- " . strtolower($price) . "%0A";
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

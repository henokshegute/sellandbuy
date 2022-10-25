<?php
function saveTransactiondata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $checkTransactionExistance = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
        $buyer_telegram_id = $ro['buyer_telegram_id'];
        $zone = $ro['zone'];
        $neighborhood = $ro['neighborhood'];
        $contract_name = $ro['contract_name'];
        //$process = $ro['process'];
        $seller_name = $ro['seller_name'];
        //$coffee_grade = $ro['coffee_grade'];
        $quantity = $ro['quantity'];
        $price = $ro['price'];
        $total = $ro['total'];
        $location = $ro['location'];
        $picture = $ro['picture'];
        $longitude = $ro['longitude'];
        $latitude = $ro['latitude'];
        $transaction_date = $ro['transaction_date'];
    }
    $saveTransactionDataToMain = "INSERT INTO transaction (buyer_telegram_id,seller_name,picture,location,longitude,latitude,zone,
    neighborhood,contract_name,quantity,price,total,transaction_date) 
    VALUE('$buyer_telegram_id','$seller_name','$picture','$location','$longitude','$latitude',
    '$zone','$neighborhood','$contract_name','$quantity','$price','$total','$transaction_date') ";
    mysqli_query($con, $saveTransactionDataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=transaction data saved successfully");
    $delettransactionfromtemp = "DELETE FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    mysqli_query($con, $delettransactionfromtemp);
}
function saveCollectingdata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $checkTransactionExistance = "SELECT * FROM collecting_temp WHERE buyer_telegram_id='$chat_id'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
        $buyer_telegram_id = $ro['buyer_telegram_id'];
        $farm_name = $ro['farm_name'];
        $seller_name = $ro['picker_name'];
        $quantity = $ro['quantity'];
        $price = $ro['rate'];
        $total = $ro['total'];
        $picture = $ro['picture'];
        $collecting_date = $ro['collecting_date'];
        // $zone = $ro['zone'];
        // $neighborhood = $ro['neighborhood'];
        //$process = $ro['process'];
        //$coffee_grade = $ro['coffee_grade'];
        // $location = $ro['location'];
        // $longitude = $ro['longitude'];
        // $latitude = $ro['latitude'];
    }
    $saveTransactionDataToMain = "INSERT INTO collecting (buyer_telegram_id,picker_name,picture,
  farm_name,quantity,rate,total,collecting_date) 
    VALUE('$buyer_telegram_id','$seller_name','$picture','$farm_name','$quantity','$price','$total','$collecting_date') ";
    mysqli_query($con, $saveTransactionDataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Entry saved successfully");
    $delettransactionfromtemp = "DELETE FROM collercting_temp WHERE buyer_telegram_id='$chat_id'";
    mysqli_query($con, $delettransactionfromtemp);
}

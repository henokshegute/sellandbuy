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
        $origion = $ro['origion'];
        $process = $ro['process'];
        $seller_name = $ro['seller_name'];
        $coffee_grade = $ro['coffee_grade'];
        $quantity = $ro['quantity'];
        $price = $ro['price'];
        $location = $ro['location'];
        $transaction_date = $ro['transaction_date'];
    }
    $saveTransactionDataToMain = "INSERT INTO transaction (buyer_telegram_id,seller_name,location,zone,neighborhood,origion,process,coffee_grade,quantity,price,picture,transaction_date) VALUE('$buyer_telegram_id','$seller_name','$location','$zone','$neighborhood','$origion','$process','$coffee_grade','$quantity','$price','$transaction_date') ";
    mysqli_query($con, $saveTransactionDataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=transaction data saved successfully");
    $delettransactionfromtemp = "DELETE FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    mysqli_query($con, $delettransactionfromtemp);
}

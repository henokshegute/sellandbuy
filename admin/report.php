<?php
function report($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set("Africa/Addis_Ababa");
    $today = date('y-m-d');
    $listDailyTransaction = "SELECT * FROM transaction where transaction_date= '$today'";
    $listDailyTransactionQuery = mysqli_query($con, $listDailyTransaction);
    $TransactionRow = mysqli_num_rows($listDailyTransactionQuery);
    if ($TransactionRow > 0) {
        while ($ro = mysqli_fetch_array($listDailyTransactionQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $seller_name = $ro['seller_name'];
            $location = $ro['location'];
            $coffe_type = $ro['coffee_type'];
            $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $picture = $ro['picture'];
            $transaction_date = $ro['transaction_date'];
            $hel = "<b>TRANSACTION REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "seller_name :- " . strtolower($seller_name) . "%0A";
            $marksHTML .= "location :- " . strtolower($location) . "%0A";
            $marksHTML .= "coffee_type:- " . strtolower($coffe_type) . "%0A";
            $marksHTML .= "coffee_grade:- " . strtolower($coffee_grade) . "%0A";
            $marksHTML .= "quantity :- " . strtolower($quantity) . "%0A";
            $marksHTML .= "price :- " . strtolower($price) . "%0A";
            $hel .= $marksHTML;
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html");
            buyerAdminMainMenu($chat_id);
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There is no transaction performed Today &parse_mode=html");
        buyerAdminMainMenu($chat_id);
    }
}

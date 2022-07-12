<?php
function confirmSeller($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Seller", "Dicard Seller"));
    $marksHTML = "";
    $marksHTMLL = "";
    $hel = "<b>Confirm</b>%0A";
    $checkSellerTempExistance = "SELECT * FROM company_users WHERE admin_telegram_id ='$chat_id'";
    $checkSellerTempExistanceQuery = mysqli_query($con, $checkSellerTempExistance);
    $sellerRow = mysqli_num_rows($checkSellerTempExistanceQuery);
    while ($ro = mysqli_fetch_array($checkSellerTempExistanceQuery)) {

        $adminTelegram_id = $ro['admin_telegram_id'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $woreda = $ro['woreda'];
        $neighborhood = $ro['neighborhood'];
        $phone_number = $ro['phone_number'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "seller_name :- " . strtolower($firstname) . "%0A";
    $marksHTML .= "laction :- " . strtolower($lastname) . "%0A";
    $marksHTML .= "coffee_type:- " . strtolower($woreda) . "%0A";
    $marksHTML .= "coffee_grade:- " . strtolower($neighborhood) . "%0A";
    $marksHTML .= "quantity :- " . strtolower($phone_number) . "%0A";
    $marksHTML .= "price :- " . strtolower($date_registered) . "%0A";
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

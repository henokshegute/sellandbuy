<?php
function confirmSeller($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Seller", "Discard Seller"));
    $marksHTML = "";
    $hel = "DETAIL %0A";
    $checkSellerTempExistance = "SELECT * FROM sellers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkSellerTempExistanceQuery = mysqli_query($con, $checkSellerTempExistance);
    $sellerRow = mysqli_num_rows($checkSellerTempExistanceQuery);
    while ($ro = mysqli_fetch_array($checkSellerTempExistanceQuery)) {

        $adminTelegram_id = $ro['admin_telegram_id'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $picture=$ro['picture'];
        $woreda = $ro['woreda'];
        $neighborhood = $ro['neighborhood'];
        $phone_number = $ro['phone_number'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "Firstname :- " . strtolower($firstname) . "%0A";
    $marksHTML .= "Lastname:- " . strtolower($lastname) . "%0A";
    $marksHTML .= "Woreda:- " . strtolower($woreda) . "%0A";
    $marksHTML .= "Neighborhood:- " . strtolower($neighborhood) . "%0A";
    $marksHTML .= "Phone number :- " . strtolower($phone_number) . "%0A";
    $marksHTML .= "Date :- " . strtolower($date_registered) . "%0A";
    $hel .= $marksHTML;
   // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html");
   file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=".$picture."&caption=".$hel); 
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

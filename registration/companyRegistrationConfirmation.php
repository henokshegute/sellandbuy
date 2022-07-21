<?php
function confirmCompanyData($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Company", "Discard Registration"));
    $marksHTML = "";
    $marksHTMLL = "";
    $hel = "<b>Confirm</b>%0A";
    $sql = "select * from company_temp where telegram_id ='$chat_id'";
    $rep = mysqli_query($con, $sql);
    while ($ro = mysqli_fetch_array($rep)) {
        $telegram_id = $ro['telegram_id'];
        $company_name = $ro['company_name'];
        $phone_number = $ro['phone_number'];
        $ownrs_name = $ro['owners_name'];
    }
    $marksHTML .= "Name :- " . strtolower($company_name). "%0A";
    $marksHTML .= "Phone Number :- " . strtolower($phone_number) . "%0A";
    $marksHTML .= "General Manager:- " . strtolower($ownrs_name) . "%0A";
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "%20" . $marksHTMLL . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

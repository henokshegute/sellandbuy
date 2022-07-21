<?php
function confirmUserData($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Admin", "Dicard Admin"));
    $marksHTML = "";
    $marksHTMLL = "";
    $hel = "<b>Confirm</b>%0A";
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id  ='$chat_id'";
    $checkUserTempExistanceQuery = mysqli_query($con, $checkUserTempExistance);

    while ($ro = mysqli_fetch_array($checkUserTempExistanceQuery)) {
        $companyTelegram_id = $ro['company_telegram_id'];
        $phonenumber = $ro['phone_number'];
        $telegram_username = $ro['telegram_username'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $woreda = $ro['woreda'];
        $kebele = $ro['kebele'];
        $role = $ro['role'];
    }

    $marksHTML .= "firstname :- " . $firstname;
    $marksHTML .= "lastname :- " . $lastname;
    $marksHTML .= "woreda :- " . $woreda;
    $marksHTML .= "kebele :- " . $kebele;
    $marksHTML .= "role :- " . $role;
    $marksHTML .= "phonenumber :- " . $phonenumber;
    $hel .= rawurlencode($marksHTML);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "%20" . $marksHTMLL . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}
function confirmBuyerUserData($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Buyer", "Dicard Buyer"));
    $marksHTML = "";
    $marksHTMLL = "";
    $hel = "<b>Confirm</b>%0A";
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id  ='$chat_id'";
    $checkUserTempExistanceQuery = mysqli_query($con, $checkUserTempExistance);

    while ($ro = mysqli_fetch_array($checkUserTempExistanceQuery)) {
        $companyTelegram_id = $ro['company_telegram_id'];
        $phonenumber = $ro['phone_number'];
        $telegram_username = $ro['telegram_username'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $woreda = $ro['woreda'];
        $role = $ro['role'];
    }

    $marksHTML .= "firstname :- " . strtolower($firstname) . '%0A';
    $marksHTML .= "lastname :- " . strtolower($lastname) . '%0A';
    $marksHTML .= "woreda :- " . strtolower($woreda) . '%0A';
    $marksHTML .= "role :- " . strtolower($role) . '%0A';
    $marksHTML .= "phonenumber :- " . strtolower($phonenumber) . '%0A';
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "%20" . $marksHTMLL . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

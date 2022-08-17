<?php
function confirmUserData($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm New Admin", "Discard New Admin"));
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

    $marksHTML .= "<b>First name :-</b> " . strtolower($firstname)."%0A";
    $marksHTML .= "<b>Last name :- </b>" .strtolower($lastname)."%0A";
    $marksHTML .= "<b>Woreda :-</b> " . strtolower($woreda)."%0A";
    $marksHTML .= "<b>Role :-</b> " . strtolower($role)."%0A";
    $marksHTML .= "<b>Phone number</b> :- " . strtolower($phonenumber)."%0A";
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "%20" . $marksHTMLL . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}
function confirmBuyerUserData($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm Scale Man", "Discard Scale Man"));
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

    $marksHTML .= "<b>First name :-</b>" . strtolower($firstname) . '%0A';
    $marksHTML .= "<b>Last name :-</b> " . strtolower($lastname) . '%0A';
    $marksHTML .= "<b>Woreda :-</b> " . strtolower($woreda) . '%0A';
    $marksHTML .= "<b>Role :-</b> " . strtolower($role) . '%0A';
    $marksHTML .= "<b>Phone number :-</b> " . strtolower($phonenumber) . '%0A';
    $hel .= $marksHTML;
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "%20" . $marksHTMLL . "&parse_mode=html");
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please Confirm: &reply_markup=" . $reply);
}

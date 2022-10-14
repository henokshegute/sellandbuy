<?php
function confirmPicker($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("Confirm New Picker", "Discard New Picker"));
    $marksHTML = "";
    $hel = "DETAIL %0A";
    $checkPickerTempExistance = "SELECT * FROM pickers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkPickerTempExistanceQuery = mysqli_query($con, $checkPickerTempExistance);
    $PickrRow = mysqli_num_rows($checkPickerTempExistanceQuery);
    while ($ro = mysqli_fetch_array($checkPickerTempExistanceQuery)) {

        $adminTelegram_id = $ro['admin_telegram_id'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $gender = $ro['gender'];
        $age = $ro['age'];
        $picture = $ro['picture'];
        $woreda = $ro['woreda'];
        $neighborhood = $ro['neighborhood'];
        $date_registered = $ro['date_registered'];
    }
    $marksHTML = "";
    $marksHTML .= "First name :- " . strtolower($firstname) . "%0A";
    $marksHTML .= "Last name:- " . strtolower($lastname) . "%0A";
    $marksHTML .= "Woreda:- " . strtolower($woreda) . "%0A";
    $marksHTML .= "Neighborhood:- " . strtolower($neighborhood) . "%0A";
    $marksHTML .= "Date :- " . strtolower($date_registered) . "%0A";
    $hel .= $marksHTML;
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&reply_markup=" . $reply);
}

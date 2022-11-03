<?php
function listrequesteduser($chat_id)
{
    global $botAPI;
    global $con;
    $company_temp = "SELECT * FROM company_temp";
    $company_temp_query = mysqli_query($con, $company_temp);
    $systemOwner = "SELECT * FROM system_owner ";
    $systemOwnerQuery = mysqli_query($con, $systemOwner);
    while ($ro = mysqli_fetch_array($systemOwnerQuery)) {
        $admin_id = $ro['telegram_id'];
    }
    if (mysqli_num_rows($company_temp_query) > 0)
        while ($ro = mysqli_fetch_array($company_temp_query)) {

            $telegram_id = $ro['telegram_id'];
            $company_name = $ro['company_name'];
            $phone_number = $ro['phone_number'];
            $ownrs_name = $ro['owners_name'];
            $marksHTML = "";

            $marksHTML .= "Company name :- " . strtolower($company_name) . "%0A";
            $marksHTML .= "Phone Number :- " .  strtolower($phone_number) . "%0A";
            $marksHTML .= "General Manager:- " . strtolower($ownrs_name) . "%0A";
            $hel = "<b>Aprove:</b>%0A";
            $hel .= $marksHTML;
            $acceptCompany = "e ";
            $acceptCompany .=  $telegram_id . " " . "default";
            $delete = "d ";
            $delete .= $telegram_id . " " . "default";
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " ✔️ User", "callback_data" => $acceptCompany],
                ["text" => " ❌ Delete", "callback_data" => $delete],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
        }
    else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_id . "&text=There is no registration requestes for now");
    }
}

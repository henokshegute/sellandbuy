<?php
function savedata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id ='$chat_id' && role='admin'";
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
    $saveUserdataToMain = "INSERT INTO company_users (company_telegram_id,phone_number,telegram_username,firstname,lastname,woreda,role,date_registered) VALUE('$companyTelegram_id','$phonenumber','$telegram_username','$firstname','$lastname','$woreda','$role','$today') ";
    mysqli_query($con, $saveUserdataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Admin added successfully");
    $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE telegram_username='$telegram_username'";
    mysqli_query($con, $deletadmindatafromtemp);
}
function savebuyerdata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id ='$chat_id' && role='buyer'";
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
    $saveUserdataToMain = "INSERT INTO company_users (company_telegram_id,phone_number,telegram_username,firstname,lastname,woreda,role,date_registered) VALUE('$companyTelegram_id','$phonenumber','$telegram_username','$firstname','$lastname','$woreda','$role','$today') ";
    mysqli_query($con, $saveUserdataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Buyer added successfully");
    $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE telegram_username='$telegram_username'";
    mysqli_query($con, $deletadmindatafromtemp);
}
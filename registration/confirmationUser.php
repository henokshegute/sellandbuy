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
    $selectownerscompany = "SELECT * FROM company where telegram_id='$chat_id'";
    $selectownerscompanyQuery = mysqli_query($con, $selectownerscompany);
    while ($co = mysqli_fetch_array($selectownerscompanyQuery)) {
        $companyName = $co['company_name'];
    }
    $pass = 123456789;
    $passhash = password_hash("$pass", PASSWORD_DEFAULT);
    $saveUserdataToMain = "INSERT INTO company_users (company_telegram_id,phone_number,telegram_username,firstname,lastname,woreda,role,date_registered,company_name,password) VALUE('$companyTelegram_id','$phonenumber','$telegram_username','$firstname','$lastname','$woreda','$role','$today','$companyName','$passhash') ";
    mysqli_query($con, $saveUserdataToMain);
    $conc = "Dear Owner, " . "%0A";
    $roleBold = "<b>$role</b>";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $conc . "Please forward the message below to this username @" . $telegram_username);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please user you have been registered as " . $roleBold . " for ($companyName). In order to access the bot please click the following link. @MytrstingBot &parse_mode=html");
    $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE telegram_username='$telegram_username'";
    mysqli_query($con, $deletadmindatafromtemp);
}
function savebuyerdata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id ='$chat_id' && role='scale man'";
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
    $selectownerscompany = "SELECT * FROM company where telegram_id='$companyTelegram_id'";
    $selectownerscompanyQuery = mysqli_query($con, $selectownerscompany);
    while ($co = mysqli_fetch_array($selectownerscompanyQuery)) {
        $companyName = $co['company_name'];
    }
    $saveUserdataToMain = "INSERT INTO company_users (company_telegram_id,phone_number,telegram_username,firstname,lastname,woreda,role,date_registered,company_name) VALUE('$companyTelegram_id','$phonenumber','$telegram_username','$firstname','$lastname','$woreda','$role','$today','$companyName') ";
    mysqli_query($con, $saveUserdataToMain);
    $conc = "Dear Admin, " . "%0A";
    $roleBold = "<b>$role</b>";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $conc . "Please forward the message below to this username @$telegram_username.");
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please user you have been registered as " . $roleBold . " for $companyName company. In order to access the bot please click the following  link. @MytrstingBot&parse_mode=html");
    $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE telegram_username='$telegram_username'";
    mysqli_query($con, $deletadmindatafromtemp);
}

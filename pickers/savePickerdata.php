<?php
function savePickerdata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');

    $checkPickerTempExistance = "SELECT * FROM pickers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkPickerTempExistanceQuery = mysqli_query($con, $checkPickerTempExistance);
    while ($ro = mysqli_fetch_array($checkPickerTempExistanceQuery)) {

        $adminTelegram_id = $ro['admin_telegram_id'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $age = $ro['age'];
        $gender = $ro['gender'];
        $picture = $ro['picture'];
        $woreda = $ro['woreda'];
        $neighborhood = $ro['neighborhood'];
        $date_registered = $ro['date_registered'];
    }
    $selectownerscompany = "SELECT * FROM company_users where telegram_id='$chat_id'";
    $selectownerscompanyQuery = mysqli_query($con, $selectownerscompany);
    while ($co = mysqli_fetch_array($selectownerscompanyQuery)) {
        $companyName = $co['company_name'];
    }
    $fullname = strtolower($firstname) . " " . strtolower($lastname);
    $savePickerDataToMain = "INSERT INTO pickers (admin_telegram_id,firstname,lastname,picture,fullname,age,gender,woreda,neighborhood,company_name,date_registered) 
    VALUE('$adminTelegram_id','$firstname','$lastname','$picture','$fullname','$age','$gender','$woreda','$neighborhood','$companyName',' $date_registered') ";
    mysqli_query($con, $savePickerDataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Picker Successfully Registered");
    $delettransactionfromtemp = "DELETE FROM Pickers_temp WHERE admin_telegram_id='$chat_id'";
    mysqli_query($con, $delettransactionfromtemp);
}

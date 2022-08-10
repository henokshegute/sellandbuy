<?php
function saveSellerdata($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');

    $checkSellerTempExistance = "SELECT * FROM sellers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkSellerTempExistanceQuery = mysqli_query($con, $checkSellerTempExistance);
    while ($ro = mysqli_fetch_array($checkSellerTempExistanceQuery)) {

        $adminTelegram_id = $ro['admin_telegram_id'];
        $firstname = $ro['firstname'];
        $lastname = $ro['lastname'];
        $picture = $ro['picture'];
        $woreda = $ro['woreda'];
        $neighborhood = $ro['neighborhood'];
        $landsize = $ro['land_size'];
        $number_of_tree = $ro['number_of_tree'];
        $phone_number = $ro['phone_number'];
        $date_registered = $ro['date_registered'];
    }
    $fullname = strtolower($firstname) . " " . strtolower($lastname);
    $saveSellerDataToMain = "INSERT INTO sellers (admin_telegram_id,firstname,lastname,picture,fullname,woreda,neighborhood,land_size,number_of_tree,phone_number,date_registered) 
    VALUE('$adminTelegram_id','$firstname','$lastname','$picture','$fullname','$woreda','$neighborhood','$landsize','$number_of_tree','$phone_number',' $date_registered') ";
    mysqli_query($con, $saveSellerDataToMain);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=seller successfully Registered");
    $delettransactionfromtemp = "DELETE FROM sellers_temp WHERE admin_telegram_id='$chat_id'";
    mysqli_query($con, $delettransactionfromtemp);
}

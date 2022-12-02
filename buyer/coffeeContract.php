<?php
function coffeeContractMenu($chat_id)
{
    global $con;
    global $botAPI;
    $coffeeContract = "SELECT * FROM coffee_contract WHERE status='TRUE'";
    $coffeeContractQuery = mysqli_query($con, $coffeeContract);
    $coffeeContractQuantity = mysqli_num_rows($coffeeContractQuery);
    $contract_name_array = [];
    $contractMain = [];
    if ($coffeeContractQuantity > 0) {
        while ($ro = mysqli_fetch_array($coffeeContractQuery)) {
            $contract_name = $ro["contract_name"];
            array_push($contract_name_array, $contract_name);
            array_push($contractMain, [end($contract_name_array)]);
        }
        $keyboard = $contractMain;
        $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "remove_keyboard" => true, "one_time_keyboard" => true);
        $reply = json_encode($resp);
        $message = "Please select farm from the menu";
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $message . "&reply_markup=" . $reply);
    }
}
function washedUnwashed($chat_id)
{
    global $botAPI;
    $keyboard = array(array("Washed", "Unwashed"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    $message = "Please enter the process Washed/Unwashed";
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $message . "&reply_markup=" . $reply);
}
function confirmFarm($chat_id)
{
    global $con;
    global $botAPI;
    $keyboard = array(array("Confirm Farm", "Discard Farm"));
    $coffeeContract = "SELECT * FROM coffee_contract WHERE telegram_id='$chat_id' && status ='FALSE'";
    $coffeeContractQuery = mysqli_query($con, $coffeeContract);
    $coffeeContractQuantity = mysqli_num_rows($coffeeContractQuery);
    while ($ro = mysqli_fetch_array($coffeeContractQuery)) {
        $telegram_id = $ro['telegram_id'];
        $coffee_contract = $ro['contract_name'];
        $longitude = $ro['longitude'];
        $latitude = $ro['latitude'];
        $zone = $ro['zone'];
        $neighborhood = $ro['neighborhood'];
    }
    $marksHTML = "";
    $marksHTML .= "<b>Farm name:- </b>" . strtolower($coffee_contract) . "%0A";
    $marksHTML .= "<b>Zone:-</b>" . strtolower($zone) . "%0A";
    $marksHTML .= "<b>Neighborhood:-</b>" . strtolower($neighborhood) . "%0A";
    $marksHTML .= "<b>Longitude:-</b>" . strtolower($longitude) . "%0A";
    $marksHTML .= "<b>Latitude:-</b>" . strtolower($latitude) . "%0A";
    $hel = "<b>CONFIRM</b>%0A";
    $hel .= $marksHTML;
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&reply_markup=" . $reply . "&parse_mode=html");
}

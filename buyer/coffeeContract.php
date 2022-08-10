<?php
function coffeeContractMenu($chat_id)
{
    global $con;
    global $botAPI;
    $coffeeContract = "SELECT * FROM coffee_contract";
    $coffeeContractQuery = mysqli_query($con, $coffeeContract);
    $ro = mysqli_fetch_array($coffeeContractQuery);
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
        $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
        $reply = json_encode($resp);
        $message = "Please select the coffee contract from the list";
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

<?php
function search($chat_id)
{
    global $botAPI;
    global $con;
    $keyboard = array(array("🔍 Search"));
    $resp = array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true);
    $reply = json_encode($resp);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please search the sellers namefrom the list if not add the seller data first &reply_markup=" . $reply);
}
    // $selectUsers = "SELECT * FROM sellers";
    // $selectUserQuery = mysqli_query($con, $selectUsers);
    // $selectUserQueryRow = mysqli_num_rows($selectUserQuery);
    // if ($selectUserQueryRow > 0) {
    //     while ($ro = mysqli_fetch_array($selectUserQuery)) {
    //         $firstname = $ro['firstname'];
    //         $lastname = $ro['lastname'];
    //         $fullname = $firstname . " " . $lastname;
    //     }
        
   // }

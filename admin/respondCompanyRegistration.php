<?php
function acceptCompany($id, $chat_id, $message_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $listCompanydata = "select * from company_temp where telegram_id ='$id'";
    $query = mysqli_query($con, $listCompanydata);
    $row_num = mysqli_num_rows($query);
    if ($row_num > 0) {
        while ($ro = mysqli_fetch_array($query)) {

            $telgram_id = $ro['telegram_id'];
            $company_name = $ro['company_name'];
            $phone_number = $ro['phone_number'];
            $ownrs_name = $ro['owners_name'];
        }
        $updateCompanyTable = "INSERT INTO company(telegram_id,company_name,phone_number,owners_name,date_registered) VALUES('$telgram_id','$company_name','$phone_number','$ownrs_name','$today')";
        mysqli_query($con, $updateCompanyTable);
        $del = "DELETE FROM company_temp WHERE telegram_id='$id'";
        mysqli_query($con, $del);
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $id . "&text=You are registerd successfully !!!");
        $approve_as_user = "c ";
        $approve_as_user .= $chat_id;
        $keyboard = json_encode(["inline_keyboard" => [[
            ["text" => "✔️ User", "callback_data" => $approve_as_user],
        ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
        file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
    }
}

function delete($id, $chat_id, $message_id)
{
    global $botAPI;
    global $con;
    $listCompanydata = "select * from company_temp where telegram_id ='$id'";
    $query = mysqli_query($con, $listCompanydata);
    $row_num = mysqli_num_rows($query);
    if ($row_num > 0) {
        while ($ro = mysqli_fetch_array($query)) {
            $telgram_id = $ro['telegram_id'];
        }
        $del = "DELETE FROM company_temp WHERE telegram_id='$telgram_id'";
        mysqli_query($con, $del);

        file_get_contents($botAPI . "/sendmessage?chat_id=" . $telgram_id . "&text=You are not allowed to register !!!");

        $delete = "d ";
        $delete .= $chat_id;
        $keyboard = json_encode(["inline_keyboard" => [[
            ["text" => "❌ Deleted", "callback_data" => $delete],
        ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
        file_get_contents($botAPI . "/editMessageReplyMarkup?chat_id=" . $chat_id . "&message_id=" . $message_id . "&reply_markup={$keyboard}");
    }
}

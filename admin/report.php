<?php
function report($chat_id)
{
    global $botAPI;
    global $con;
    date_default_timezone_set("Africa/Addis_Ababa");
    $today = date('y-m-d');
    $listDailyTransaction = "SELECT * FROM transaction where transaction_date= '$today'";
    $listDailyTransactionQuery = mysqli_query($con, $listDailyTransaction);
    $TransactionRow = mysqli_num_rows($listDailyTransactionQuery);
    if ($TransactionRow > 0) {
        while ($ro = mysqli_fetch_array($listDailyTransactionQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $seller_name = $ro['seller_name'];
            $location = $ro['location'];
            $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $transaction_date = $ro['transaction_date'];
            $hel = "<b>TRANSACTION REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "seller_name :- " . strtolower($seller_name) . "%0A";
            $marksHTML .= "location :- " . strtolower($location) . "%0A";
            $marksHTML .= "coffee_grade:- " . strtolower($coffee_grade) . "%0A";
            $marksHTML .= "quantity :- " . strtolower($quantity) . "%0A";
            $marksHTML .= "price :- " . strtolower($price) . "%0A";
            $hel .= $marksHTML;
            $viewSeller = "v_";
            $viewSeller .=  $seller_name;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " 👓 View seller", "callback_data" => $viewSeller],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id. "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html&reply_markup={$keyboard}");
        }
        buyerAdminMainMenu($chat_id);
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transaction performed Today &parse_mode=html");
        buyerAdminMainMenu($chat_id);
    }
}
function previewSeller($full_name, $chat_id)
{


    global $botAPI;
    global $con;

    $listSeller = "SELECT * FROM sellers WHERE fullname = '$full_name'";
    $listSellerQuery = mysqli_query($con, $listSeller);
    $listSellerQueryrow = mysqli_num_rows($listSellerQuery);
    $marksHTML = "";

    if ($listSellerQueryrow > 0) {
        while ($ro = mysqli_fetch_array($listSellerQuery)) {
            $adminTelegram_id = $ro['admin_telegram_id'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $picture=$ro['picture'];
            $woreda = $ro['woreda'];
            $neighborhood = $ro['neighborhood'];
            $phone_number = $ro['phone_number'];
            $date_registered = $ro['date_registered'];
        }
        $buyerRegitersTheSeller = "SELECT * FROM company_users WHERE telegram_id = '$adminTelegram_id'";
        $buyerRegitersTheSellerQuery = mysqli_query($con, $buyerRegitersTheSeller);
        while ($row_admin = mysqli_fetch_array($buyerRegitersTheSellerQuery)) {
            $adminFirstname = $row_admin['firstname'];
            $adminLastname = $row_admin['lastname'];
        }

        $hel = $firstname . " " . $lastname ."%0A";
        $marksHTML .= "Woreda:- " .  strtolower($woreda) . "%0A";
        $marksHTML .= "Neighborhood:- " . strtolower($neighborhood) . "%0A";
        $marksHTML .= "Phone number:-" . strtolower($phone_number) . "%0A";
        $marksHTML .= "Registerd by:-" . strtolower($adminFirstname . " " . $adminLastname) . "%0A";
        $marksHTML .= "Date of registration:-" . strtolower($date_registered) . "%0A";
        $hel .= $marksHTML;
        file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=".$picture."&caption=".$hel); 
    }
}

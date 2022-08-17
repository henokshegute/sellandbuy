<?php
function reportAll($chat_id)
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
            $longtiude = $ro['longitude'];
            $latitude = $ro['latitude'];
            // $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $total = $ro['total'];
            $picture = $ro['picture'];
            $transaction_date = $ro['transaction_date'];
            $hel = "<b>TRANSACTION REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "<b>Seller name :- </b>" . strtolower($seller_name) . "%0A";
            $marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
            //$marksHTML .= "<b>Coffee_grade:-</b> " . strtolower($coffee_grade) . "%0A";
            $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
            $marksHTML .= "<b>1kg price :-</b> " . strtolower($price) . "%0A";
            $marksHTML .= "<b>Total price:- </b>" . strtolower($total) . "%0A";
            $hel .= $marksHTML;
            $viewSeller = "v_";
            $viewSeller .=  $seller_name;
            $loc = $latitude . "," . $longtiude;
            $viewLocation = "L ";
            $viewLocation .= $loc;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " 👓 View Seller", "callback_data" => $viewSeller],
                ["text" => " 📍 View Location", "callback_data" => $viewLocation],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id. "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
            // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html&reply_markup={$keyboard}");
            file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&reply_markup={$keyboard} &parse_mode=html");
        }
        buyerAdminMainMenu($chat_id);
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transaction performed Today &parse_mode=html");
        buyerAdminMainMenu($chat_id);
    }
}
function previewSeller($half, $chat_id)
{


    global $botAPI;
    global $con;

    $listSeller = "SELECT * FROM sellers WHERE fullname = '$half'";
    $listSellerQuery = mysqli_query($con, $listSeller);
    $listSellerQueryrow = mysqli_num_rows($listSellerQuery);
    $marksHTML = "";

    if ($listSellerQueryrow > 0) {
        while ($ro = mysqli_fetch_array($listSellerQuery)) {
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
        $buyerRegitersTheSeller = "SELECT * FROM company_users WHERE telegram_id = '$adminTelegram_id'";
        $buyerRegitersTheSellerQuery = mysqli_query($con, $buyerRegitersTheSeller);
        while ($row_admin = mysqli_fetch_array($buyerRegitersTheSellerQuery)) {
            $adminFirstname = $row_admin['firstname'];
            $adminLastname = $row_admin['lastname'];
        }

        $hel = strtolower($firstname) . " " . strtolower($lastname) . "%0A";
        $marksHTML .= "Woreda:- " .  strtolower($woreda) . "%0A";
        $marksHTML .= "Neighborhood:- " . strtolower($neighborhood) . "%0A";
        $marksHTML .  "Land size:- " . strtolower($landsize) . "%0A";
        $marksHTML .  "Number of tree:- " . strtolower($number_of_tree) . "%0A";
        $marksHTML .= "Phone number:-" . strtolower($phone_number) . "%0A";
        $marksHTML .= "Registerd by:-" . strtolower($adminFirstname . " " . $adminLastname) . "%0A";
        $marksHTML .= "Date of registration:-" . strtolower($date_registered) . "%0A";
        $hel .= $marksHTML;
        file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&parse_mode=html");
    }
}
function accessLocation($half, $chat_id)
{
    global $botAPI;
    list($lat, $long) = explode(",", $half);
    // $lat=8.989571;
    // $long=38.786356;
    file_get_contents($botAPI . "/sendlocation?chat_id=" . $chat_id . "&latitude=" . $lat . " &longitude=" . $long);
}

function reportByContract($chat_id, $msg)
{
    global $botAPI;
    global $con;
    date_default_timezone_set("Africa/Addis_Ababa");
    $today = date('y-m-d');
    $listDailyTransaction = "SELECT * FROM transaction where transaction_date= '$today' && contract_name='$msg'";
    $listDailyTransactionQuery = mysqli_query($con, $listDailyTransaction);
    $TransactionRow = mysqli_num_rows($listDailyTransactionQuery);
    if ($TransactionRow > 0) {
        while ($ro = mysqli_fetch_array($listDailyTransactionQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $seller_name = $ro['seller_name'];
            $location = $ro['location'];
            $longtiude = $ro['longitude'];
            $latitude = $ro['latitude'];
            // $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $total = $ro['total'];
            $picture = $ro['picture'];
            $transaction_date = $ro['transaction_date'];
            $hel = "<b>TRANSACTION REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "<b>Seller name :- </b>" . strtolower($seller_name) . "%0A";
            $marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
            //$marksHTML .= "<b>Coffee_grade:-</b> " . strtolower($coffee_grade) . "%0A";
            $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
            $marksHTML .= "<b>1kg price :-</b> " . strtolower($price) . "%0A";
            $marksHTML .= "<b>Total price:- </b>" . strtolower($total) . "%0A";
            $hel .= $marksHTML;
            $viewSeller = "v_";
            $viewSeller .=  $seller_name;
            $loc = $latitude . "," . $longtiude;
            $viewLocation = "L ";
            $viewLocation .= $loc;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " 👓 View Seller", "callback_data" => $viewSeller],
                ["text" => " 📍 View Location", "callback_data" => $viewLocation],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&reply_markup={$keyboard} &parse_mode=html");
        }
        buyerAdminMainMenu($chat_id);
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transaction performed with this coffee contract &parse_mode=html");
        buyerAdminMainMenu($chat_id);
    }
}

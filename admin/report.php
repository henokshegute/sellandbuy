<?php
function reportAll($chat_id)
{

    global $botAPI;
    global $con;
    $update = json_decode(file_get_contents('php://input', true));
    $tguser = $update->message->from->username;
    $checkUserExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='super admin'";
    $checkUserExistanceQuery = mysqli_query($con, $checkUserExistance);
    $AdminRow = mysqli_num_rows($checkUserExistanceQuery);
    ////////////////////////////////
    $checkFarmadminExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='admin'";
    $checkFarmadminExistanceQuery = mysqli_query($con, $checkFarmadminExistance);
    $FarmAdminRow = mysqli_num_rows($checkFarmadminExistanceQuery);
    ////////////////////////////////


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
            $coffee_contract = $ro['contract_name'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $total = $ro['total'];
            $picture = $ro['picture'];
            $transaction_date = $ro['transaction_date'];
            $hel = "<b>TRANSACTION REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "<b>Seller name :- </b>" . strtolower($seller_name) . "%0A";
            $marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
            $marksHTML .= "<b>Farm:-</b> " . strtolower($coffee_contract) . "%0A";
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
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transactions performed today &parse_mode=html");
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
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
    $update = json_decode(file_get_contents('php://input', true));
    $tguser = $update->message->from->username;
    $checkUserExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='super admin'";
    $checkUserExistanceQuery = mysqli_query($con, $checkUserExistance);
    $AdminRow = mysqli_num_rows($checkUserExistanceQuery);
    ////////////////////////////////
    $checkFarmadminExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='admin'";
    $checkFarmadminExistanceQuery = mysqli_query($con, $checkFarmadminExistance);
    $FarmAdminRow = mysqli_num_rows($checkFarmadminExistanceQuery);
    ////////////////////////////////
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
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transactions performed with this farm &parse_mode=html");
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    }
}
////////////////////PICKING REPORT/////////////////////////////
function pickingReportAll($chat_id)
{
    global $botAPI;
    global $con;
    $update = json_decode(file_get_contents('php://input', true));
    $tguser = $update->message->from->username;
    $checkUserExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='super admin'";
    $checkUserExistanceQuery = mysqli_query($con, $checkUserExistance);
    $AdminRow = mysqli_num_rows($checkUserExistanceQuery);
    ////////////////////////////////
    $checkFarmadminExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='admin'";
    $checkFarmadminExistanceQuery = mysqli_query($con, $checkFarmadminExistance);
    $FarmAdminRow = mysqli_num_rows($checkFarmadminExistanceQuery);
    ////////////////////////////////


    date_default_timezone_set("Africa/Addis_Ababa");
    $today = date('y-m-d');
    $listDailyPicking = "SELECT * FROM collecting where collecting_date= '$today'";
    $listDailyPickingnQuery = mysqli_query($con, $listDailyPicking);
    $PickingRow = mysqli_num_rows($listDailyPickingnQuery);
    if ($PickingRow > 0) {
        while ($ro = mysqli_fetch_array($listDailyPickingnQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $picker_name = $ro['picker_name'];
            $farm_name = $ro['farm_name'];
            $quantity = $ro['quantity'];
            $rate = $ro['rate'];
            $total = $ro['total'];
            $picture = $ro['picture'];
            $transaction_date = $ro['collecting_date'];

            $hel = "<b>PICKING REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "<b>Picker name :- </b>" . strtolower($picker_name) . "%0A";
            //$marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
            $marksHTML .= "<b>Farm:-</b> " . strtolower($farm_name) . "%0A";
            $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
            $marksHTML .= "<b>1kg Rate :-</b> " . strtolower($rate) . "%0A";
            $marksHTML .= "<b>Total payment:- </b>" . strtolower($total) . "%0A";
            $hel .= $marksHTML;
            $viewPicker = "P_";
            $viewPicker .=  $picker_name;
            // $loc = $latitude . "," . $longtiude;
            // $viewLocation = "L ";
            // $viewLocation .= $loc;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " 👓 View Picker", "callback_data" => $viewPicker],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id. "&text="  . $marksHTML . "&parse_mode=html&reply_markup={$keyboard}");
            // file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=" . $hel . "&parse_mode=html&reply_markup={$keyboard}");
            file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&reply_markup={$keyboard} &parse_mode=html");
        }
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transactions performed today &parse_mode=html");
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    }
}
function previewPicker($half, $chat_id)
{


    global $botAPI;
    global $con;

    $listpicker = "SELECT * FROM pickers WHERE fullname = '$half'";
    $listpickerQuery = mysqli_query($con, $listpicker);
    $listpickerQueryrow = mysqli_num_rows($listpickerQuery);
    $marksHTML = "";

    if ($listpickerQueryrow > 0) {
        while ($ro = mysqli_fetch_array($listpickerQuery)) {
            $adminTelegram_id = $ro['admin_telegram_id'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $picture = $ro['picture'];
            $woreda = $ro['woreda'];
            $neighborhood = $ro['neighborhood'];
            $date_registered = $ro['date_registered'];
        }
        $buyerRegitersThepicker = "SELECT * FROM company_users WHERE telegram_id = '$adminTelegram_id'";
        $buyerRegitersThepickerQuery = mysqli_query($con, $buyerRegitersThepicker);
        while ($row_admin = mysqli_fetch_array($buyerRegitersThepickerQuery)) {
            $adminFirstname = $row_admin['firstname'];
            $adminLastname = $row_admin['lastname'];
        }

        $hel = strtolower($firstname) . " " . strtolower($lastname) . "%0A";
        $marksHTML .= "Woreda:- " .  strtolower($woreda) . "%0A";
        $marksHTML .= "Neighborhood:- " . strtolower($neighborhood) . "%0A";
        $marksHTML .= "Registerd by:-" . strtolower($adminFirstname . " " . $adminLastname) . "%0A";
        $marksHTML .= "Date of registration:-" . strtolower($date_registered) . "%0A";
        $hel .= $marksHTML;
        file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&parse_mode=html");
    }
}
function pickingReportByContract($chat_id, $msg)
{
    global $botAPI;
    global $con;
    $update = json_decode(file_get_contents('php://input', true));
    $tguser = $update->message->from->username;
    $checkUserExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='super admin'";
    $checkUserExistanceQuery = mysqli_query($con, $checkUserExistance);
    $AdminRow = mysqli_num_rows($checkUserExistanceQuery);
    ////////////////////////////////
    $checkFarmadminExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='admin'";
    $checkFarmadminExistanceQuery = mysqli_query($con, $checkFarmadminExistance);
    $FarmAdminRow = mysqli_num_rows($checkFarmadminExistanceQuery);
    ////////////////////////////////
    date_default_timezone_set("Africa/Addis_Ababa");
    $today = date('y-m-d');
    $listDailyTransaction = "SELECT * FROM collecting where collecting_date= '$today' && farm_name='$msg'";
    $listDailyTransactionQuery = mysqli_query($con, $listDailyTransaction);
    $TransactionRow = mysqli_num_rows($listDailyTransactionQuery);
    if ($TransactionRow > 0) {
        while ($ro = mysqli_fetch_array($listDailyTransactionQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $picker_name = $ro['picker_name'];
            $quantity = $ro['quantity'];
            $rate = $ro['rate'];
            $total = $ro['total'];
            $picture = $ro['picture'];
            $collecting_date = $ro['collecting_date'];
            // $location = $ro['location'];
            // $longtiude = $ro['longitude'];
            // $latitude = $ro['latitude'];
            // $coffee_grade = $ro['coffee_grade'];
            $hel = "<b>PICKING REPORT</b>%0A";
            $marksHTML = "";
            $marksHTML .= "<b>Picker name :- </b>" . strtolower($picker_name) . "%0A";
            // $marksHTML .= "<b>Location :- </b>" . strtolower($location) . "%0A";
            //$marksHTML .= "<b>Coffee_grade:-</b> " . strtolower($coffee_grade) . "%0A";
            $marksHTML .= "<b>Quantity :- </b>" . strtolower($quantity) . "%0A";
            $marksHTML .= "<b>1kg Rate :-</b> " . strtolower($rate) . "%0A";
            $marksHTML .= "<b>Total payment:- </b>" . strtolower($total) . "%0A";
            $hel .= $marksHTML;
            $viewPicker = "P_";
            $viewPicker .=  $picker_name;
            // $loc = $latitude . "," . $longtiude;
            // $viewLocation = "L ";
            // $viewLocation .= $loc;
            $keyboard = json_encode(["inline_keyboard" => [[
                ["text" => " 👓 View Picker", "callback_data" => $viewPicker],
            ],], 'resize_keyboard' => true, "one_time_keyboard" => true]);
            file_get_contents($botAPI . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $picture . "&caption=" . $hel . "&reply_markup={$keyboard} &parse_mode=html");
        }
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=There are no transactions performed with this farm &parse_mode=html");
        if ($AdminRow > 0) {
            superAdminMenu($chat_id);
        } else if ($FarmAdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        }
    }
}
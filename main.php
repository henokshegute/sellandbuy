<?php
include "Db_connect/connect.php";
include "registration/companyRegistrationMenu.php";
include "registration/registrationConfirmation.php";
include "admin/listRequestedCompanyRegistration.php";
include "admin/respondCompanyRegistration.php";
include "admin/setValue.php";
include "registration/companyRegistrationConfirmation.php";
include "registration/confirmationUser.php";
include "registration/userRegistrationConfirmation.php";
include "common/menus.php";
include "buyer/transactionConfirmation.php";
include "buyer/transactionConfirmationMenu.php";
include "admin/report.php";
include "seller/confirmSellersdata.php";
include "seller/saveSellerdata.php";
include "admin/sysownermenu.php";
include "buyer/searching.php";
include "buyer/locationMethod.php";


$botToken = "5531081309:AAFjvINk0MIM47-2tliFM_osBtnHi3SpXVw";
$botAPI = "https://api.telegram.org/bot" . $botToken;
$update = json_decode(file_get_contents('php://input', true));
$googleMapApi = "http://maps.google.com/maps/api/geocode/json?";

if (isset($update->message->text)) {
    $msg = $update->message->text;
    $tguser = $update->message->from->username;
    $chat_id = $update->message->chat->id;
    date_default_timezone_set('Africa/Addis_Ababa');
    $time = date("h:ia");
    $today = date('y-m-d');

    ////////////////////////////////
    $systemowner = "SELECT * FROM system_owner Where telegram_id='$chat_id'";
    $systemownerQuery = mysqli_query($con, $systemowner);
    $ownerRow = mysqli_num_rows($systemownerQuery);
    ///////////////////////////////
    $checkUserTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id  ='$chat_id' && role='admin'";
    $checkUserTempExistanceQuery = mysqli_query($con, $checkUserTempExistance);
    $userTempRow = mysqli_num_rows($checkUserTempExistanceQuery);
    //////////////////////////////
    $checkBuyerTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id  ='$chat_id' && role='buyer'";
    $checkBuyerTempExistanceQuery = mysqli_query($con, $checkBuyerTempExistance);
    $buyerTempRow = mysqli_num_rows($checkBuyerTempExistanceQuery);
    //////////////////////////////
    $checkCompanyExistance = "SELECT * FROM company WHERE telegram_id ='$chat_id'";
    $checkCompanyExistanceQuery = mysqli_query($con, $checkCompanyExistance);
    $companyRow = mysqli_num_rows($checkCompanyExistanceQuery);
    ////////////////////////////////
    $checkUserExistance = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='admin'";
    $checkUserExistanceQuery = mysqli_query($con, $checkUserExistance);
    $AdminRow = mysqli_num_rows($checkUserExistanceQuery);
    ////////////////////////////////
    $checkUserExistanceBuyer = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='buyer'";
    $checkUserExistanceQueryBuyer = mysqli_query($con, $checkUserExistanceBuyer);
    $buyerRow = mysqli_num_rows($checkUserExistanceQueryBuyer);
    ////////////////////////////
    $checkSellerTempExistance = "SELECT * FROM sellers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkSellerTempExistanceQuery = mysqli_query($con, $checkSellerTempExistance);
    $sellerRow = mysqli_num_rows($checkSellerTempExistanceQuery);
    ////////////////////////////////////////////////////
    $checkCompanyExistanceTemp = "SELECT * FROM company_temp WHERE telegram_id ='$chat_id'";
    $checkCompanyExistanceTempQuery = mysqli_query($con, $checkCompanyExistanceTemp);
    $companyRowTemp = mysqli_num_rows($checkCompanyExistanceTempQuery);
    /////////////////////////////////////////////////////////////////////
    $checkTransactionExistance = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    $transactionRow = mysqli_num_rows($checkTransactionExistanceQuery);
    /////////////////////////////////////////////////////////////////////
    if ($msg == "/start") {
        if ($ownerRow > 0) {
            ownerMenu($chat_id);
        } else if ($companyRow > 0) {
            companyAdminMainMenu($chat_id);
        } else if ($AdminRow > 0) {
            while ($ro = mysqli_fetch_array($checkUserExistanceQuery)) {
                $telegram_id = $ro['telegram_id'];
            }
            if ($telegram_id == NULL) {
                $updateAdminRow = "UPDATE company_users SET telegram_id='$chat_id' WHERE telegram_username ='$tguser' ";
                $updateAdminRowQuery = mysqli_query($con, $updateAdminRow);
                buyerAdminMainMenu($chat_id);
            } else {
                buyerAdminMainMenu($chat_id);
            }
        } else if ($buyerRow > 0) {
            while ($ro = mysqli_fetch_array($checkUserExistanceQueryBuyer)) {
                $telegram_id = $ro['telegram_id'];
            }
            if ($telegram_id == NULL) {
                $updateBuyerRow = "UPDATE company_users SET telegram_id='$chat_id' WHERE telegram_username ='$tguser' ";
                $updateAdminRowQuery = mysqli_query($con, $updateBuyerRow);
                buyerMenu($chat_id);
            } else {
                buyerMenu($chat_id);
            }
        } else if ($companyRowTemp == 0) {
            companyRegitsrationMenu($chat_id);
        }
    }
    ///////////////////////////////////
    if ($companyRowTemp < 1) {

        if ($msg == "Register") {
            $inserQuery = $con->query("INSERT INTO company_temp(telegram_id,date_registered) VALUES('$chat_id','$today')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the company name?");
        }
    } else if ($companyRowTemp > 0) {
        while ($ro = mysqli_fetch_array($checkCompanyExistanceTempQuery)) {
            $telegram_id = $ro['telegram_id'];
            $company_name = $ro['company_name'];
            $owners_name = $ro['owners_name'];
            $phone_number = $ro['phone_number'];
        }
        if ($telegram_id != NULL && $company_name == NULL) {
            setCompanyValue($chat_id, "company_name", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the company G.M name?");
        } else if ($company_name != NULL && $owners_name == NULL) {
            setCompanyValue($chat_id, "owners_name", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the company G.M phone_number?");
        } else if ($owners_name != NULL && $phone_number == NULL) {
            setCompanyValue($chat_id, "phone_number", $msg);
            confirmCompanyData($chat_id);
        }
        if ($msg == 'Confirm Company' && $company_name != NULL) {
            confirmetionreplay($chat_id);
        }
        if ($msg == 'Discard Registration') {
            $deleteFromCompanyTemp = $con->query("DELETE FROM company_temp Where telegram_id='$chat_id'");
            companyRegitsrationMenu($chat_id);
        }
    }
    //////////////////////////////////
    if ($msg == "Approve Company") {
        listrequesteduser($chat_id);
    }
    //////////////////////Register USer InTO the company//////////////////////////////////////

    if ($userTempRow < 1) {
        if ($msg == "Register Admin") {
            $inserQuery = $con->query("INSERT INTO company_users_temp(company_telegram_id,date_registered,role) VALUES('$chat_id','$today','admin')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter admin's Phone number ");
        }
    } else if ($userTempRow > 0) {

        while ($ro = mysqli_fetch_array($checkUserTempExistanceQuery)) {
            $companyTelegram_id = $ro['company_telegram_id'];
            $phonenumber = $ro['phone_number'];
            $telegram_username = $ro['telegram_username'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $woreda = $ro['woreda'];
            $role = $ro['role'];
        }
        if ($companyTelegram_id != NULL && $phonenumber == NULL) {
            setUserValue($chat_id, "phone_number", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter admin's telegram username?");
        } else if ($phonenumber != NULL && $telegram_username == NULL) {
            setUserValue($chat_id, "telegram_username", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the first name?");
        } else if ($telegram_username != NULL && $firstname == NULL) {
            setUserValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the last name?");
        } else if ($firstname != NULL && $lastname == NULL) {
            setUserValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the woreda?");
        } else if ($lastname != NULL && $woreda == NULL) {
            setUserValue($chat_id, "woreda", $msg);
            confirmUserData($chat_id);
        }
        if ($msg == "Confirm Admin" && $woreda != NULL) {
            savedata($chat_id);
            companyAdminMainMenu($chat_id);
        }
        if ($msg == "Discard Admin" && $woreda != NULL) {
            $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE company_telegram_id='$chat_id'";
            mysqli_query($con, $deletadmindatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration Canceled");
            companyAdminMainMenu($chat_id);
        }
    }
    ///////////////////Register Buyer/////////////////////////
    if ($buyerTempRow < 1) {
        if ($msg == "Register Buyer") {
            $inserQuery = $con->query("INSERT INTO company_users_temp(company_telegram_id,date_registered,role) VALUES('$chat_id','$today','buyer')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the buyer's Phone number?");
        }
    } else if ($buyerTempRow > 0) {
        while ($ro = mysqli_fetch_array($checkBuyerTempExistanceQuery)) {
            $companyTelegram_id = $ro['company_telegram_id'];
            $phonenumber = $ro['phone_number'];
            $telegram_username = $ro['telegram_username'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $woreda = $ro['woreda'];
            $role = $ro['role'];
        }
        if ($companyTelegram_id != NULL && $phonenumber == NULL) {
            setUserValue($chat_id, "phone_number", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the telegram username?");
        } else if ($phonenumber != NULL && $telegram_username == NULL) {
            setUserValue($chat_id, "telegram_username", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the first name?");
        } else if ($telegram_username != NULL && $firstname == NULL) {
            setUserValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the last name?");
        } else if ($firstname != NULL && $lastname == NULL) {
            setUserValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the buyer's woreda?");
        } else if ($lastname != NULL && $woreda == NULL) {
            setUserValue($chat_id, "woreda", $msg);
            confirmBuyerUserData($chat_id);
        }
        if ($msg == "Confirm Buyer" && $woreda != NULL) {
            savebuyerdata($chat_id);
            buyerAdminMainMenu($chat_id);
        }
        if ($msg == "Discard Buyer" && $woreda != NULL) {
            $deletbuyerdatafromtemp = "DELETE FROM company_users_temp WHERE company_telegram_id='$chat_id'";
            mysqli_query($con, $deletbuyerdatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration canceled");
            buyerAdminMainMenu($chat_id);
        }
    }
    ///////////////////////Register Seller///////////////////////////////
    if ($sellerRow < 1) {
        if ($msg == "Add New Seller") {
            $inserQuery = $con->query("INSERT INTO sellers_temp(admin_telegram_id,date_registered) VALUES('$chat_id','$today')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the firstname?");
        }
    } else if ($sellerRow > 0) {
        while ($ro = mysqli_fetch_array($checkSellerTempExistanceQuery)) {
            $adminTelegram_id = $ro['admin_telegram_id'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $picture = $ro['picture'];
            $woreda = $ro['woreda'];
            $neighborhood = $ro['neighborhood'];
            $phone_number = $ro['phone_number'];
            $date_registered = $ro['date_registered'];
        }
        if ($adminTelegram_id != NULL && $firstname == NULL) {
            setSellersValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the lastname?");
        } else if ($firstname != NULL && $lastname == NULL) {
            setSellersValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please add seller's picture");
        } else if ($picture != NULL && $woreda == NULL) {
            setSellersValue($chat_id, "woreda", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the neighbourhood?");
        } else if ($woreda != NULL && $neighborhood  == NULL) {
            setSellersValue($chat_id, "neighborhood", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter seller's Phone number");
        } else if ($neighborhood != NULL && $phone_number == NULL) {
            setSellersValue($chat_id, "phone_number", $msg);
            confirmSeller($chat_id);
        }
        if ($msg == "Confirm Seller" && $phone_number != NULL) {
            saveSellerdata($chat_id);
            buyerMenu($chat_id);
        }
        if ($msg == "Discard Seller" && $phone_number != NULL) {
            $deletbuyerdatafromtemp = "DELETE FROM sellers_temp WHERE admin_telegram_id='$chat_id'";
            mysqli_query($con, $deletbuyerdatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration canceled");
            buyerMenu($chat_id);
        }
    }
    ////////////////////Transaction///////////////////////
    if ($transactionRow < 1) {
        if ($msg == "Buy") {
            $keyboard = array(array(array("text" => "send location", "request_location" => true, "has_protected_content" => true,)));
            $reply = json_encode(array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true));
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=confirm your location &reply_markup=" . $reply);
        }
    } else if ($transactionRow > 0) {
        while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $zone = $ro['zone'];
            $neighborhood = $ro['neighborhood'];
            $origion = $ro['origion'];
            $process = $ro['process'];
            $seller_name = $ro['seller_name'];
            $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $location = $ro['location'];
        }
        if ($buyer_telegram_id != NULL && $zone == NULL) {
            setTransactionValue($chat_id, "zone", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the neighborhood");
        } else if ($zone != NULL && $neighborhood == NULL) {
            setTransactionValue($chat_id, "neighborhood", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter  the origion/coffee contract");
        } else if ($neighborhood != NULL && $origion == NULL) {
            setTransactionValue($chat_id, "origion", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the process Washed/Unwashed");
        } else if ($origion != NULL && $process == NULL) {
            setTransactionValue($chat_id, "process", "$msg");
            search($chat_id);
        } else if ($msg == "🔍 Search") {
            $data = http_build_query(['text' => 'Search using the button below', 'chat_id' => $chat_id]);
            $keyboard = json_encode([
                "inline_keyboard" => [[
                    ["text" => "Search", "switch_inline_query_current_chat" => ""],
                ],], 'resize_keyboard' => true, "one_time_keyboard" => true
            ]);
            file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
        } else if ($process != NULL && $seller_name == NULL) {
            setTransactionValue($chat_id, "seller_name", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the coffee grade?");
        } else if ($seller_name != NULL && $coffee_grade == NULL) {
            setTransactionValue($chat_id, "coffee_grade", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the coffee quantity?");
        } else if ($coffee_grade != NULL && $quantity == NULL) {
            setTransactionValue($chat_id, "quantity", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the coffee 1kg Price?");
        } else if ($quantity != NULL && $price == NULL) {
            $quantityNumber = (int)$quantity;
            $priceNumber = (int)$msg;
            $total = $quantityNumber * $priceNumber;
            setTransactionValue($chat_id, "price", "$total");
            confirmTransaction($chat_id);
        }
        if ($msg == "Confirm Transaction" && $price != NULL) {
            saveTransactiondata($chat_id);
            buyerMenu($chat_id);
        }
        if ($msg == "Discard Transaction" && $price != NULL) {
            $delettransactionfromtemp = "DELETE FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
            mysqli_query($con, $delettransactionfromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Transaction canceled");
            buyerMenu($chat_id);
        }
    }
    //////////////////////////////////////////////////////
    if ($msg == "Report") {
        report($chat_id);
    }
    //////////////////////////////////////////////////////
} else if (isset($update->message->contact)) {
    $phonNumber = $update->message->contact->phone_number;
    //$setCompanyValue($chat_id, "phone_number", $phonNumber);
    //confirmCompanyData($chat_id);
} else if (isset($update->message->forward_from)) {
    $chat_id = $update->message->chat->id;
    disableForwarding($chat_id);
} else if (isset($update->message->location)) {
    date_default_timezone_set('Africa/Addis_Ababa');
    $today = date('y-m-d');
    $transactionlong = $update->message->location->longitude;
    $transactionlat = $update->message->location->latitude;
    $fulllocation = ("$transactionlat,$transactionlong");
    $transactionLocation = getAddress($transactionlat, $transactionlong);
    $chat_id = $update->message->chat->id;

    $inserQuery = $con->query("INSERT INTO transaction_temp(buyer_telegram_id,location,transaction_date) VALUES('$chat_id','$transactionLocation','$today')");
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter zone?");
} else if (isset($update->callback_query->data)) {

    $chat_id = $update->callback_query->from->id;
    $message_id =  $update->callback_query->message->message_id;

    list($first, $id) = explode(" ", $update->callback_query->data);
    if ($first == "c") {
        acceptCompany($id, $chat_id, $message_id);
    } else if ($first == "d") {
        delete($id, $chat_id, $message_id);
    }
    list($name, $full_name) = explode("_", $update->callback_query->data);
    if ($name == "v") {
        previewSeller($full_name, $chat_id);
    }
} else if (isset($update->inline_query)) {
    $chatId = $update->inline_query->from->id;
    $queryId = $update->inline_query->id;
    $username = $update->inline_query->from->first_name;
    $qu = $update->inline_query->query;
    $sql = "select * from sellers where fullname like '%{$qu}%'";
    $query = mysqli_query($con, $sql);
    $user = mysqli_num_rows($query);
    $result = [];
    $count = 0;
    while ($user_row = mysqli_fetch_array($query)) {
        $result[$count] = [
            "type" => "article", "id" => $count, "title" => $user_row['fullname'],
            "input_message_content" => array("message_text" => $user_row['fullname'], "parse_mode" => "HTML"),
            "description" => $user_row['fullname'],
        ];
        $count++;
    }
    $result = json_encode($result, true);
    $url = $botAPI . "/answerInlineQuery?inline_query_id=$queryId&results=$result&cache_time=0&switch_pm_text=your results&switch_pm_parameter=123";
    file_get_contents($url);
} else if (isset($update->message->photo)) {
    $pic = $update->message->photo[0]->file_id;
    $chat_id = $update->message->chat->id;
    setSellersValue($chat_id, "picture", $pic);
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the Woreda?");
}

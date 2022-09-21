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
include "registration/confirmpricedata.php";
include "registration/priceconfirmationReplay.php";
include "common/menus.php";
include "buyer/transactionConfirmation.php";
include "buyer/transactionConfirmationMenu.php";
include "admin/report.php";
include "admin/rspondpricerequest.php";
include "seller/confirmSellersdata.php";
include "seller/saveSellerdata.php";
include "admin/sysownermenu.php";
include "buyer/searching.php";
include "buyer/locationMethod.php";
include "buyer/coffeeContract.php";


$botToken = "5531081309:AAFjvINk0MIM47-2tliFM_osBtnHi3SpXVw";
$botAPI = "https://api.telegram.org/bot" . $botToken;
$update = json_decode(file_get_contents('php://input', true));
$googleMapApi = "http://maps.google.com/maps/api/geocode/json?";

if (isset($update->message->text)) {
    $msg = $update->message->text;
    $tguser = $update->message->from->username;
    $chat_id = $update->message->chat->id;
    $message_id = $update->message->message_id;
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
    $checkBuyerTempExistance = "SELECT * FROM company_users_temp WHERE company_telegram_id  ='$chat_id' && role='scale man'";
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
    $checkUserExistanceBuyer = "SELECT * FROM company_users WHERE telegram_username ='$tguser' && role='scale man'";
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
    $checkTransactionExistance = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id' AND edit='FALSE'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    $transactionRow = mysqli_num_rows($checkTransactionExistanceQuery);
    /////////////////////////////////////////////////////////////////////
    $checkPriceExistance = "SELECT * FROM price_temp WHERE telegram_id='$chat_id'";
    $checkPriceExistanceQuery = mysqli_query($con, $checkPriceExistance);
    $priceRow = mysqli_num_rows($checkPriceExistanceQuery);
    /////////////////////////////////////////////////////////////////////
    $checkEditPriceExistance = "SELECT * FROM edit_price WHERE telegram_id='$chat_id'";
    $checkEditPriceExistanceQuery = mysqli_query($con, $checkEditPriceExistance);
    $EditpriceRow = mysqli_num_rows($checkEditPriceExistanceQuery);
    /////////////////////////////////////////////////////////////////////
    $checkReport = "SELECT * FROM report WHERE telegram_id='$chat_id'";
    $checkReportQuery = mysqli_query($con, $checkReport);
    $reportRow = mysqli_num_rows($checkReportQuery);
    /////////////////////////////////////////////////////////////////////
    $coffeeContract = "SELECT * FROM coffee_contract WHERE telegram_id='$chat_id'";
    $coffeeContractQuery = mysqli_query($con, $coffeeContract);
    $coffeeContractQuantity = mysqli_num_rows($coffeeContractQuery);
    /////////////////////////////////////////////////////////////////////
    // $transactionAfterUpdatingSellerPic = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id' AND edit='TRUE'";
    // $transactionAfterUpdatingSellerPicQuery = mysqli_query($con, $transactionAfterUpdatingSellerPic);
    // $transactioneditRow = mysqli_num_rows($transactionAfterUpdatingSellerPicQuery);
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
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the company name");
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
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the company's General Manager name");
        } else if ($company_name != NULL && $owners_name == NULL) {
            setCompanyValue($chat_id, "owners_name", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the companys General Manager's phone number. Begin the phone number with the number (9) and follow.");
        } else if ($owners_name != NULL && $phone_number == NULL) {
            $str = $msg;
            $pattern = "/((^9\d{2})-?\d{6})$/";
            if (preg_match($pattern, $str)) {
                setCompanyValue($chat_id, "phone_number", "+251" . $msg);
                confirmCompanyData($chat_id);
            } else {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please provide a valid phone number. The number must start with (9) and follow with 8 digits after.");
            }
        }
        if ($msg == 'Confirm Registration' && $company_name != NULL) {
            confirmetionreplay($chat_id);
        }
        if ($msg == 'Discard Registration') {
            $deleteFromCompanyTemp = $con->query("DELETE FROM company_temp Where telegram_id='$chat_id'");
            companyRegitsrationMenu($chat_id);
        }
    }
    //////////////////////////////////
    if ($msg == "Approve Company" && $ownerRow > 0) {
        listrequesteduser($chat_id);
    }
    //////////////////////Register USer InTO the company//////////////////////////////////////
    if ($userTempRow < 1) {
        if ($msg == "Register Admin" && $companyRow > 0) {
            $inserQuery = $con->query("INSERT INTO company_users_temp(company_telegram_id,date_registered,role) VALUES('$chat_id','$today','admin')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the admin's phone number. Begin the phone number with the number (9) and follow.");
        }
    } else if ($userTempRow > 0) {
        $username = "SELECT * FROM company_users";
        $usernameQuery = mysqli_query($con, $username);
        while ($us = mysqli_fetch_array($usernameQuery)) {
            $userTelegram = $us['telegram_username'];
        }
        while ($ro = mysqli_fetch_array($checkUserTempExistanceQuery)) {
            $companyTelegram_id = $ro['company_telegram_id'];
            $phonenumber = $ro['phone_number'];
            $telegram_username = $ro['telegram_username'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $woreda = $ro['woreda'];
            $role = $ro['role'];
        }
        if ($msg != "/cancel" && ($companyTelegram_id != NULL && $phonenumber == NULL)) {
            $str = $msg;
            $pattern = "/((^9\d{2})-?\d{6})$/";
            if (preg_match($pattern, $str)) {
                setUserValue($chat_id, "phone_number", "+251" . $msg);
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the admin's telegram username?");
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=The telegram username should not include the " . "@" . " in the begining. Usernames are case sensitive!");
            } else {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please provide a valid phone number. The number must start with (9) and follow with 8 digits after.");
            }
        } else if ($msg != "/cancel" && ($phonenumber != NULL && $telegram_username == NULL)) {
            if ($msg == $userTelegram) {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=This user has already been registered as an admin. If you would like to add another admin please enter another telegram username. If you would like to cancel registration please select /cancel.");
            } else {
                setUserValue($chat_id, "telegram_username", $msg);
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her first name.");
            }
        } else if ($msg != "/cancel" && ($telegram_username != NULL && $firstname == NULL)) {
            setUserValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her last name.");
        } else if ($msg != "/cancel" && ($firstname != NULL && $lastname == NULL)) {
            setUserValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the Woreda?");
        } else if ($msg != "/cancel" && ($lastname != NULL && $woreda == NULL)) {
            setUserValue($chat_id, "woreda", $msg);
            confirmUserData($chat_id);
        }
        if ($msg == "Confirm New Admin" && $woreda != NULL) {
            savedata($chat_id);
            companyAdminMainMenu($chat_id);
        }
        if ($msg == "Discard New Admin" && $woreda != NULL) {
            $deletadmindatafromtemp = "DELETE FROM company_users_temp WHERE company_telegram_id='$chat_id'";
            mysqli_query($con, $deletadmindatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration Canceled");
            companyAdminMainMenu($chat_id);
        }
    }
    ///////////////////Register Buyer/////////////////////////
    if ($buyerTempRow < 1) {
        if ($msg == "Register Scale Man" && $AdminRow > 0) {
            $inserQuery = $con->query("INSERT INTO company_users_temp(company_telegram_id,date_registered,role) VALUES('$chat_id','$today','scale man')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the scale man's phone number. Begin the phone number with the number (9) and follow.");
        }
    } else if ($buyerTempRow > 0) {
        $username = "SELECT * FROM company_users";
        $usernameQuery = mysqli_query($con, $username);
        while ($us = mysqli_fetch_array($usernameQuery)) {
            $userTelegram = $us['telegram_username'];
        }
        while ($ro = mysqli_fetch_array($checkBuyerTempExistanceQuery)) {
            $companyTelegram_id = $ro['company_telegram_id'];
            $phonenumber = $ro['phone_number'];
            $telegram_username = $ro['telegram_username'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $woreda = $ro['woreda'];
            $role = $ro['role'];
        }
        if ($msg != "/cancel" && ($companyTelegram_id != NULL && $phonenumber == NULL)) {
            $str = $msg;
            $pattern = "/((^9\d{2})-?\d{6})$/";
            if (preg_match($pattern, $str)) {
                setUserValue($chat_id, "phone_number", "+251" . $msg);
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the scale man's telegram username.");
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=The telegram username should not include the " . "@" . " in the begining.");
            } else {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please provide a valid phone number. The number must start with (9) and follow with 8 digits after.");
            }
        } else if (($phonenumber != NULL && $telegram_username == NULL) && $msg != "/cancel") {
            if ($msg == $userTelegram) {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=This user has already been registered as a scale man. If you would like to add another scale man please enter another telegram username. If you would like to cancel registration please select /cancel.");
            } else {
                setUserValue($chat_id, "telegram_username", $msg);
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her first name.");
            }
        } else if (($telegram_username != NULL && $firstname == NULL) && $msg != "/cancel") {
            setUserValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her last name.");
        } else if (($firstname != NULL && $lastname == NULL) && $msg != "/cancel") {
            setUserValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the scale man's Woreda.");
        } else if (($lastname != NULL && $woreda == NULL) && $msg != "/cancel") {
            setUserValue($chat_id, "woreda", $msg);
            confirmBuyerUserData($chat_id);
        }
        if ($msg == "Confirm Scale Man" && $woreda != NULL) {
            savebuyerdata($chat_id);
            buyerAdminMainMenu($chat_id);
        }
        if ($msg == "Discard Scale Man" && $woreda != NULL) {
            $deletbuyerdatafromtemp = "DELETE FROM company_users_temp WHERE company_telegram_id='$chat_id'";
            mysqli_query($con, $deletbuyerdatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration canceled");
            buyerAdminMainMenu($chat_id);
        }
    }
    ///////////////////////Register Seller///////////////////////////////
    if ($sellerRow < 1) {
        if ($msg == "Add New Seller" && ($AdminRow > 0 || $buyerRow > 0)) {
            $inserQuery = $con->query("INSERT INTO sellers_temp(admin_telegram_id,date_registered) VALUES('$chat_id','$today')");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her first name.");
        }
    } else if ($sellerRow > 0) {
        $username = "SELECT * FROM sellers";
        $usernameQuery = mysqli_query($con, $username);
        while ($us = mysqli_fetch_array($usernameQuery)) {
            $sellersPhone = $us['phone_number'];
        }
        while ($ro = mysqli_fetch_array($checkSellerTempExistanceQuery)) {
            $adminTelegram_id = $ro['admin_telegram_id'];
            $firstname = $ro['firstname'];
            $lastname = $ro['lastname'];
            $picture = $ro['picture'];
            $woreda = $ro['woreda'];
            $neighborhood = $ro['neighborhood'];
            $land_size = $ro['land_size'];
            $number_of_tree = $ro['number_of_tree'];
            $phone_number = $ro['phone_number'];
            $date_registered = $ro['date_registered'];
        }
        if ($msg != "/cancel" && ($adminTelegram_id != NULL && $firstname == NULL)) {
            setSellersValue($chat_id, "firstname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter his/her last name.");
        } else if (($firstname != NULL && $lastname == NULL) && $msg != "/cancel") {
            setSellersValue($chat_id, "lastname", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please add seller's picture");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please use the attach button to take or select a photo. NO caption required");
        } else if (($picture != NULL && $woreda == NULL) && $msg != "/cancel") {
            setSellersValue($chat_id, "woreda", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the Neighbourhood.");
        } else if (($woreda != NULL && $neighborhood  == NULL) && $msg != "/cancel") {
            setSellersValue($chat_id, "neighborhood", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter land size in hectares.");
        } else if (($neighborhood != NULL && $land_size  == NULL) && $msg != "/cancel") {
            setSellersValue($chat_id, "land_size", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the number of coffee trees.");
        } else if (($land_size != NULL && $number_of_tree  == NULL) && $msg != "/cancel") {
            setSellersValue($chat_id, "number_of_tree", $msg);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the scale man's phone number. Begin the phone number with the number (9) and follow.");
        } else if (($neighborhood != NULL && $phone_number == NULL) && $msg != "/cancel") {
            $str = $msg;
            $pattern = "/((^9\d{2})-?\d{6})$/";
            if (preg_match($pattern, $str)) {
                if ("+251" . $msg == $sellersPhone) {
                    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=This seller has already been registered. If you would like to add another seller please enter another phone number. If you would like to cancel registration please select /cancel.");
                } else {
                    setSellersValue($chat_id, "phone_number", "+251" . $msg);
                    confirmSeller($chat_id);
                }
            } else {
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please provide a valid phone number. The number must start with (9) and follow with 8 digits after.");
            }
        }
        if ($msg == "Confirm New Seller" && $phone_number != NULL) {
            saveSellerdata($chat_id);
            if ($AdminRow > 0) {
                buyerAdminMainMenu($chat_id);
            } else if ($buyerRow > 0) {
                buyerMenu($chat_id);
            }
        }
        if ($msg == "Discard New Seller" && $phone_number != NULL) {
            $deletbuyerdatafromtemp = "DELETE FROM sellers_temp WHERE admin_telegram_id='$chat_id'";
            mysqli_query($con, $deletbuyerdatafromtemp);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Registration canceled.");
            if ($AdminRow > 0) {
                buyerAdminMainMenu($chat_id);
            } else if ($buyerRow > 0) {
                buyerMenu($chat_id);
            }
        }
    }
    ////////////////////Transaction///////////////////////

    if ($transactionRow < 1) {
        if ($msg == "Buy" && $buyerRow > 0) {
            $keyboard = array(array(array("text" => "Send Location", "request_location" => true, "has_protected_content" => true,)));
            $reply = json_encode(array("keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true));
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Confirm your location &reply_markup=" . $reply);
        }
    } else if ($transactionRow > 0) {
        while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
            $buyer_telegram_id = $ro['buyer_telegram_id'];
            $zone = $ro['zone'];
            $neighborhood = $ro['neighborhood'];
            $contract_name = $ro['contract_name'];
            // $process = $ro['process'];
            $seller_name = $ro['seller_name'];
            $picture = $ro['picture'];
            // $coffee_grade = $ro['coffee_grade'];
            $quantity = $ro['quantity'];
            $price = $ro['price'];
            $location = $ro['location'];
        }
        if ($msg != "/cancel" && ($buyer_telegram_id != NULL && $zone == NULL)) {
            setTransactionValue($chat_id, "zone", "$msg");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the Neighborhood");
        } else if ($msg != "/cancel" && ($zone != NULL && $neighborhood == NULL)) {
            setTransactionValue($chat_id, "neighborhood", "$msg");
            coffeeContractMenu($chat_id);
        } else if ($msg != "/cancel" && ($neighborhood != NULL && $contract_name == NULL)) {
            setTransactionValue($chat_id, "contract_name", "$msg");
            search($chat_id);
        } else if ($msg != "/cancel" && $msg == "🔍 Search") {
            $data = http_build_query(['text' => 'Search seller using the button below. If the seller is not registerd press cancel from the menu with three bars on the left, and register him/her before the transaction.', 'chat_id' => $chat_id]);
            $keyboard = json_encode([
                "inline_keyboard" => [[
                    ["text" => "Search", "switch_inline_query_current_chat" => ""],
                ],], 'resize_keyboard' => true, "one_time_keyboard" => true
            ]);
            file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
        } else if ($msg != "/cancel" && ($contract_name != NULL && $seller_name == NULL)) {
            setTransactionValue($chat_id, "seller_name", "$msg");
            $sellerPic = "SELECT * FROM sellers WHERE fullname='$msg'";
            $sellerPicQuery = mysqli_query($con, $sellerPic);
            while ($row = mysqli_fetch_array($sellerPicQuery)) {
                $sellerPicture = $row['picture'];
            }
            if ($sellerPicture == NULL) {
                $updateSellersPic = "UPDATE sellers SET edit='TRUE' , editor_id='$chat_id' WHERE fullname ='$msg'";
                $updateSellersPicQuery = mysqli_query($con, $updateSellersPic);
                $updateTransactionquantity = "UPDATE transaction_temp SET edit='TRUE' WHERE buyer_telegram_id ='$chat_id'";
                $updateTransactionquantityquery = mysqli_query($con, $updateTransactionquantity);
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=This seller does not have a photo. Please enter a photo of the seller first");
                file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please use the attach button to take or select a photo. NO caption required");
            } else {
                if ($msg != "/cancel") {
                    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please add a photo of the coffee");
                    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please use the attach button to take or select a photo. NO caption required");
                }
            }
        } else if ($msg != "/cancel" && ($picture != NULL && $quantity == NULL)) {
            setTransactionValue($chat_id, "quantity", "$msg");
            $getPrice = "SELECT * FROM price WHERE contract_name='$contract_name' ORDER BY id DESC Limit 1";
            $getPriceQuery = mysqli_query($con, $getPrice);
            while ($go = mysqli_fetch_array($getPriceQuery)) {
                $coffeePrice = $go['price'];
            }
            $quantityNumber = (int)$msg;
            $priceNumber = (int)$coffeePrice;
            $total = $quantityNumber * $priceNumber;
            setTransactionValue($chat_id, "price", "$priceNumber");
            setTransactionValue($chat_id, "total", "$total");
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
    //  else if ($transactioneditRow > 0) {
    //     while ($ro = mysqli_fetch_array($checkTransactionExistanceQuery)) {
    //         $buyer_telegram_id = $ro['buyer_telegram_id'];
    //         $zone = $ro['zone'];
    //         $neighborhood = $ro['neighborhood'];
    //         $contract_name = $ro['contract_name'];
    //         $process = $ro['process'];
    //         $seller_name = $ro['seller_name'];
    //         $picture = $ro['picture'];
    //         // $coffee_grade = $ro['coffee_grade'];
    //         $quantity = $ro['quantity'];
    //         $price = $ro['price'];
    //         $location = $ro['location'];
    //     }
    // }
    //////////////////////////////////////////////////////
    if ($msg == "Report" && ($AdminRow > 0 || $buyerRow > 0)) {
        reportSorting($chat_id);
    }
    if ($msg == "Daily" && ($AdminRow > 0 || $buyerRow > 0)) {
        reportAll($chat_id);
    }
    if ($msg == "By Farm" && ($AdminRow > 0 || $buyerRow > 0)) {
        if ($reportRow < 1) {
            $inserQuery = $con->query("INSERT INTO report(telegram_id) VALUES('$chat_id')");
        }
        coffeeContractMenu($chat_id);
    }
    if ($reportRow > 0) {
        while ($ro = mysqli_fetch_array($checkReportQuery)) {
            $reportChatId = $ro['telegram_id'];
        }
        reportByContract($chat_id, $msg);
        $deletReportRow = "DELETE FROM report WHERE telegram_id='$reportChatId'";
        $deletReportRowQuery = mysqli_query($con, $deletReportRow);
    }
    if ($msg == "Request Price" && $AdminRow > 0) {
        $inserQuery = $con->query("INSERT INTO price_temp(telegram_id,date_registered) VALUES('$chat_id','$today')");
        coffeeContractMenu($chat_id);
    } else if ($priceRow > 0) {
        while ($ro = mysqli_fetch_array($checkPriceExistanceQuery)) {
            $priceid = $ro['id'];
            $price = $ro['price'];
            $telegram_id = $ro['telegram_id'];
            $contract_name = $ro['contract_name'];
            $status = $ro['status'];
            $date_registered = $ro['date_registered'];
        }
        $lastid = "SELECT * FROM price_temp WHERE telegram_id='$chat_id' ORDER BY id DESC Limit 1";
        $lastidquery = mysqli_query($con, $lastid);
        while ($ro = mysqli_fetch_array($lastidquery)) {
            $priceLastId = $ro['id'];
        }
        if ((($telegram_id != NULL && $contract_name == NULL) && $status == "FALSE") && $msg != "/cancel") {
            setPriceValue($chat_id, "contract_name", "$msg", $priceLastId);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the price to be requested");
        } else if (($contract_name != NULL &&  $price == NULL) && $msg != "/cancel") {
            setPriceValue($chat_id, "price", "$msg", $priceLastId);
            priceConfirmation($chat_id);
        }
        if ($msg == "Confirm Request" && $status == "FALSE") {
            setPriceValue($chat_id, "status", "TRUE", $priceLastId);
            priceConfirmationReply($chat_id);
        }
        if ($msg == 'Discard Request' && $status == "FALSE") {
            $lastid = "SELECT * FROM price_temp WHERE telegram_id='$chat_id' ORDER BY id DESC Limit 1";
            $lastidquery = mysqli_query($con, $lastid);
            while ($ro = mysqli_fetch_array($lastidquery)) {
                $priceLastId = $ro['id'];
            }
            $deletRequest = $con->query("DELETE FROM price_temp where  telegram_id='$chat_id' &&  id='$priceLastId'");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Your request canceled");
            buyerAdminMainMenu($chat_id);
        }
    }
    /////////////////////EDIT PRICE //////////////////////////////////
    if ($EditpriceRow > 0) {
        while ($ro = mysqli_fetch_array($checkEditPriceExistanceQuery)) {
            $priceid = $ro['id'];
            $price = $ro['price'];
            $telegram_id = $ro['telegram_id'];
            $admin_telegram_id = $ro['admin_telegram_id'];
            $contract_name = $ro['contract_name'];
            $status = $ro['status'];
            $date_registered = $ro['date_registered'];
        }
        $lastid = "SELECT * FROM edit_price WHERE telegram_id='$chat_id' ORDER BY id DESC Limit 1";
        $lastidquery = mysqli_query($con, $lastid);
        while ($ro = mysqli_fetch_array($lastidquery)) {
            $priceLastId = $ro['id'];
        }
        if (($contract_name != NULL && $price == NULL) && $status == "EDIT") {
            setEditPrice($chat_id, "price", "$msg", $priceLastId);
            priceEditMenu($chat_id);
        }
        if ($msg == "Confirm Price" && $status == "EDIT") {
            $updatePriceTable = "INSERT INTO price(telegram_id,contract_name,price,date_registered) VALUES('$telegram_id','$contract_name','$price','$today')";
            mysqli_query($con,  $updatePriceTable);
            $marksHTML = "Dear Admin, " . "%0A";
            $marksHTML .=  "your new price request has been adjusted by the owner. Refer to the below" . "%0A";
            $marksHTML .= "<b>Farm name:- </b>" . strtolower($contract_name) . "%0A";
            $marksHTML .= "<b>Updated price:-</b>" . strtolower($price) . "%0A";
            $marksHTML .= "NOTE:- This price is only valid for 30 days.";
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $admin_telegram_id . "&text= " . $marksHTML . "&parse_mode=html");
            $del = "DELETE FROM edit_price WHERE telegram_id='$chat_id'";
            mysqli_query($con, $del);
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Price updated");
            companyAdminMainMenu($chat_id);
        }
        if ($msg == 'Discard Price' && $status == "EDIT") {
            $deletRequest = $con->query("DELETE FROM edit_price where  telegram_id='$chat_id' ");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Your request canceled");
            companyAdminMainMenu($chat_id);
        }
    }
    ////////////////////////////////////////////////////
    if ($msg == 'Approve Price' && $companyRow > 0) {
        listRequestedPrice($chat_id);
    }
    if ($msg == '/cancel') {
        $delettransactionfromtemp = "DELETE FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
        mysqli_query($con, $delettransactionfromtemp);
        $deletuserregistration = "DELETE FROM company_users_temp WHERE company_telegram_id='$chat_id'";
        mysqli_query($con, $deletuserregistration);
        $deletsellerregistration = "DELETE FROM sellers_temp WHERE admin_telegram_id='$chat_id'";
        mysqli_query($con,  $deletsellerregistration);
        $deletpricerequest = "DELETE FROM price_temp WHERE telegram_id='$chat_id'";
        mysqli_query($con,  $deletpricerequest);
        $deletecontract = "DELETE FROM coffee_contract WHERE telegram_id='$chat_id' AND status='FALSE'";
        mysqli_query($con, $deletecontract);
        $deletRequest = $con->query("DELETE FROM edit_price where  telegram_id='$chat_id' ");
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Canceled!");
        if ($AdminRow > 0) {
            buyerAdminMainMenu($chat_id);
        } else if ($buyerRow > 0) {
            buyerMenu($chat_id);
        } else if ($companyRow > 0) {
            companyAdminMainMenu($chat_id);
        }
    }
    //////////////////////////////////////////////////////
    if ($msg == "Add New Farm" && $AdminRow > 0) {
        $inserQuery = $con->query("INSERT INTO coffee_contract(telegram_id,date_registered) VALUES('$chat_id','$today')");
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter farm name.");
    } else if ($coffeeContractQuantity > 0) {
        while ($ro = mysqli_fetch_array($coffeeContractQuery)) {
            $telegram_id = $ro['telegram_id'];
            $coffee_contract = $ro['contract_name'];
            $status = $ro['status'];
        }
        if ((($telegram_id != NULL && $coffee_contract == NULL) && $status == "FALSE") && $msg != "/cancel") {
            setFarmValue($chat_id, "contract_name", $msg);
            confirmFarm($chat_id);
        }
        if (($msg == "Confirm Farm" && $coffee_contract != NULL) && $status == "FALSE") {
            setFarmValue($chat_id, "status", "TRUE");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Farm registration complete, please add a price for this farm by selecting Request Price on the menu.");
            buyerAdminMainMenu($chat_id);
        }
        if (($msg == "Discard Farm" && $coffee_contract != NULL) && $status == "FALSE") {
            $lastid = "SELECT * FROM coffee_contract WHERE telegram_id='$chat_id' && status='FALSE'ORDER BY id DESC Limit 1";
            $lastidquery = mysqli_query($con, $lastid);
            while ($ro = mysqli_fetch_array($lastidquery)) {
                $farmID = $ro['id'];
            }
            $deletRequest = $con->query("DELETE FROM coffee_contract where  telegram_id='$chat_id' &&  id='$farmID'");
            file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Farm registration canceled");
            buyerAdminMainMenu($chat_id);
        }
    }
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
    $inserQuery = $con->query("INSERT INTO transaction_temp(buyer_telegram_id,location,transaction_date,longitude,latitude) VALUES('$chat_id','$transactionLocation','$today',$transactionlong,$transactionlat)");
    file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter zone.");
} else if (isset($update->callback_query->data)) {
    $chat_id = $update->callback_query->from->id;
    $message_id =  $update->callback_query->message->message_id;
    list($first, $id) = explode(" ", $update->callback_query->data);
    if ($first == "e") {
        acceptCompany($id, $chat_id, $message_id);
    } else if ($first == "d") {
        delete($id, $chat_id, $message_id);
    } else if ($first == "a") {
        accept($id, $chat_id, $message_id);
    } else if ($first == "n") {
        declinePrice($id, $chat_id, $message_id);
    } else if ($first == "L") {
        accessLocation($id, $chat_id);
    } else if ($first == "c") {
        changeprice($id, $chat_id, $message_id);
    }
    list($full, $half) = explode("_", $update->callback_query->data);
    if ($full == "v") {
        previewSeller($half, $chat_id);
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
    $url = $botAPI . "/answerInlineQuery?inline_query_id=$queryId&results=$result&cache_time=0&switch_pm_text=Your results&switch_pm_parameter=123";
    file_get_contents($url);
} else if (isset($update->message->photo)) {
    $pic = $update->message->photo[0]->file_id;
    $chat_id = $update->message->chat->id;
    $checkTransactionExistance = "SELECT * FROM transaction_temp WHERE buyer_telegram_id='$chat_id'";
    $checkTransactionExistanceQuery = mysqli_query($con, $checkTransactionExistance);
    while ($transaction = mysqli_fetch_array($checkTransactionExistanceQuery)) {
        $buyerId = $transaction['buyer_telegram_id'];
        $quantity = $transaction['quantity'];
        $edit = $transaction['edit'];
    }
    ///////////////////////
    $checkSellerTempExistance = "SELECT * FROM sellers_temp WHERE admin_telegram_id ='$chat_id'";
    $checkSellerTempExistanceQuery = mysqli_query($con, $checkSellerTempExistance);
    while ($registration = mysqli_fetch_array($checkSellerTempExistanceQuery)) {
        $adminId = $registration['admin_telegram_id'];
    }
    ////////////////////////////////////
    $checkSellerPicExistance = "SELECT * FROM sellers WHERE edit='TRUE' AND editor_id='$chat_id'";
    $checkSellerPicExistanceQuery = mysqli_query($con, $checkSellerPicExistance);
    while ($pictureRow = mysqli_fetch_array($checkSellerPicExistanceQuery)) {
        $editorId = $pictureRow['editor_id'];
    }
    print($editorId);
    ///////////////////////
    if ($adminId != NULL) {
        setSellersValue($chat_id, "picture", $pic);
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the Woreda.");
    } else if ($buyerId != NULL &&  $edit == 'FALSE') {
        setTransactionValue($chat_id, "picture", $pic);
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please enter the coffee quantity in Kg.");
    } else if ($editorId != NULL) {
        editSellersValue($chat_id, "picture", $pic);
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Seller picture updated.");
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please add a photo of the coffee");
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Please use the attach button to take or select a photo. NO caption required");
        $updateTransactionquantity = "UPDATE transaction_temp SET edit='FALSE' WHERE buyer_telegram_id ='$chat_id'";
        $updateTransactionquantityquery = mysqli_query($con, $updateTransactionquantity);
    } else {
        file_get_contents($botAPI . "/sendmessage?chat_id=" . $chat_id . "&text=Not matched.");
    }
}

<?php
function setCompanyValue($id, $key, $temp)
{
    global $con;
    $now = "UPDATE company_temp SET $key ='$temp' WHERE telegram_id='$id'";
    mysqli_query($con, $now);
}
function setUserValue($id, $key, $temp)
{
    global $con;
    $now = "UPDATE company_users_temp SET $key ='$temp' WHERE company_telegram_id='$id'";
    mysqli_query($con, $now);
}
function setTransactionValue($id, $key, $temp)
{
    global $con;
    $now = "UPDATE transaction_temp SET $key ='$temp' WHERE buyer_telegram_id='$id'";
    mysqli_query($con, $now);
}
function setSellersValue($id, $key, $temp)
{
    global $con;
    $now = "UPDATE sellers_temp SET $key ='$temp' WHERE admin_telegram_id='$id'";
    mysqli_query($con, $now);
}
function setPriceValue($id, $key, $temp, $priceId)
{
    global $con;
    $now = "UPDATE price_temp SET $key ='$temp' WHERE telegram_id='$id' && id='$priceId' ";
    mysqli_query($con, $now);
}
function setEditPrice($id, $key, $temp, $priceId)
{
    global $con;
    $now = "UPDATE edit_price SET $key ='$temp' WHERE telegram_id='$id' && id='$priceId' ";
    mysqli_query($con, $now);
}
function setFarmValue($id, $key, $temp)
{
    global $con;
    $now = "UPDATE coffee_contract SET $key ='$temp' WHERE telegram_id='$id' && status='FALSE'";
    mysqli_query($con, $now);
}

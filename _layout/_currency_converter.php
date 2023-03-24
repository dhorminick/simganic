<?php
    //Get User Choosen Currency From Users DB
    $GetUserCurrency = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $UserCurrencyResult = $con->query($GetUserCurrency);

    if ($UserCurrencyResult->num_rows > 0) {
        // output data of each row
        $urow = $UserCurrencyResult->fetch_assoc();
        $user_selected_currency = $urow["_currency"]; //eg NGN, USD
        
    } else {
        $user_selected_currency = "NGN";
        $Update_Currency = "UPDATE _users SET _currency = '$user_selected_currency' WHERE _email = '$_user_email_address'";
        $Update_CurrencyResult = $con->query($Update_Currency);
    }

    //Get Currency Value From Currency DB
    $GetCurrencyConversionValue = "SELECT * FROM _currency WHERE _currency_name = '$user_selected_currency'";
    $CurrencyConversionValueResult = $con->query($GetCurrencyConversionValue);

    if ($CurrencyConversionValueResult->num_rows > 0) {
        // output data of each row
        $orow = $CurrencyConversionValueResult->fetch_assoc();
        $user_selected_currency_conversion_to_naira_rate = $orow["_value"];
        $user_selected_currency_symbol = $orow["_symbol"];
        
        
    } else {
        $user_selected_currency_conversion_to_naira_rate = "1";
        $user_selected_currency_symbol = "&#8358;";
    }

    
    
    
?>
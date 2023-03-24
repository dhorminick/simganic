<?php
	$GetUserDetails = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $UserDetailsResult = $con->query($GetUserDetails);

    if ($UserDetailsResult->num_rows > 0) {
        // output data of each row
        $row = $UserDetailsResult->fetch_assoc();
        $_email = $row["_email"];
        $_username = $row["_username"];
        $_firstname = $row["_firstname"];
        $_lastname = $row["_lastname"];
        $_shippingaddress = $row["_shippingaddress"];
        $_city = $row["_city"];
        $_state = $row["_state"];
        $_phone = $row["_phone"];
        
    } else {
        header("Location: 404");
        //404 error
    }
?>
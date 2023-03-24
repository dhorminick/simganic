<?php
    session_start();
    
    //dbconn
    include '_layout/_dbconnection.php';
 
    $message = [];

    if (!isset($_SESSION['loggedin'])) {
        header("Location: sign-in?redirect=my-account");
        exit();
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    if (isset($_POST["subscribe"])) {
        $UpNotification = "UPDATE _users SET _newsletter = 1 WHERE _email = '$_user_email_address'";
        $UpNotificationRes = mysqli_query($con,$UpNotification);
        if ($UpNotificationRes) {
            array_push($message, "Subscribed To Email Newsletter and Notifications.");
        }
    }

    if (isset($_POST["unsubscribe"])) {
        $UpNotification = "UPDATE _users SET _newsletter = 0 WHERE _email = '$_user_email_address'";
        $UpNotificationRes = mysqli_query($con,$UpNotification);
        if ($UpNotificationRes) {
            array_push($message, "Unsubscribed From Email Newsletter and Notifications.");
        }
    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;

    $SearchUserRecords = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $SearchUserResult = mysqli_query($con, $SearchUserRecords);
    if ($SearchUserResult -> num_rows > 0) {
       $row = mysqli_fetch_assoc($SearchUserResult);
       $email = $row["_email"];
       $username = $row["_username"];
       $firstname = $row["_firstname"];
       $lastname = $row["_lastname"];
       $phone = $row["_phone"];
       $newsletter = $row["_newsletter"];
       $currency = $row["_currency"];
       $language = $row["_language"];
       $isverified = $row["isverified"];
       $city = $row["_city"];
       $state = $row["_state"];
       $shippingaddress = $row["_shippingaddress"];

    }else{
        header("Location: 404");
    }

    include '_layout/_arrays.php';
    if ($city == null && $state == null && $shippingaddress == null || $city == "" && $state == "" && $shippingaddress == "") {
        # code...
        $address = "No Shipping Address Added.";
    }else{
        $cityname =  $cities[$city];
        $address = ucwords($shippingaddress).",".ucwords($cityname).",".ucwords($state).",Nigeria";
    }
    $currency = $currencies[$currency];
    $language = $lang[$language];
    
    $SearchCartRecords = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address'";
    $SearchCartResult = mysqli_query($con, $SearchCartRecords);
    if ($SearchCartResult ->num_rows > 0) {
        $cartRowCount = mysqli_num_rows($SearchCartResult);
    }else{
        $cartRowCount = 0;
    }

    $SearchWishlistRecords = "SELECT * FROM _allwishlist WHERE _emailaddress = '$_user_email_address'";
    $SearchWishlistResult = mysqli_query($con,$SearchWishlistRecords);
    if ($SearchWishlistResult ->num_rows > 0) {
        $wishlistRowCount = mysqli_num_rows($SearchWishlistResult);
    }else{
        $wishlistRowCount = 0;
    }

    $SearchDisputesRecords = "SELECT * FROM _disputes WHERE dispute_email = '$_user_email_address' AND status != 'closed'";
    $SearchDisputesResult = mysqli_query($con,$SearchDisputesRecords);
    if ($SearchDisputesResult ->num_rows > 0) {
        $disputeRowCount = mysqli_num_rows($SearchDisputesResult);
    }else{
        $disputeRowCount = 0;
    }

    $SearchOrderRecord = "SELECT * FROM _allorders WHERE email = '$_user_email_address' AND status = 'paid' OR email = '$_user_email_address' AND status ='shipped' OR email = '$_user_email_address' AND status ='delivered'";
    $SearchOrderResults = mysqli_query($con,$SearchOrderRecord);
    if ($SearchOrderResults -> num_rows > 0) {
        $orderRowCount = mysqli_num_rows($SearchOrderResults);
    }else{
        $orderRowCount = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Account Details - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">
<link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.min.css">
<link rel="stylesheet" href="assets/css/components.min.css">
<link rel="stylesheet" href="assets/css/mystyle.css">
</head>

<body class="layout-1">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <?php include '_layout/_header_sidebar.php';?>

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1 class="show-bg">Account Details</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item">Account Details</div>
                    </div>
                    <style>
                        .section .section-header .section-header-breadcrumb{
                            margin-left: auto !important;
                        }
                        .wizard-steps .wizard-step .wizard-step-label{
                            font-size: 13px !important;
                        }
                        .col-user{
                            margin-top: 30px;

                        }
                        .edit-details{
                            float: right;

                        }
                        .btn-edit-details{
                            padding: 10px;
                            border:none;
                            font-weight: bolder;
                            width: 200px;
                        }
                        .btn-ship{
                            padding: 10px;
                            border:none;
                            text-transform: uppercase;
                            font-weight: bolder;
                        }
                        @media screen and (max-width: 600px) {
                          .btn-edit-details{
                            width: 100%;
                          }
                        }
                        .wizard-steps .wizard-step.wizard-step-active{
                            box-shadow: none !important;
                        }
                        .wizard-steps .wizard-step:before{
                            content: none;
                        }
                        .wizard-steps .wizard-step{
                            padding: 25px;
                            border-radius: 5px;
                        }
                        .wizard-steps a,
                        .wizard-steps a:hover{
                            text-decoration: none !important;
                            color: white !important;
                        }
                        
                    </style>
                </div>
                <div class="section-body">
                <?php if (count($message) > 0) : ?>
                            <div class="alert-div">
                                <?php foreach ($message as $error) : ?>
                                <div class="alert alert-primary alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert"><span>×</span></button>
                                        <?php echo $error ?>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                <div class="row" style="margin-bottom:40px;">
                        <div class="col-12 col-lg-12">
                            <div class="wizard-steps">
                                <div class="wizard-step wizard-step-active">
                                    <a href="cart"><div class="wizard-step-icon">
                                        <i class="fas fa fa-cart-plus"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php echo $cartRowCount;?> Product(s) In Cart
                                    </div></a>
                                </div>
                                <div class="wizard-step wizard-step-active">
                                    <a href="disputes"><div class="wizard-step-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php echo $disputeRowCount;?> Opened Dispute(s)
                                    </div></a>
                                </div>
                                <div class="wizard-step wizard-step-active">
                                    <a href="shipped-products"><div class="wizard-step-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php echo $orderRowCount;?> New Orders
                                    </div></a>
                                </div>
                                <div class="wizard-step wizard-step-active">
                                    <a href="wishlist"><div class="wizard-step-icon">
                                        <i class="fas fa fa-heart-circle-check"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php echo $wishlistRowCount;?> WishList Item(s)
                                    </div></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-12 col-user">
                            <h5>Account Details: <span class="edit-details"><a href="/account/update-account-details"><i class="fa fa-pen"></i></a></span></h5>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-title-tab"><h6>Username:</h6></div>
                                <div class="col-lg-9"><?php echo $username;?></div>
                            </div><hr>
                            <div class="row">
                                <div class="col-lg-3 col-title-tab"><h6>Email Addresss:</h6></div>
                                <div class="col-lg-9"><?php echo $_user_email_address;?> <?php if ($isverified == 1) { ?><span style="float:right;color:green;"><i class="fa fa-circle-check"></i> verified</span><?php }else if ($isverified == 0) {?><span style="float:right;color:red;"><i class="fa fa-cancel"></i> unverified</span><?php }?></div>
                            </div><hr>
                            <div class="row">
                                <div class="col-lg-3 col-title-tab"><h6>Shipping Address:</h6></div>
                                <div class="col-lg-9"><?php echo $address;?></div>
                            </div><hr>
                            <div class="row">
                                <div class="col-lg-3 col-title-tab"><h6>Language:</h6></div>
                                <div class="col-lg-9"><?php echo $language;?></div>
                            </div><hr>
                            <div class="row">
                                <div class="col-lg-3 col-title-tab"><h6>Currency:</h6></div>
                                <div class="col-lg-9"><?php echo $currency;?></div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-12 text-right"><a href="/account/update-account-details"><button class="btn-primary btn-edit-details">EDIT DETAILS</button></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:40px;">
                        <div class="col-lg-6" style="margin-bottom:20px;">
                            <h5>Newsletter Subscription <span class="edit-details"></span></h5>
                            <?php if ($newsletter == 1) { ?>
                            <hr><p>You are <strong>currently subscribed</strong> to all our newsletters and blog notifications.</p>
                            <form method="post" action="">
                                <button class="btn-primary w-100 btn btn-ship" name="unsubscribe">UNSUBSCRIBE</button>
                            </form>
                            <?php }else if ($newsletter == 0) {?>
                            <hr><p>You are <strong>currently not subscribed</strong> to any of our newsletters or blog notifications.</p>
                            <form method="post" action="">
                                <button class="btn-primary w-100 btn btn-ship" name="subscribe">SUBSCRIBE</button>
                            </form>
                            <?php }?>
                        </div>
                        <div class="col-lg-6">
                            <h5>Shipping Address <span class="edit-details"></span></h5>
                            <hr><p><?php echo $address;?></p>
                            <a href="/account/update-shipping-address"><button class="btn-primary w-100 btn btn-ship">Update Shipping Address</button></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/summernote/summernote-bs4.js"></script>

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

<!-- features-profile.html  Tue, 07 Jan 2020 03:35:33 GMT -->
</html>
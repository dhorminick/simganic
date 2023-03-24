<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    

    $message = [];
    
    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Frequently Asked Questions - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->

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
                    <div class="section-header-breadcrumb"  style="margin-left:auto;">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item">FAQ's</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="col-12 col-lg-12">
                        <h4><i class="fa fa-hashtag"></i> Frequently Asked Questions</h4><br>
                        <div id="accordion">
                            <div class="accordion" id="using-simganic">
                                <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2" aria-expanded="true">
                                    <h4><i class="fas fa-plus"></i> How To Shop On SimGanic</h4>
                                </div>
                                <div class="accordion-body collapse show" id="panel-body-2" data-parent="#accordion" style="">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                </div>
                            </div>
                            <div class="accordion" id="return-product">
                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                                        <h4><i class="fas fa-plus"></i> How To Return A Product</h4>
                                </div>
                                <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                </div>
                            </div>
                            <div class="accordion" id="report-product">
                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-3" aria-expanded="false">
                                    <h4><i class="fas fa-plus"></i> How To Report A Product</h4>
                                </div>
                                <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion" style="">
                                    <p class="mb-0" style="margin-bottom:10px !important;">In case of a misplaced or damaged products after order, you can report a product in the following steps:</p>
                                    <div><div class="bullet"></div><a href="sign-in">Login to your SimGanic account</a></div>
                                    <div><div class="bullet"></div>Navigate to <a href="my-account">My Account</a></div>
                                    <div><div class="bullet"></div>Navigate to my <a href="shipped-products">Shipped Products</a> page</div>
                                    <div><div class="bullet"></div>Click  <a href="shipped-products">shipped products</a> page</div>
                                </div>
                            </div>
                            <div class="accordion" id="cancel-order">
                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-4" aria-expanded="false">
                                        <h4><i class="fas fa-plus"></i> How To Cancel An Order</h4>
                                </div>
                                <div class="accordion-body collapse" id="panel-body-4" data-parent="#accordion" style="">
                                    <p class="mb-0">Orders can be cancelled <strong>"before"</strong> the status updates to "shipped"</p>
                                </div>
                            </div>
                            <div class="accordion" id="unverified-and-verified-purchaser">
                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-5" aria-expanded="false">
                                    <h4><i class="fas fa-plus"></i> Verified and Unverified Purchaser Review</h4>
                                </div>
                                <div class="accordion-body collapse" id="panel-body-5" data-parent="#accordion" style="">
                                    <p class="mb-0">Our reviews are grouped based on if the reviewer has purchased the product or not. Reviews tagged <span style="color:green;font-family:12px;padding:0px 5px;"><i class="fa fa-check-circle"></i> verified purchaser</span> bears proof that the reviewer has purchased and tasted the product giving the review more crediblity. While reviews tagged <span style="color:red;font-family:12px;padding:0px 5px;"><i class="fa fa-times-circle"></i> unverified purchaser</span> shows that the reviewer has neither bought or used the product.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                            
                    </style>
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

<!-- Page Specific JS File -->


<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
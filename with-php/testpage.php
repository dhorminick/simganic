<?php
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    session_start();

    $message = [];
    
    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    if ($_SESSION['lastname'] != null && $_SESSION['firstname'] != null) {
        $usr = $_SESSION['firstname'].' '.$_SESSION['lastname'];
    }else{
        $usr = $_SESSION['username'];
    }

    /*$arz = [];
    
    $arz = serialize($arz);
    echo $arz;*/
    if (isset($_POST["submit-mssge"])) {
        $mssge = htmlentities(preg_quote(quotemeta($_POST["mssge"])));
        echo "<script>alert($mssge)</script>";
        $SingleOrders = "SELECT * FROM dummy WHERE  id = 5";
        $SingleOrdersResult = $con->query($SingleOrders);
        if ($SingleOrdersResult -> num_rows > 0) {
            while($_row = mysqli_fetch_array($SingleOrdersResult)){
                $replies = $_row["datetime"];

                $replies = unserialize($replies);
                $randId = crc32($mssge);
                $newreply = array(array(
                            'id' => $randId, 
                            'name' => 'SimGanic', 
                            'role' => 'Admin', 
                            'message' => $mssge,
                ));
                $inpReply = array_merge($replies, $newreply);
                $inpReply = serialize($inpReply);
                $DismissDisputes = "UPDATE dummy SET datetime = '$inpReply' WHERE id = 5";
                $DismissDisputesResult = $con->query($DismissDisputes);
                if ($DismissDisputesResult) {
                    array_push($message, "Succesfully.");
                }else{
                    array_push($message, "Unsuccessful: {$con->error}");
                }
            }
        }
        

        # var_dump($arr);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Frequently Asked Questions &mdash; SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.min.css">
<link rel="stylesheet" href="assets/css/components.min.css">
<link rel="stylesheet" href="assets/css/mystyle.css">
<link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
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
                        <div class="breadcrumb-item">FAQs</div>
                    </div>
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
                    <div id="details">
                        <!--<div class="row description">
                        <div class="col-12 col-lg-12">
                            <div class="col-12 col-lg-12 col-md-6">
                                <img src="assets\img\products\p-01.jpg" class="img-desc">
                            </div>
                            <div class="col-12 col-lg-12 col-md-6">
                                <h4 class="pname">Organic Yorgurt Beer</h4>
                                <div><span>Dairy</span><div class="bullet"></div>2 Review(s)</div>
                                <div class="pdesc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel maximus lacus. Duis ut mauris eget justo dictum tempus sed vel tellus.
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        </div>-->
                        <img alt="image" src="assets/img/products/p-01.jpg" width="150" height="150" style="float:left;margin-right:10px;">
                        <div>
                            <h4 class="pname">Organic Yorgurt Beer</h4>
                            <div><span><a href="">Dairy</a></span><div class="bullet"></div>2 Sample Reviews</div><br>
                            <div class="pdesc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel maximus lacus. Duis ut mauris eget justo dictum tempus sed vel tellus.
                            </div><br>
                        </div>
                        <div style="float:right;margin-top:10px;">
                            <a href="" class="btn btn-primary"><i class="fa fa-arrow-left"></i> View Sample Reviews</a>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div> 
                    </div>
                    <div class="row top-rated-div">
                        <div class="col-lg-4">
                            <div id="coming-soon-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators -indicators">
                                    <li data-target="#coming-soon-carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#coming-soon-carousel" data-slide-to="1"></li>
                                    <li data-target="#coming-soon-carousel" data-slide-to="2"></li>
                                    <li data-target="#coming-soon-carousel" data-slide-to="3"></li>
                                    <li data-target="#coming-soon-carousel" data-slide-to="4"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item items active">
                                        <div class="-p">
                                            <div class="img-div-coming-soon">
                                                <img alt="image" src="assets/img/products/p-01.jpg" class="w-100">
                                                <div><span class="div-text">COMING SOON<span></div>
                                            </div>
                                            <div class="p-details">
                                            <center>
                                                <div class="p-category text-small"><a href="">Dairy</a></div>
                                                <div class="p-name"><a href=""><h4>Organic Product Name</h4></a></div>
                                                <hr>
                                                <div class="view-p">
                                                    <i title data-toggle="tooltip" data-placement="right" data-original-title="Set Notification" class="btn btn-primary btn-wishlist-fpage fa fa-bell" onclick="toggleNotification(this)"></i>
                                                                
                                                    <a href="/products/plink/" class="btn btn-primary btn-user-sample">View Sample Reviews</a>
                                                                    
                                                    <button class="btn btn-primary btn-wishlist-fpage btn-view-details" title data-toggle="tooltip" data-placement="left" data-original-title="View Product Details"><i class="fa fa-search"></i></button>
                                                </div>
                                            </center>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="carousel-item items">
                                        <div class="-p">
                                            <div class="img-div-coming-soon">
                                                <img alt="image" src="assets/img/products/p-01.jpg" class="w-100">
                                                <div><span class="div-text">COMING SOON<span></div>
                                            </div>
                                            <div class="p-details">
                                            <center>
                                                <div class="p-category text-small"><a href="">Dairy</a></div>
                                                <div class="p-name"><a href=""><h4>Organic Product Name</h4></a></div>
                                                <hr>
                                                <div class="view-p">
                                                    <i title data-toggle="tooltip" data-placement="right" data-original-title="Set Notification" class="btn btn-primary btn-wishlist-fpage fa fa-bell" onclick="toggleNotification(this)"></i>
                                                                
                                                    <a href="/products/plink/" class="btn btn-primary btn-user-sample">View Sample Reviews</a>
                                                                    
                                                    <button class="btn btn-primary btn-wishlist-fpage btn-view-details" title data-toggle="tooltip" data-placement="left" data-original-title="View Product Details"><i class="fa fa-search"></i></button>
                                                </div>
                                            </center>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="carousel-item items">
                                        <div class="-p">
                                            <div class="img-div-coming-soon">
                                                <img alt="image" src="assets/img/products/p-01.jpg" class="w-100">
                                                <div><span class="div-text">COMING SOON<span></div>
                                            </div>
                                            <div class="p-details">
                                            <center>
                                                <div class="p-category text-small"><a href="">Dairy</a></div>
                                                <div class="p-name"><a href=""><h4>Organic Product Name</h4></a></div>
                                                <hr>
                                                <div class="view-p">
                                                    <i title data-toggle="tooltip" data-placement="right" data-original-title="Set Notification" class="btn btn-primary btn-wishlist-fpage fa fa-bell" onclick="toggleNotification(this)"></i>
                                                                
                                                    <a href="/products/plink/" class="btn btn-primary btn-user-sample">View Sample Reviews</a>
                                                                    
                                                    <button class="btn btn-primary btn-wishlist-fpage btn-view-details" title data-toggle="tooltip" data-placement="left" data-original-title="View Product Details"><i class="fa fa-search"></i></button>
                                                </div>
                                            </center>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="carousel-item items">
                                        <div class="-p">
                                            <div class="img-div-coming-soon">
                                                <img alt="image" src="assets/img/products/p-01.jpg" class="w-100">
                                                <div><span class="div-text">COMING SOON<span></div>
                                            </div>
                                            <div class="p-details">
                                            <center>
                                                <div class="p-category text-small"><a href="">Dairy</a></div>
                                                <div class="p-name"><a href=""><h4>Organic Product Name</h4></a></div>
                                                <hr>
                                                <div class="view-p">
                                                    <i title data-toggle="tooltip" data-placement="right" data-original-title="Set Notification" class="btn btn-primary btn-wishlist-fpage fa fa-bell" onclick="toggleNotification(this)"></i>
                                                                
                                                    <a href="/products/plink/" class="btn btn-primary btn-user-sample">View Sample Reviews</a>
                                                                    
                                                    <button class="btn btn-primary btn-wishlist-fpage btn-view-details" title data-toggle="tooltip" data-placement="left" data-original-title="View Product Details"><i class="fa fa-search"></i></button>
                                                </div>
                                            </center>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                            
                                <a class="carousel-control-prev carousel-custom" href="#coming-soon-carousel" role="button" data-slide="prev">
                                    <i class="carousel-control-icons fas fa-chevron-left" aria-hidden="true"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next carousel-custom" href="#coming-soon-carousel" role="button" data-slide="next">
                                    <i class="carousel-control-icons fas fa-chevron-right" aria-hidden="true"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <span class="show-sm"><hr></span>
                        <div class="col-lg-8 div-top-rated-test">
                            <div class="h-50">
                            <div class="col-lg-12 top-rated-header">
                                <h4><i class="fa fa-hashtag"></i> Top Rated Products</h4>
                            </div>
                            <div class="owl-carousel owl-theme slider" id="top-slide">
                                <div>
                                    <div class="p --p">
                                        <div class="p-image">
                                            <img alt="image" src="assets/img/products/p-01.jpg" width="120" height="120">
                                        </div>
                                        <div class="p-details">
                                        <center>
                                            <div class="p-category text-small"><a href="">Dairy</a></div>
                                            <div class="p-name"><a href="">Organic Product Name Category</a></div>
                                            <div class="top-rating-ratings"><span class="star-rating"><span class="width-90percent"></span></span></div>
                                            <div>2 Review(s)</div>
                                        </center>
                                        </div>  
                                    </div>
                                </div>
                                <div>
                                    <div class="p --p">
                                        <div class="p-image">
                                            <img alt="image" src="assets/img/products/p-02.jpg" width="120" height="120">
                                        </div>
                                        <div class="p-details">
                                        <center>
                                            <div class="p-category text-small"><a href="">Dairy</a></div>
                                            <div class="p-name"><a href="">Organic Product Name Category</a></div>
                                            <div class="top-rating-ratings"><span class="star-rating"><span class="width-90percent"></span></span></div>
                                            <div>2 Review(s)</div>
                                        </center>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="h-50">
                            <div class="col-banner">
                                <h3>100% Natural Premium Quality Products.</h3>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <style>
                        .carousel-custom{
                            top: 50% !important;
                            bottom: 50% !important;
                        }
                        .--p{
                            display: flex;
                        }
                        .top-rated-div{
                            margin-top: 10px;
                            margin-bottom: 20px;
                            /*height: 475px;*/
                        }
                        .col-banner{
                            display: block;
                            border: 1px solid #7a58ad;;
                            height: 100%;
                            background-image: url("assets/img/fresh.jpg");
                            background-position: center center;
                            background-repeat: no-repeat;
                            background-size: cover;
                            position: relative;
                            overflow: hidden;
                        }
                        .col-banner h3{
                            width: 40%;
                            position: absolute;
                            right: 0;
                            top: 25%;
                        }
                        @media screen and (max-width: 1000px){
                            .col-banner{
                                margin-left: 10px;
                            }
                            .col-banner h3{
                                width: 40%;
                                position: absolute;
                                right: 0;
                                top: 15%;
                            }
                            .div-top-rated-test{
                                margin-top: 35px;
                            }
                            .h-50{
                                height: auto !important;
                            }
                            .col-banner{
                                margin-top: -39px;
                                height: 200px !important;
                            }
                        }
                        @media screen and (max-width: 312px){
                            .col-banner{
                                display: none;
                            }
                        }
                        .col-mid{
                            margin-bottom: -35px !important;
                        }
                        .top-rated-header{
                            margin-bottom: 15px;
                        }
                        .div-top-rated{
                            display: flex;
                            padding-right: 0px !important;
                            padding-left: 0px !important;
                        }
                        .div-top-rated-test{
                            padding-left: 0px !important;
                            /*padding-right: 0px !important; remove both if adding them on smaller screen*/
                        }
                        .h-200{
                            height: 200px !important;
                        }
                        .div-top-img{
                            margin-right: 10px;
                        }
                        .top-rating-category a{
                            font-size: 10px;
                            font-weight: 700;
                            letter-spacing: 1px;
                            text-transform: uppercase;
                            color: #563d7c;
                        }
                        .top-rating-category{
                            margin-bottom: 5px;
                        }
                        .top-rating-ratings{
                            margin-bottom: 5px;
                        }

                        .carousel-control-icons{
                        background: #563d7c !important;
                            border-radius: 3px;
                            display: inline-block;
                            padding: 10px 12px;
                            font-weight: 900;
                        }
                        .items{
                            border: 1px solid #563d7c;
                        }
                        .-indicators li{
                            display: none !important;
                        }
                        .-p{
                            padding: 5px;
                            background-color: #fafbfe;
                            border-radius: 3px;
                            position: relative;
                            
                        }
                        .carousel-indicators .active {
                            background-color: #fff;
                        }
                        .carousel-control-next{
                            margin-right: 5px !important;
                        }
                        .div-coming-soon{
                            border: 1px solid red;
                            margin-bottom: 0px !important;
                        }
                        .description div{
                            padding: 20px 0px;
                        }
                        .description{
                            display: flex;
                        }
                        .btn{
                            letter-spacing: normal !important; /*Leave Here*/
                        }
                        .description div .img-desc{
                            margin-left: 20px; 
                            width: 350px;
                            height: 350px;
                        }
                        .det{
                            margin-bottom: 15px;
                        }
                        .btn-user-sample{
                            text-transform: uppercase;
                        }
                        .img-div-coming-soon div{
                            position: absolute;
                            top: 0;
                            left: 0;
                            text-align: center;
                            width:100%;
                            padding: 5px 10px;
                        }
                        .div-text{
                            background: #563d7c;
                            color: white;
                            font-weight: 700;
                            padding: 7px 10px;
                        }
                        .product-details div{
                            margin-bottom: 5px;
                        }
                        .p-image{
                            margin-bottom: 10px !important;
                        }
                        .p-category{
                            text-transform: uppercase;
                            margin-bottom: 10px !important;
                            font-size: 11px !important;
                            letter-spacing: 1px !important;
                            font-weight: 400;
                        }
                        .p-name a{
                            font-size: 16px !important;
                            font-weight: 600 !important;
                            margin-bottom: 10px !important;
                        }
                        .p-name{
                            margin-bottom: 10px !important;
                        }
                        .p-prices{
                            font-weight: 700;
                            margin-bottom: 10px !important;
                        }
                        .p{
                            padding: 5px;
                            background-color: #fafbfe;
                            border-radius: 3px;
                            border: 1px solid #dae1f4;
                            position: relative;
                            margin-bottom: 30px;
                        }
                        .p-details{
                            background-color: white;
                            padding: 10px;
                        }
                        .slider-me .owl-nav [class*=owl-] {
                            position: absolute;
                            top: 0;
                            left: 35px;
                            -webkit-transform: translate(-50%, -50%);
                            transform: translate(-50%, -50%);
                            margin: 0;
                            background-color: #000;
                            border-radius: 50%;
                            color: #fff;
                            width: 40px;
                            height: 40px;
                            line-height: 34px;
                            opacity: .3;
                        }
                        .slider-me .owl-nav .owl-next {
                            left: 80px;
                        }
                        .slider{
                            right: 0;
                        }
                    </style>

                    <div class="owl-carousel owl-theme slider" id="test-slide">
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-01.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-02.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-03.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-04.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-05.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-06.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/p-07.jpg" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="">Dairy</a></div>
                                    <div class="p-name"><a href="">Organic Product Name</a></div>
                                    <div class="p-prices">₦ 1000 - ₦ 2500</div>
                                    <div class="view-p">
                                        <a href="/products/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        
                    </div>
                    <?php
                        $SingleOrders = "SELECT * FROM dummy WHERE  id = 5";
                        $SingleOrdersResult = $con->query($SingleOrders);
                        if ($SingleOrdersResult -> num_rows > 0) {
                            while($_row = mysqli_fetch_array($SingleOrdersResult)){
                                $replies = $_row["datetime"];
                                if ($replies == null) {
                                    $replies = [];
                                    $replies = serialize($replies);
                                }else{

                                }
                                $replies = unserialize($replies);
                                $cnt = count($replies);
                                /*for ($row = 0; $row < $cnt; $row++) {
                                          for ($col = 0; $col < 4; $col++) {
                                            echo "<div>".$replies[$row][$col]."</div>";
                                          }
                                          
                                        }*/
                                    foreach ($replies as $key => $value) {
                                        
                                    ?>
                                    <div class="tickets">
                                        <div class="ticket-content" style="width:100% !important;">
                                            <div class="ticket-header">
                                                <div class="ticket-sender-picture img-shadow"><img src="assets/img/avatar/avatar.jpg" alt="image"></div>
                                                <div class="ticket-detail">
                                                    <div class="ticket-title">
                                                        <h6><?php echo ucwords($value['name']);?></h6>
                                                    </div>
                                                    <div class="ticket-info">
                                                        <div class="font-weight-100">
                                                            <?php echo $value['role'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ticket-description">
                                                <?php echo html_entity_decode($value['message']);?>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <?php
                                }
                            }
                        }
                    ?>
                
                </div>
                <style type="text/css">
                    .tickets .ticket-content .ticket-header .ticket-sender-picture{
                        width: 40px !important;
                        height: 40px !important;
                        margin-right: 10px !important;
                    }
                    .tickets .ticket-description{
                        margin-top: 15px !important;
                    }
                </style>

                <form action="" method="post">
                    <textarea class="summernote-simple form-control" name="mssge" required>
                        
                    </textarea>
                    <button class="btn btn-primary" name="submit-mssge">Submit</button>
                </form>

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
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="assets/modules/summernote/summernote-bs4.js"></script>

<!-- Page Specific JS File -->
<script>
    $(".btn-view-details").fireModal({
        title: '',
        body: $("#details")
    });  
    function toggleNotification(x) {
        x.classList.toggle("fa-check");
    }

    // Set the date we're counting down to
    var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();

    // Update the count down every 1 second
    var countdownfunction = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();
        
        // Find the distance between now an the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        document.getElementById("dem").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(countdownfunction);
            document.getElementById("dem").innerHTML = "EXPIRED";
        }
    }, 1000);

    $("#test-slide").owlCarousel({
      items: 4,
      dots: false,
      stagePadding: 0,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      margin: 13,
      autoplay: true,
      autoplayTimeout: 4000,
      loop: false,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1200: {
          items: 4
        }
      }
    });
    $("#coming-soon").owlCarousel({
      items: 1,
      dots: false,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      loop: false,
      
    });
    $("#top-slide").owlCarousel({
      items: 2,
      margin: 10,
      dots: false,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      loop: false,
      responsive: {
        0: {
          items: 1,
          stagePadding: 10,
          margin: 5,
          loop: true
        },
        768: {
          items: 2
        }
      }
    });
    $("#top-rating-slide").owlCarousel({
      items: 2,
      dots: false,
      stagePadding: 0,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      margin: 13,
      autoplay: true,
      autoplayTimeout: 4000,
      loop: false,
      responsive: {
        0: {
          items: 1
        },
        480: {
          items: 2
        },
        1200: {
          items: 2
        }
      }
    });
    
    
</script>
<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
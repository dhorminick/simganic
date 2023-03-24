<?php
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    session_start();

    $message = [];
    $CartResponse = [];

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }
    
    //$page_product_id = "#PD-B02C91F81812485";
    //echo crc32("#PD-B02C91F81812485");

    include '_layout/_currency_converter.php';
    include '_layout/_user_details.php';
    include '_layout/_arrays.php';

    $_new_currency_symbol = $user_selected_currency_symbol;

    $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$page_product_id'";
    $ProductDetailsResult = $con->query($GetProductDetails);

    if ($ProductDetailsResult->num_rows > 0) {
        // output data of each row
        $row = $ProductDetailsResult->fetch_assoc();
        $_product_name = $row["product_name"];
        $_productid = $row["product_id"];
        $_product_category = $row["product_category"];
        $_product_img = $row["product_img"];
        $_product_prices = $row["product_prices"];
        $_products_available = $row["products_available"];
    } else {
        header("Location: 404");
        //404 error
    }

    $bottlePrices = unserialize($_product_prices);
    $available = unserialize($_products_available);
    $sum_of_product_available = intval($available['250ml']) + intval($available['500ml']);
        
    $price250ml = floatval($bottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
    $price500ml = floatval($bottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
    $savings = (((intval($price250ml) * 2) - intval($price500ml)) / (intval($price250ml) * 2) * 100);

    $CartCheckDb = "SELECT * FROM _allcarts WHERE _product_id = '$page_product_id' AND _no_products > 0 AND _emailaddress = '$_user_email_address'";
    $CartCheckDbResult = $con->query($CartCheckDb);
    if ($CartCheckDbResult -> num_rows > 0) {
        $cartBtn = "Update Product(s) In Cart";
        $cartBtnId = "update-cart";
        $Count250mlInCart = "SELECT * FROM _allcarts WHERE _product_id = '$page_product_id' AND _emailaddress = '$_user_email_address' AND _size = '250ml'";
        $Count500mlInCart = "SELECT * FROM _allcarts WHERE _product_id = '$page_product_id' AND _emailaddress = '$_user_email_address' AND _size = '500ml'";
        $Count250mlInCartResult = $con->query($Count250mlInCart);
        $Count500mlInCartResult = $con->query($Count500mlInCart);
        if ($Count250mlInCartResult -> num_rows > 0) {
            $row = mysqli_fetch_array($Count250mlInCartResult);
            $count250ml = $row['_no_products'];
        }else{
            $count250ml = 0;
        } 
        if ($Count500mlInCartResult -> num_rows > 0) {
            $row = mysqli_fetch_array($Count500mlInCartResult);
            $count500ml = $row['_no_products'];
        }else{
            $count500ml = 0;
        }

        $CartDb = "SELECT sum(_no_products) AS cartTotal FROM _allcarts WHERE _product_id = '$page_product_id' AND _emailaddress = '$_user_email_address'";
        $CartDbResult = $con->query($CartDb);
        if ($CartDbResult -> num_rows > 0) {

            $row = mysqli_fetch_array($CartDbResult);
            $totalProducts = $row["cartTotal"];
        }
    }else{
        $totalProducts = 0;
        $count250ml = 0;
        $count500ml = 0;
        $cartBtn = "Add Product(s) To Cart";
        $cartBtnId = "add-to-cart";
    }

        

    $IsInWishlist = "SELECT * FROM _allwishlist WHERE _product_id = '$page_product_id' AND _emailaddress = '$_user_email_address'";
    $WishlistResult = $con->query($IsInWishlist);
    if ($WishlistResult -> num_rows <= 0) {
        $wishlistBtn = '<button class="btn-primary btn-wlist-single" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
    }else{
        $wishlistBtn = '<button class="btn-primary btn-wlist-single" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
    }

    //Settings If User Is Logged In
    if (isset($_SESSION['loggedin'])) {
        //user shipping address and button
        if ($_shippingaddress != null || $_shippingaddress != "" || $_state != null || $_state != "" || $_city != null || $_city != "") {
            $shipBtn = '<a href="update-shipping-address"><button class="btn-primary btn-cart-single">Update Address</button></a>';
            $country = "Nigeria";
            $shipaddress = $_shippingaddress.", ".$cities[$_city].", ".$_state.", ".$country;
        }else{
            $shipaddress = "No Shipping Address Added.";
            $shipBtn = '<a href="update-shipping-address"><button class="btn-primary btn-cart-single">Add Shipping Address</button></a>';
        }
    }else{
        $shipBtn = '<a href="update-shipping-address"><button class="btn-primary btn-cart-single">Add Shipping Address</button></a>';
        $shipaddress = "No Shipping Address Added.";
    }

    $GetReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id'";
    $GetReviewsResult = $con->query($GetReviews);
    $ReviewsCount= mysqli_num_rows($GetReviewsResult);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo $_product_name; ?> &mdash; SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="assets/modules/prism/prism.css">
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/components.min.css">
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
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item"><a href="/products/category/<?php echo strtolower($_product_category); ?>/"><?php echo $_product_category; ?></a></div>
                        <div class="breadcrumb-item"><?php echo $_product_name; ?></div>
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
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-4 col-product">
                            <img class="w-100 item-img" src="assets/img/products/<?php echo $_product_img; ?>" alt="Product Image">
                        </div>
                        <div class="col-12 col-md-12 col-lg-5 col-product">
                            <div class="article-title">
                                <h3><a><?php echo $_product_name; ?></a></h3>
                            </div>
                            <div class="article-category"><a href="/products/category/<?php echo strtolower($_product_category); ?>/"><?php echo $_product_category; ?></a> <div class="bullet"></div> <?php echo $ReviewsCount; ?> Review(s) <div class="bullet"></div> <?php echo $sum_of_product_available - 1; ?> Product(s) Left</div><br>
                            <p>
                                Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                            </p>
                            <p>
                                <h5><?php echo $_new_currency_symbol." ".$price250ml." ";?>(250ml)</h5>
                                <h5><?php echo $_new_currency_symbol." ".$price500ml." ";?>(500ml)</h5>
                            </p>
                            <hr>
                            <strong>INSTANT SHIPPING AFTER CONFIRMATION OF PAYMENT</strong>
                        </div>
                        <div class="col-12 col-md-12 col-lg-3 col-product col-quantity">
                            <h6>Quantity:</h6>
                            <div class="form-type-number div-quantity">
                                <button class="btn-primary btn-icon modal-cart" type="button" id="btn--minus"><i class="fa fa-minus"></i></button>
                                <span class="num num_count"><input type="number" name="qty" class="num-quantity" value="<?php echo $totalProducts; ?>" max="" min="0" readonly></span>
                                <button class="btn-primary btn-icon modal-cart" type="button" id="btn--plus"><i class="fa fa-plus"></i></button>
                            </div>
                            <p><hr></p>

                            <button class="btn-primary btn-cart-single modal-cart"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                            <span class="n_wishlist_btn"><?php echo $wishlistBtn;?></span>
                            <p><hr></p>

                            <div>
                                <h6>Shipping Address:</h6><hr>
                                <div><?php echo $shipaddress?></div><br>
                                <?php echo $shipBtn;?>
                            </div>
                        </div>
                    </div>
                </div>
                <p><hr></p>
                <!--More Products -->
                <div class="row more-products">
                    <div class="col-lg-12" style="margin:10px 0px;">
                        <h5><i class="fa fa-hashtag"></i>  More <?php echo ucwords($_product_category); ?> Products</h5>
                    </div>
                    <div class="owl-carousel owl-theme slider" id="test-slide">
                    <?php

                        $GetNewProducts = "SELECT * FROM product_details WHERE product_category = '$_product_category' ORDER BY _timestamp LIMIT 8";
                        $NewProductDetails = $con->query($GetNewProducts);

                        while ($NewProductRow = mysqli_fetch_assoc($NewProductDetails)) {  
                        if ($NewProductDetails->num_rows > 0) {
                            // output data of each row
                            $pname = $NewProductRow["product_name"];
                            $pid = $NewProductRow["product_id"];
                            $pcategory = $NewProductRow["product_category"];
                            $pimg = $NewProductRow["product_img"];
                            $pprices = $NewProductRow["product_prices"];
                            $plink = $NewProductRow["product_link"];
                            $pavailable = $NewProductRow["products_available"];
                            $p_prices = unserialize($pprices);
                            /*<?php echo; ?>*/
                        } else {
                            //error in product id
                            header("Location: 404");
                            exit();
                        }
                    ?>
                        <div>
                            <div class="p">
                                <div class="p-image">
                                    <img alt="image" src="assets/img/products/<?php echo $pimg; ?>" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="p-name"><a href="products/<?php echo $plink; ?>/"><?php echo ucwords($pname); ?></a></div>
                                    <div class="p-prices"><?php echo $_new_currency_symbol." ".$p_prices["250ml"]." - ".$_new_currency_symbol." ".$p_prices["500ml"]; ?></div>
                                    <div class="view-p">
                                        <a href="products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $revArray = [];
                                //array_push($revArray, "Error 401! Review Upload Error.");
                                if (isset($_POST["submit-review"])) {
                                    $review = strip_tags($_POST["review"]);
                                    $starrating = strip_tags($_POST["stars"]);
                                    $user = strip_tags($_POST["user"]);
                                    $review_ID = uniqid(); //to singulify (lol) products without their id

                                    $reviewid = strtoupper("#RV-".bin2hex(random_bytes(5)).mt_rand(00000,99999));
                                    //$newReviewId = strtoupper("#RV-".bin2hex(random_bytes(5)).mt_rand(00000,99999)); //for new like and dislike
                                    $uploaddate = date("d/m/Y");
                                        
                                    if ($review !== "" || $review !== null) {
                                            if ($starrating === "width-100percent" || $starrating === "width-80percent" || $starrating === "width-60percent" || $starrating === "width-40percent" || $starrating === "width-20percent") {
                                                # code...
                                                $ReviewsArray = array();
                                                $data = serialize($ReviewsArray);

                                                $InsertReviews = "INSERT INTO _reviews (product_id, _reviewcode, username, _stars, _comment, _reaction, _date) VALUES ('$page_product_id', '$reviewid', '$user', '$starrating', '$review', '$data', '$uploaddate')";
                                                $InsertedReviewsResult = $con->query($InsertReviews);

                                                if ($InsertedReviewsResult) {
                                                    array_push($revArray, "Review Uploaded Succesfully.");
                                                }else{
                                                    array_push($revArray, "Error 401! Review Upload Error.");
                                                    //echo "Error: " . $con->error;
                                                }
                                            }else{
                                                array_push($revArray, "Error 402! Review Details Error. **Missing Star Rating.");
                                            }
                                    }else{
                                            array_push($revArray, "Error 402! Review Details Error. **Missing Review Message.");
                                    }
                                }
                                    
                                $GetAllReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' LIMIT 5";
                                $GetAllReviewsResult = $con->query($GetAllReviews);
                                $AllReviewsCount = mysqli_num_rows($GetAllReviewsResult);
                                include '_layout/_star_summary.php';
                            ?>
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="ship-details-tab" data-toggle="tab" href="#ship-details" role="tab" aria-controls="Shipping Details" aria-selected="true">Shipping Details</a></li>
                                <li class="nav-item"><a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="Customers Review" aria-selected="false">Customers Review (<?php echo $AllReviewsCount;?>)</a></li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="ship-details" role="tabpanel" aria-labelledby="ship-details-tab">
                                    <div id="accordion">
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                                <h4><i class="fa fa-plus"></i> How long will it take to receive my order?</h4>
                                            </div>
                                            <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2">
                                                <h4><i class="fa fa-plus"></i> How is the shipping cost calculated?</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-3">
                                                <h4><i class="fa fa-plus"></i> Why didn't my order qualify for FREE shipping?</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-4">
                                                <h4><i class="fa fa-plus"></i> Shipping Restrictions?</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-4" data-parent="#accordion">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-5">
                                                <h4><i class="fa fa-plus"></i> Undeliverable Packages?</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-5" data-parent="#accordion">
                                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                    <?php if (count($revArray) > 0) : ?>
                                        <div class="alert-div">
                                            <?php foreach ($revArray as $error) : ?>
                                            <div class="alert alert-primary alert-dismissible show fade">
                                                <div class="alert-body">
                                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                                    <?php echo $error ?>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                        </div><br>
                                    <?php endif ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <h1><?php echo number_format($AverageRating, 2);?> <span class="small-h1">out of 5</span></h1>
                                            <div class="rating"><p class="star-rating"><span class="width-<?php echo $AveragePercentage;?>percent"></span></p></div>
                                            <div class="stars-ratings">
                                                <div class="mb-4 mt-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $FiveStar;?></div>
                                                    <div class="font-weight-bold mb-1">5 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $OneStarPercentage;?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>                          
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $FourStar;?></div>
                                                    <div class="font-weight-bold mb-1">4 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $TwoStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $ThreeStar;?></div>
                                                    <div class="font-weight-bold mb-1">3 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $ThreeStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $TwoStar;?></div>
                                                    <div class="font-weight-bold mb-1">2 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $FourStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $OneStar;?></div>
                                                    <div class="font-weight-bold mb-1">1 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $FiveStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-reviews col-12 col-lg-7">
                                            <h6>SUBMIT YOUR REVIEWS</h6>
                                            Your Rating: <p class="stars">
                                                <span>
                                                    <a href="#" class="btn-rating" data-value="width-20percent" onclick="getStars(this)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="#" class="btn-rating" data-value="width-40percent" onclick="getStars(this)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="#" class="btn-rating" data-value="width-60percent" onclick="getStars(this)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="#" class="btn-rating" data-value="width-80percent" onclick="getStars(this)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    <a href="#" class="btn-rating" data-value="width-100percent" onclick="getStars(this)"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                </span>
                                            </p><br>
                                            <form method="post" action="">
                                                <div class="form-group" style="margin-bottom: 15px;margin-top: 10px;">
                                                    <input type="text" name="user" class="form-control" <?php if (isset($_SESSION['loggedin'])) { echo 'value="'.$_firstname.' '.$_lastname.'"';}else{} ?> placeholder="Your Name.." readonly>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control txt-area" name="review" placeholder="Review Message..." required=""></textarea>
                                                </div>
                                                <input type="hidden" name="stars" id="starsInput" data-note="edit='no'" value="" required> 
                                                <button class="btn-primary btn-review" name="submit-review"><strong>SUBMIT REVIEW</strong></button>
                                            </form>
                                        </div>  
                                    </div>
                                    <hr>
                                    <?php

                                                $reactionResponse = [];

                                                $userMail = $_user_email_address;

                                                if (isset($_POST["upvote"])) {
                                                    $_rvc =  strip_tags($_POST["-rvc"]);
                                                    if ($_rvc || $_rvc !== "" || $_rvc !== null) {
                                                        # code...
                                                        $GetArray = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                        $ArrayResult = $con->query($GetArray);
                                                        if ($ArrayResult->num_rows > 0) {
                                                            $row = mysqli_fetch_assoc($ArrayResult);
                                                            $reactionSingle = $row["_reaction"];
                                                            $reactionDataSingle = unserialize($reactionSingle);

                                                            $reactionDataSingle[$userMail] = "Yes";
                                                            $newData4 = serialize($reactionDataSingle);

                                                            $UpdateReview4 = "UPDATE _reviews SET _reaction = '$newData4' WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                            $UpdateReviewResult4 = $con->query($UpdateReview4);
                                                            if ($UpdateReviewResult4) {
                                                                //array_push($reactionResponse, "Review Liked.");
                                                            }else{
                                                                array_push($reactionResponse, "Error 401! Records Not Updated.");
                                                                //echo "Error: " . $con->error;
                                                            }
                                                        }else{
                                                            array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                        }
                                                    }else{
                                                        array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                    }
                                                }elseif (isset($_POST["downvote"])) {
                                                    $_rvc =  strip_tags($_POST["-rvc"]);
                                                    if ($_rvc || $_rvc !== "" || $_rvc !== null) {
                                                        # code...
                                                        $GetArray = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                        $ArrayResult = $con->query($GetArray);
                                                        if ($ArrayResult->num_rows > 0) {
                                                            $row = mysqli_fetch_assoc($ArrayResult);
                                                            $reactionSingle = $row["_reaction"];
                                                            $reactionDataSingle = unserialize($reactionSingle);

                                                            $reactionDataSingle[$userMail] = "No";
                                                            $newData4 = serialize($reactionDataSingle);

                                                            $UpdateReview4 = "UPDATE _reviews SET _reaction = '$newData4' WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                            $UpdateReviewResult4 = $con->query($UpdateReview4);
                                                            if ($UpdateReviewResult4) {
                                                                //array_push($reactionResponse, "Review Liked.");
                                                            }else{
                                                                array_push($reactionResponse, "Error 401! Records Not Updated.");
                                                                //echo "Error: " . $con->error;
                                                            }
                                                        }else{
                                                            array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                        }
                                                    }else{
                                                        array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                    }
                                                }

                                                $GetReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' LIMIT 5";
                                                $GetReviewsResult = $con->query($GetReviews);
                                                $rowcount = mysqli_num_rows($GetReviewsResult);
                                                while ($row = mysqli_fetch_assoc($GetReviewsResult)) {
                                                if ($GetReviewsResult->num_rows > 0) {
                                                    
                                                    $review = $row["_comment"];
                                                    $stars = $row["_stars"];
                                                    $date = $row["_date"];
                                                    $uploader = $row["username"];
                                                    $reviewid = $row["_reviewcode"];
                                                    //$reaction = $row["_reaction"];

                                                    $ConfirmPurchaser = "SELECT * FROM _allorders WHERE ordered_id = '$page_product_id' AND orderer = '$_user_email_address' AND _checkedout = true";
                                                    $ConfirmPurchaserResult = $con->query($ConfirmPurchaser);
                                                    $ConfirmPurchaserRowCount = mysqli_num_rows($ConfirmPurchaserResult);
                                                    if ($ConfirmPurchaserRowCount <= 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:red;font-family:14px;"><i class="fa fa-times-circle"></i> <em><a style="color:red;" href="faqs#unverified-purchaser">unverified purchaser</a></em></span>';
                                                    }elseif ($ConfirmPurchaserRowCount > 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:green;font-family:14px;"><i class="fa fa-check-circle"></i> <em><a style="color:green;" href="faqs#verified-purchaser">verified purchaser</a></em></span>';
                                                    }
                                                    //array_push($reactionResponse, "Review Liked.");
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-10">
                                            <div class="rating"><p class="star-rating"><span class="<?php echo $stars;?>"></span></p></div>
                                            <div>by <strong><?php echo $uploader; ?></strong></div>
                                            <div><?php echo $review; ?></div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-2">
                                            <div><?php echo $date; ?></div>
                                            <div><?php echo $isVerifiedPurchaser; ?></div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-0">
                                            <h6>Was this review helpful?</h6>
                                            <?php if (count($reactionResponse) > 0) : ?>
                                                <div class="alert-div">
                                                    <?php foreach ($reactionResponse as $response) : ?>
                                                    <div class="alert alert-primary alert-dismissible show fade">
                                                        <div class="alert-body">
                                                            <button class="close" data-dismiss="alert"><span>×</span></button>
                                                            <?php echo $response ?>
                                                        </div>
                                                    </div>
                                                    <?php endforeach ?>
                                                </div>
                                            <?php endif ?>
                                            <?php
                                                        
                                                $IfHaveReviewied = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _reviewcode = '$reviewid'";
                                                $IfHaveReviewiedResult = $con->query($IfHaveReviewied);
                                                if ($IfHaveReviewiedResult -> num_rows > 0) {
                                                    $row = mysqli_fetch_array($IfHaveReviewiedResult);
                                                    $data = unserialize($row["_reaction"]);
                                                    //var_dump($data);
                                                    $YesCount = count(array_keys($data, 'Yes'));
                                                    $NoCount = count(array_keys($data, 'No'));
                                                    if (array_key_exists($userMail,$data)){
                                                        $isNew = false;
                                                        $val = $data[$userMail];
                                                        //echo $val;
                                                        if ($val === "No") {
                                                            echo '
                                                            <form id="reactForm" method="post" action="">
                                                                <span class="btn_react"><i class="fa fa-thumbs-down" aria-hidden="true" style="margin-right:3px !important;"></i> No ('.$NoCount.')</span>
                                                                <button class="btn_vote" name="upvote" title data-toggle="tooltip" data-placement="left" data-original-title="Like Review"><i class="fa fa-thumbs-up"></i> Yes ('.$YesCount.')</button>
                                                                <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            </form>';
                                                        }else if ($val === "Yes") {
                                                            echo '
                                                            <form id="reactForm" method="post" action="">
                                                                <span class="btn_react"><i class="fa fa-thumbs-up" aria-hidden="true" style="margin-right:3px !important;"></i> Yes ('.$YesCount.')</span>
                                                                <button class="btn_vote" name="downvote" title data-toggle="tooltip" data-placement="left" data-original-title="Dislike Review"><i class="fa fa-thumbs-down"></i> No ('.$NoCount.')</button>
                                                                <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            </form>';
                                                        }
                                                    }else{
                                                        $isNew = true;
                                                        echo '
                                                        <form id="reactForm" method="post" action="">
                                                            <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            <button type="submit" name="upvote" class="btn_vote"><i class="fa fa-thumbs-up"  style="margin-right:3px !important;" aria-hidden="true"></i> Yes ('.$YesCount.')</button>
                                                            <button type="submit" name="downvote" class="btn_vote"><i class="fa fa-thumbs-down"  style="margin-right:3px !important;" aria-hidden="true"></i> No ('.$NoCount.')</button>
                                                        </form>';
                                                    }
                                                }else{
                                                    $noReview = true;            
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php }else{ /* No review */}} ?>
                                    <?php
                                        if ($GetReviewsResult->num_rows <= 0){
                                            echo '<div><center><h6>No Review On This Product Yet.</h6></center></div>';
                                        }else{ 
                                    ?>
                                        <div>Showing <strong>1 - <?php if ($rowcount < 5){echo $rowcount;}else{echo "5";}?></strong> of <strong><?php echo $rowcount;?></strong> Review(s) <div class="bullet"></div> <a href="reviews?product=<?php echo crc32($page_product_id); ?>&reviews=all">See All Review(s) <i class="fa-xs fa fa-angle-right"></i></a></div>
                                    <?php } ?>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div id="update-cart-form">
                    <?php if (count($CartResponse) > 0) : ?>
                        <div class="alert-div">
                            <?php foreach ($CartResponse as $error) : ?>
                            <div class="alert alert-primary alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <?php echo $error ?>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <form class="update-cart-details" method="post" action="update-cart">
                        <div class="row">
                            <div class="col-12 col-lg-7 col-md-6">
                                <h6>250ml <div class="bullet"></div> <?php echo $_new_currency_symbol." ".$price250ml." ";?></h6>
                            </div>
                            <div class="col-12 col-lg-5 col-md-6">
                                <?php if ($available['250ml'] > 0) {?>
                                <div class="form-type-number div-quantity" style="text-align:center;">
                                    <button class="btn-primary btn-icon btn-minus btn-form-cart num-small" id="btn--minus" <?php //if($count250ml <= 0){echo 'disabled=""';}else{echo '';} ?>><i class="fa fa-minus"></i></button>
                                    <span class="num"><input type="number" name="qty" class="num-quantity" value="<?php echo $count250ml;?>" max="<?php echo $available['250ml'] - 1;?>" min="0" readonly></span>
                                    <button class="btn-primary btn-icon btn-plus btn-form-cart" id="btn--plus"><i class="fa fa-plus"></i></button>
                                </div>
                                <div style="margin-top:5px;text-align:center;">
                                    <?php echo "<strong>".($available['250ml'] - 1)."</strong> Products Left" ?>
                                </div>
                                <input type="hidden" name="sku-size" value="250ml">
                                <input type="hidden" name="sku-value" value="<?php echo crc32($page_product_id);?>">
                                <?php }else{echo "<center><strong>Out Of Stock!</strong></center>";} ?>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form class="update-cart-details" method="post" action="update-cart">
                        <div class="row">
                            <div class="col-12 col-lg-7 col-md-6">
                                <h6>500ml <div class="bullet"></div> <?php echo $_new_currency_symbol." ".$price500ml." ";?> <div class="bullet"></div> <span class="small-h1"><strong>Save <?php echo number_format($savings); ?>%</strong></span></h6>
                            </div>
                            <div class="col-12 col-lg-5 col-md-6">
                                <?php if ($available['500ml'] > 0) {?>
                                <div class="form-type-number div-quantity" style="text-align:center;">
                                    <button class="btn-primary btn-icon btn-minus btn-form-cart num-big" id="btn--minus" <?php //if($count500ml <= 0){echo 'disabled=""';}else{echo '';} ?>><i class="fa fa-minus"></i></button>
                                    <span class="num"><input type="number" name="qty" class="num-quantity" value="<?php echo $count500ml;?>" max="<?php echo $available['500ml'] - 1;?>" min="0" readonly></span>
                                    <button class="btn-primary btn-icon btn-plus btn-form-cart" id="btn--plus"><i class="fa fa-plus"></i></button>
                                </div>
                                <div style="margin-top:5px;text-align:center;">
                                    <?php echo "<strong>".($available['500ml'] - 1)."</strong> Products Left" ?>
                                </div>
                                <input type="hidden" name="sku-size" value="500ml">
                                <input type="hidden" name="sku-value" value="<?php echo crc32($page_product_id);?>">
                                <?php }else{echo "<center><strong>Out Of Stock!</strong></center>";} ?>
                            </div>
                        </div>
                    </form>
                </div>
                <form class="update-wishlist" method="post" action="update-wishlist">
                    <input type="hidden" value="<?php echo crc32($page_product_id);?>" name="sku-value">
                </form>
            </section>
            <p id="response"></p>
            <span id="toastr-9"></span><span id="toastr-10"></span><span id="toastr-11"></span><span id="toastr-12"></span><span id="toastr-13"></span><span id="toastr-14"></span><span id="toastr-15"></span><span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span><span id="toastr-19"></span>
        </div>

        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/bootstrap-modal.js"></script>
<script src="js/page/modules-toastr.js"></script>
<script type="text/javascript">

    $(".modal-cart").fireModal({
      title: 'Please Select Bottle Size',
      footerClass: 'bg-whitesmoke',
      body: $("#update-cart-form"),
      buttons: [
        {
          text: '<?php echo $cartBtn;?>',
          class: 'btn btn-primary btn-shadow btn-add-to-cart',
          id: '<?php echo $cartBtnId;?>',
          handler: function(modal) {
          }
        }
      ]
    });

    $('.update-cart-details').on('submit', function (event){
        event.preventDefault();

        var formValues = $(this).serialize();

        //$("#update-cart-form button").prop('disabled', true);
        //$(".btn-form-cart").prop('disabled', true);

        $.post("_layout/_ajax.php", {updatecart: formValues}).done(function (data) {
        //Display the returned data in browser
        //var x = document.getElementById("response");
        //x.className = "show";
        //setTimeout(function(){ 
            //x.className = x.className.replace("show", "");
            //$("#update-cart-form button").prop('disabled', false);
            //$(".btn-form-cart").prop('disabled', false);
            //$(".num").load(" .num > *");
            //$(".item-count").load(" .item-count > *");
        //}, 1000);
        setTimeout(function(){ $("#response").load(" #response > *") }, 5000);
        $(".num_count").load(" .num_count > *"); 
        //$(".num-small").load(" .num-small > *");
        //$(".num-big").load(" .num-big > *");                                          
        $("#response").html(data);
        });                            

    });
    $('.update-wishlist').on('submit', function (event){
        event.preventDefault();

        var formValues = $(this).serialize();

        $.post("_layout/_ajax.php", {updatewishlist: formValues}).done(function (data) {
        
        setTimeout(function(){ $("#response").load(" #response > *") }, 5000);
        //$(".n_wishlist_btn").load(" .n_wishlist_btn > *"); 
                                                  
        $("#response").html(data);
        });                            

    });
    $('.btn-wlist-single').on('click', function (e) {
        $('.update-wishlist').submit();
    });
    
    $('.btn-minus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepDown']();
    });

    $('.btn-plus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepUp']();
    });

    
    function getStars (starrating) {
        var starNumber = starrating.getAttribute("data-value");
        document.getElementById('starsInput').setAttribute('value', starNumber);
    }

    $('.btn-rating').on('click', function (e) {
        e.preventDefault();
        //alert("Test Click");
        let btn = $(this);
        if( !btn.hasClass('selected')){
            btn.siblings().removeClass('selected');
            btn.addClass('selected');
            btn.parents('span').addClass('rated');
        }
    })
    $("#test-slide").owlCarousel({
      items: 4,
      dots: false,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      margin: 13,
      autoplay: true,
      autoplayTimeout: 4000,
      loop: false,
      /*responsive: {
        0: {
          items: 2
        },
        768: {
          items: 2
        },
        1200: {
          items: 3
        }
      }*/
    });
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
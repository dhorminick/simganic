<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    

    $errors = [];

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Simply Organic Foods - SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/components.min.css">
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
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="3"></li>
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="4"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="assets/img/banner/1.jpg" alt="First slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Heading</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="assets/img/banner/2.jpg" alt="Second slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Heading</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="assets/img/banner/3.jpg" alt="Third slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Heading</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="assets/img/banner/4.jpg" alt="Fourth slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Heading</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="assets/img/banner/5.jpg" alt="Fifth slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Heading</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        img.w-100{
                                            height: auto;
                                        }
                                        .div-advert{
                                            background-color: #fafbfe;
                                            padding: 15px 0px;
                                        }
                                        .div-advert .col-lg-3 div{
                                            border: 1px solid #563d7c;
                                            border-radius: 5px;
                                            font-size: 17px;
                                            text-align: center;
                                            padding: 10px;
                                            margin: 10px 0;
                                            background: white;
                                        }
                                        
                                        .div-advert .fa{
                                            font-size: 45px;
                                            margin-bottom: 10px;
                                        }
                                    </style>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p id="response"></p>
                <span id="toastr-9"></span><span id="toastr-10"></span><span id="toastr-11"></span><span id="toastr-12"></span><span id="toastr-13"></span><span id="toastr-14"></span><span id="toastr-15"></span><span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span><span id="toastr-19"></span><span id="toastr-23"></span>
                <div class="div-sort-by row" style="margin-top:40px;margin-bottom:20px;">
                    <div class="col-lg-6 col-md-6" style="text-align:left !important;">
                        <span class="show-sm"><h6><i class="fa fa-hashtag"></i> You May Like</h6></span><span class="show-bg"><h5><i class="fa fa-hashtag"></i> Products You May Like</h5></span>
                    </div>
                    <div class="col-lg-6 col-md-6 sort-main-div">
                        <h6>Sort By 
                        <div class="dropdown d-inline mr-2" style="margin-left:10px;">
                            <button class="btn btn-primary dropdown-toggle btn-sort-by" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Default Sorting
                            </button>
                            <div class="dropdown-menu drop-menu-edit">
                                <a class="dropdown-item" href="sort?sort=price&pref=lowest-to-highest"><strong>Price:</strong> Lowest To Highest</a>
                                <a class="dropdown-item" href="sort?sort=price&pref=highest-to-lowest"><strong>Price:</strong> Highest To Lowest</a>
                                <a class="dropdown-item" href="sort?sort=ratings-popularity"><strong>Ratings Popularity</strong></a>
                                <a class="dropdown-item" href="sort?sort=most-purchase"><strong>Most Purchased</strong></a>
                                <a class="dropdown-item" href="sort?sort=freshly-added"><strong>Freshly Added</strong></a>
                            </div>
                        </div></h6>
                    </div>
                </div>
                <style>
                    .dropdown-menu.drop-menu-edit{
                        transform: translate3d(-62px, 28px, 0px) !important;
                        z-index: 1000;
                    }
                    @media screen and (max-width: 1000px) {
                        .sort-main-div{
                            padding-right: 0px;
                            margin-top: -36px !important;
                        }

                    }
                    .sort-main-div{
                        text-align:right;
                    }

                </style>

                <div class="row">
                    <?php
                        $GetAllProducts = "SELECT * FROM product_details";
                        $AllProductDetails = $con->query($GetAllProducts);

                        while ($AllProductRow = mysqli_fetch_assoc($AllProductDetails)) {  

                        if ($AllProductDetails->num_rows > 0) {
                            // output data of each row
                            $pname = $AllProductRow["product_name"];
                            $pid = $AllProductRow["product_id"];
                            $pcategory = $AllProductRow["product_category"];
                            $pimg = $AllProductRow["product_img"];
                            $plink = $AllProductRow["product_link"];
                            $pprices = $AllProductRow["product_prices"];
                            $pavailable = $AllProductRow["products_available"];
                            $num_available = unserialize($pavailable);
                        } else {
                            echo "Page Error!";
                            exit();
                        }

                        if ($num_available["500ml"] <= 0) {
                            $hasProducts500ml = "false";
                        }else{
                            $hasProducts500ml = "true";
                        }
                        if ($num_available["250ml"] <= 0) {
                            $hasProducts250ml = "false";
                        }else{
                            $hasProducts250ml = "true";
                        }
                        $encodedPID = crc32($pid);
                        $IsInWishlist = "SELECT * FROM _allwishlist WHERE _product_id = '$pid' AND _emailaddress = '$_user_email_address'";
                        $WishlistResult = $con->query($IsInWishlist);
                        if ($WishlistResult -> num_rows <= 0) {
                            $wishlistBtn = '<button data-sku="'.$encodedPID.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }else{
                            $wishlistBtn = '<button data-sku="'.$encodedPID.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
                        }

                        $CartCheckDb = "SELECT * FROM _allcarts WHERE _product_id = '$pid' AND _no_products > 0 AND _emailaddress = '$_user_email_address'";
                        $CartCheckDbResult = $con->query($CartCheckDb);
                        if ($CartCheckDbResult -> num_rows > 0) {
                            $Count250mlInCart = "SELECT * FROM _allcarts WHERE _product_id = '$pid' AND _emailaddress = '$_user_email_address' AND _size = '250ml'";
                            $Count500mlInCart = "SELECT * FROM _allcarts WHERE _product_id = '$pid' AND _emailaddress = '$_user_email_address' AND _size = '500ml'";
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
                        }else{
                            $count250ml = 0;
                            $count500ml = 0;
                        }

                        if (!isset($_SESSION['loggedin'])) {
                            $wishlistBtn = '<button class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }

                        $AllbottlePrices = unserialize($pprices);
                        
                        $price250ml = floatval($AllbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $price500ml = floatval($AllbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $savings = (((intval($price250ml) * 2) - intval($price500ml)) / (intval($price250ml) * 2) * 100);
                    ?>
                    <div class="col-6 col-lg-3 col-md-6 prod-div">
                        <article class="article article-style-c">
                            <a href="/products/<?php echo $plink; ?>/"><div class="article-header">
                                <div class="article-image" data-background="assets/img/products/<?php echo $pimg; ?>"></div>
                            </div></a>
                            <div class="article-details">
                                <center>
                                <div class="article-category"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                <div class="article-title">
                                    <h2><a href="/products/<?php echo $plink; ?>/"><?php echo $pname; ?></a></h2>
                                </div>
                                <div><strong><?php echo "$currency_symbol".$price250ml ." - ". "$currency_symbol".$price500ml; ?></strong></div>
                                <div class="article-user">
                                    <?php if (isset($_SESSION['loggedin'])) { ?>
                                    <!--<button data-sku="<?php echo crc32($pid); ?>" data-product-name="<?php echo $pname; ?>" data-available-small="<?php echo $hasProducts250ml;?>" data-available-big="<?php echo $hasProducts500ml;?>" data-price-small="<?php echo $price250ml; ?>" data-curr="<?php echo $currency_symbol; ?>" data-price-big="<?php echo $price500ml; ?>" data-save-percent="<?php echo number_format($savings); ?>" data-count-small="<?php echo $count250ml;?>" data-count-big="<?php echo $count500ml;?>" class="btn btn-primary btn-cart-fpage btn-to-cart">Add To Cart</button>-->
                                    <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    <?php }else{ ?>
                                    <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    <?php } ?>
                                    <?php echo $wishlistBtn; ?>
                                </div>
                                </center>
                            </div>
                        </article>
                    </div>
                    <?php }?>
                </div>
                <div class="row div-advert">
                    <div class="col-6 col-lg-3 col-md-3">
                        <div style="color:green !important;">
                            <i class="fa fa-circle-check"></i><br><h5>Fresh <span class="show-bg">Products</span></h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-3">
                        <div style="color:#FFCC00 !important;">
                            <i class="fa fa-shipping-fast"></i><br><h5>Fast <span class="show-bg">Service</span></h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-3">
                        <div style="color:blue !important;">
                            <i class="fa fa-handshake"></i><br><h5>Reliable <span class="show-bg">Partners</span></h5>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-3">
                        <div style="color:red !important;">
                            <i class="fa fa-heartbeat"></i><br><h5>Healthy <span class="show-bg">Living</span></h5>
                        </div>
                    </div>
                </div>
                <br>
                <h5><i class="fa fa-hashtag"></i> Fresly Added Products</h5>
                <div class="owl-carousel owl-theme slider" id="fresh">
                    <?php
                        $GetNewProducts = "SELECT * FROM product_details ORDER BY _timestamp LIMIT 7";
                        $NewProductDetails = $con->query($GetNewProducts);

                        while ($NewProductRow = mysqli_fetch_assoc($NewProductDetails)) {  
                        if ($NewProductDetails->num_rows > 0) {
                            // output data of each row
                            $newpname = $NewProductRow["product_name"];
                            $newpid = $NewProductRow["product_id"];
                            $newpcategory = $NewProductRow["product_category"];
                            $newpimg = $NewProductRow["product_img"];
                            $newpprices = $NewProductRow["product_prices"];
                            $newplink = $NewProductRow["product_link"];
                            $newpavailable = $NewProductRow["products_available"];
                        } else {
                            echo "Page Error!";
                            exit();
                        }
                        $encodedPId = crc32($newpid);
                        $IsInWishlistNewProducts = "SELECT * FROM _allwishlist WHERE _product_id = '$newpid' AND _emailaddress = '$_user_email_address'";
                        $WishlistResultNewProducts = $con->query($IsInWishlistNewProducts);
                        if ($WishlistResultNewProducts -> num_rows <= 0) {
                            $wishlistBtnNp = '<button data-sku="'.$encodedPId.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }else{
                            $wishlistBtnNp = '<button data-sku="'.$encodedPId.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
                        }
                        if (!isset($_SESSION['loggedin'])) {
                            $wishlistBtnNp = '<button class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }

                        $NewbottlePrices = unserialize($newpprices);
                        $NewCount = unserialize($newpavailable);
                        $TotalNewCount = intval($NewCount['250ml']) + intval($NewCount['500ml']);
                        $newprice250ml = floatval($NewbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $newprice500ml = floatval($NewbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $savings = (((intval($newprice250ml) * 2) - intval($newprice500ml)) / (intval($newprice250ml) * 2) * 100);
                    ?>
                    <div>
                        <div class="p-">
                            <a href="/products/<?php echo $newplink; ?>/"><div class="p-image">
                                <img alt="image" src="assets/img/products/<?php echo $newpimg; ?>" class="img-fluid">
                            </div></a>
                            <div class="p-details">
                            <center>
                                <div class="p-category text-small"><a href="/products/category/<?php echo strtolower($newpcategory); ?>/"><?php echo $newpcategory; ?></a></div>
                                <div class="p-name"><a href="/products/<?php echo $newplink; ?>/"><?php echo $newpname; ?></a></div>
                                <div class="p-prices"><?php echo "$currency_symbol".$newprice250ml ." - ". "$currency_symbol".$newprice500ml; ?></div>
                                <div class="view-p">
                                    <a href="/products/<?php echo $newplink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    <?php echo $wishlistBtnNp;?>
                                </div>
                            </center>
                            </div>  
                        </div>
                    </div>
                    <?php }?>
                </div>
                <br>
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
                    <div class="col-lg-8 div-top-rated-test">
                        <div class="h-50 h-top">
                        <div class="col-lg-12 top-rated-header">
                            <h4><i class="fa fa-hashtag"></i> Top Rated Products</h4>
                        </div>
                        <div class="owl-carousel owl-theme slider" id="top-slide" style="border:1px solid transparent;">
                        <?php
                            $RateProducts = "SELECT * FROM product_details WHERE product_rating != 0 ORDER BY product_rating DESC LIMIT 5";
                            $RateResult = $con->query($RateProducts);
                            $rateCount= mysqli_num_rows($RateResult);
                            if ($rateCount <= 1) {
                                $width = "style='width:100% !important;'";
                                $style = null;
                                $close_style = null;
                                $carouselCount = 1;
                            }else{
                                $width = "style='width:90% !important;'";
                                $style = "<center>";
                                $close_style = "</center>";
                                $carouselCount = 2;
                            }
                            if ($RateResult->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($RateResult)) {
                                $r_product_name = $row["product_name"];
                                $r_product_category = $row["product_category"];
                                $r_product_img = $row["product_img"];
                                $r_product_link = $row["product_link"];
                                $r_product_rating = $row["product_rating"];
                                $r_product_no_reviews = $row["product_no_reviews"];
                                
                                if ($r_product_rating <= 0) {
                                    $_averagePercentage = 0;
                                }else{
                                    $_averagePercentage = ($r_product_rating / 5) * 100;
                                }
                        ?>  

                            <div>
                                <div class="p --p">
                                    <div class="p-image">
                                        <img alt="image" src="assets/img/products/<?php echo $r_product_img ; ?>" width="120" height="120">
                                    </div>
                                    <div class="p-details" <?php echo $width; ?>>
                                    <?php echo $style; ?>
                                        <div class="p-category text-small"><a href="/products/category/<?php echo strtolower($r_product_category); ?>/">Dairy</a></div>
                                        <div class="p-name"><a href="/products/<?php echo $r_product_link; ?>/"><?php echo $r_product_name; ?></a></div>
                                        <div class="top-rating-ratings"><span class="star-rating"><span class="width-<?php echo $_averagePercentage;?>percent"></span></span></div>
                                        <div><?php echo $r_product_no_reviews; ?> Review(s)</div>
                                    <?php echo $close_style; ?>
                                    </div>  
                                </div>
                            </div>
                        <?php }} ?>
                        </div>
                        </div>
                        <div class="h-50 h-col-ban">
                        <div class="col-banner">
                            <h3>100% Natural Premium Quality Products.</h3>
                        </div>
                        </div>
                    </div>
                </div>

                
            </section>
        </div>
        <style>
            .select2-search__field{
                display: none !important; 
            }
        </style>
        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>
<?php if (isset($_SESSION['loggedin'])) { /*style="display:none !important;"*/?>
<div id="to-cart" style="display:none !important;">
    <form class="update-cart">
        <div class="row">
            <div class="col-12 col-lg-7 col-md-6">
                <h6>250ml <div class="bullet"></div> <span class="curr"></span><span class="price-small"></span></h6>
            </div>
            <div class="col-12 col-lg-5 col-md-6 col-big-qty" id="c-b-q">
                <div class="form-type-number div-quantity">
                    <button class="btn-primary btn-icon btn-minus" id="btn--minus"><i class="fa fa-minus"></i></button>
                    <span class="num"><input type="number" name="qty" class="num-quantity num-small" value="0" max="" min="0" readonly="" autofocus="false"></span>
                    <button class="btn-primary btn-icon btn-plus" id="btn--plus"><i class="fa fa-plus"></i></button>
                </div>
                <input type="hidden" class="data-size" name="sku-size" value="250ml" readonly="">
                <input type="hidden" class="data-sku-val" name="sku-value" value="" readonly="">
            </div>
        </div>
    </form>
    <hr>
    <form class="update-cart">
        <div class="row">
            <div class="col-12 col-lg-7 col-md-6">
                <h6>500ml <div class="bullet"></div> <span class="curr"></span><span class="price-big"></span> <div class="bullet"></div> <span class="small-h1"><strong>Save <span class="savings"></span>%</strong></span></h6>
            </div>
            <div class="col-12 col-lg-5 col-md-6 col-small-qty" id="c-s-q">
                <div class="form-type-number div-quantity">
                    <button class="btn-primary btn-icon btn-minus" id="btn--minus"><i class="fa fa-minus"></i></button>
                    <span class="num"><input type="number" name="qty" class="num-quantity num-big" value="0" max="" min="0" style="border:none !important;pointer-events: none !important;" readonly="" autofocus="false"></span>
                    <button class="btn-primary btn-icon btn-plus" id="btn--plus"><i class="fa fa-plus"></i></button>
                </div>
                <input type="hidden" class="data-size" name="sku-size" value="500ml" readonly="">
                <input type="hidden" class="data-sku-val" name="sku-value" value="" readonly="">
            </div>
        </div>
    </form>
</div>
<form class="update-wishlist">
    <input type="text" class="wishlist-sku" name="sku-value" value="">
    <button class="wishlist-btn">submit</button>
</form>
<?php }else{ ?>
<div id="wishlist-form">
    <center>
        <h6 style="margin-bottom:10px !important;">Sign In To Add Product To Wishlist.</h6>
        <a href="sign-in?redirect=all-products" class="btn btn-primary btn-cart-single"><i class="fa fa-arrow-left"></i> SIGN IN</a>
    </center>
</div>
<?php }?>
<div id="details">
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

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>

<!-- Page Specific JS File -->

<script src="js/page/bootstrap-modal.js"></script>
<script src="js/page/modules-toastr.js"></script>

<script type="text/javascript">
    <?php if (isset($_SESSION['loggedin'])) { ?>

    $(".btn-to-cart").fireModal({
      title: 'Please Select Bottle Size',
      footerClass: 'bg-whitesmoke',
      body: $("#to-cart"),
      buttons: [
        {
          text: 'Add Item(s) To Cart',
          class: 'btn btn-primary btn-shadow btn-add-to-cart',
          id: 'update-cart',
          handler: function(modal) {
          }
        }]
    });

    $('.btn-minus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepDown']();
    });

    $('.btn-plus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepUp']();
    });


    $('.update-cart').on('submit', function (event){
        
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
        //$(".num_count").load(" .num_count > *"); 
        //$(".num_count_form").load(" .num_count_form > *");                                          
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

    $(".btn-to-cart").click(function(){
        //$("#c-b-q").load(" #c-b-q > *");
        //$("#c-s-q").load(" #c-s-q > *");

        var data_sku = $(this).attr("data-sku");
        var data_price_small = $(this).attr("data-price-small");
        var data_price_big = $(this).attr("data-price-big");
        var data_savings = $(this).attr("data-save-percent");
        var data_currency = $(this).attr("data-curr");
        var data_count_small = $(this).attr("data-count-small");
        var data_count_big = $(this).attr("data-count-big");
        var data_available_small = $(this).attr("data-available-small");
        var data_available_big = $(this).attr("data-available-big");
        

        if (!data_sku || data_sku == "" || data_sku == null || !data_price_small || data_price_small == "" || data_price_small == null || !data_price_big || data_price_big == "" || data_price_big == null || !data_savings || data_savings == "" || data_savings == null || !data_count_small || data_count_small == "" || data_count_small == null || !data_count_big || data_count_big == "" || data_count_big == null || !data_available_big || data_available_big == "" || data_available_big == null || !data_available_small || data_available_small == "" || data_available_small == null) {
            alert("Error 402! Product Details Error.");
            window.location.reload();
        }else{
            $(".price-big").text(data_price_big);
            $(".price-small").text(data_price_small);
            $(".savings").text(data_savings);
            $(".curr").text(data_currency);
            $(".data-sku-val").val(data_sku);
            $(".num-small").val(data_count_small);
            $(".num-big").val(data_count_big);
            if (data_available_big === "false") {
                $(".col-big-qty").html("<center><strong>Out Of Stock!</strong></center>");
            };
            if (data_available_small ==- "false") {
                $(".col-small-qty").html("<center><strong>Out Of Stock!</strong></center>");
            };
        };
    });

    $(".btn-to-wishlist").click(function(){
        var sku = $(this).attr("data-sku");
        if (!sku || sku == "" || sku == null){

        }else{
            $(".wishlist-sku").val(sku);
            $(".wishlist-btn").click();
        }
    });

    <?php }else{ ?>

    $(".btn-to-wishlist").fireModal({
      title: '',
      footerClass: 'bg-whitesmoke',
      body: $("#wishlist-form"),
    });

    <?php } ?>

    $(".btn-view-details").fireModal({
        title: '',
        body: $("#details")
    }); 

    function toggleNotification(x) {
        x.classList.toggle("fa-check");
    }

    $("#fresh").owlCarousel({
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
        480: {
          items: 2
        },
        1200: {
          items: 4
        }
      }
    });

    $("#top-slide").owlCarousel({
      items: 2,
      margin: 10,
      stagePadding: 5,
      dots: false,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      loop: false,
      responsive: {
        0: {
          items: 1,
          stagePadding: 10,
          margin: 5,
          loop: false
        },
        768: {
          items: <?php echo $carouselCount; ?>
        }
      }
    });
</script>


<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
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

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Wishlist &mdash; SimGanic</title>

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
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item">My WishList</div>
                    </div>
                </div>

                <div class="section-body">
                <?php

                    if (isset($_POST["delete"])) {
                        $id = strip_tags($_POST["product-sku"]);
                        
                        if ($id || $id !== "" || $id !== null) {

                            $CheckId = "SELECT * FROM product_details WHERE crc32(md5(sha1(md5(product_id)))) = '$id'";
                            $IdResult = $con->query($CheckId);
                            if ($IdResult->num_rows > 0) {

                                $SearchWishlistRecords = "SELECT * FROM _allwishlist WHERE _emailaddress = '$_user_email_address' AND crc32(md5(sha1(md5(_product_id)))) = '$id'";
                                $SearchWishlistResult = mysqli_query($con,$SearchWishlistRecords);
                                if ($SearchWishlistResult ->num_rows <= 0) {
                                    array_push($message, "Error 402! Product Error.");
                                }else{
                                    $DeleteData = "DELETE FROM _allwishlist WHERE _emailaddress = '$_user_email_address' AND crc32(md5(sha1(md5(_product_id)))) = '$id'";
                                    $DeleteDataResult = mysqli_query($con,$DeleteData);
                                    if ($DeleteDataResult) {
                                        array_push($message, "Product Deleted From Wishlist Succesfully.");
                                    }else{
                                        array_push($message, "ERROR 401! Product Error.");
                                    }

                                }
                            }else{
                                array_push($message, "Error 402! Product Error.");
                                //array_push($message, $con->error);
                                //echo "Error: " . $con->error;
                            }
                        }
                        
                    }

                    $GetWishlistDetails = "SELECT * FROM _allwishlist WHERE _emailaddress = '$_user_email_address'";
                    $GetWishlistDetailsResult = $con->query($GetWishlistDetails);
                    $WishlistCount = mysqli_num_rows($GetWishlistDetailsResult);
                        if ($WishlistCount > 0) {
                            $HasProductsInWishlist = true;
                            
                ?>
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
                <h5 class="w-100">
                    (<?php echo $WishlistCount;?>) Wishlist Item<?php if ($WishlistCount > 1) {echo "s";}else{}?>
                </h5>
                    <div class="row">
                        <div class="col-lg-9">
                        <?php
                            $HasProductsInWishlist = true;
                            
                            $GetWishlistDetails = "SELECT * FROM _allwishlist WHERE _emailaddress = '$_user_email_address' ORDER BY _timestamp ASC";
                            $GetWishlistDetailsResult = $con->query($GetWishlistDetails);

                            while ($cartRow = mysqli_fetch_assoc($GetWishlistDetailsResult)) {
                                if ($GetWishlistDetailsResult->num_rows > 0) {
                                    //$_no_products_ordered = $cartRow["_no_products"];
                                    $productId = $cartRow["_product_id"];
                                    
                                    //Get Product Details With Id
                                    $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$productId'";
                                    $GetProductDetailsResult = mysqli_query($con,$GetProductDetails);
                                    if ($GetProductDetailsResult->num_rows > 0) {
                                        $HasProductsInWishlist = true;
                                        $rows = mysqli_fetch_array($GetProductDetailsResult);
                                        $cart_product_name = $rows["product_name"];
                                        $cart_product_id = $rows["product_id"];
                                        $cart_product_link = $rows["product_link"];
                                        $cart_product_category = $rows["product_category"];
                                        $cart_product_img = $rows["product_img"];
                                        $cart_product_prices = $rows["product_prices"];
                                        $cart_products_available = $rows["products_available"];
                                    } else {
                                        header("Location: Error");
                                    }
                                    //no available
                                    $prices = unserialize($cart_product_prices);
                                    $available = unserialize($cart_products_available);
                                    
                                    $noAvailable = $available["250ml"] + $available["500ml"] - 1;

                                    if ($noAvailable > 10) {
                                        $cart_product_available_style = 'color:green';
                                    }else{
                                        $cart_product_available_style = 'color:red';
                                    }
                        ?>
                        <div class="div-cart">
                            <div class="first-div">
                                <div class="img-divv">
                                     <img src="assets/img/products/<?php echo $cart_product_img; ?>" class="product-img" width='100' height='100'>
                                </div>
                                <div class="mid-first-div">
                                    <span>
                                        <h6><a href="/products/<?php echo $cart_product_link; ?>"><?php echo $cart_product_name; ?></a></h6>
                                        <h6 class="small-h6"><span class="light">Category:</span> <a href="/products/category/<?php echo strtolower($cart_product_category); ?>/"><?php echo $cart_product_category; ?></a></h6>
                                        <h6 class="small-h6 show-bg"><span class="light">Sizes:</span> 250ml, 500ml</h6>
                                    </span>
                                    <span class="float-div">
                                        <h6><?php echo $user_selected_currency_symbol." ".number_format($prices["250ml"] * $user_selected_currency_conversion_to_naira_rate)." - ".$user_selected_currency_symbol." ".number_format($prices["500ml"] * $user_selected_currency_conversion_to_naira_rate);?></h6>
                                        <h6 class="small-h6 show-bg" style="<?php echo $cart_product_available_style;?>">(<?php echo intval($noAvailable) - 1;?>) <span class="light">Items Left</span></h6>
                                    </span>
                                </div>
                            </div>
                            <div class="second-div">
                                <div>
                                    <button class="btn-primary btn-delete btn-delete-from-cart" data-name="<?php echo $cart_product_name; ?>" data-product-sku="<?php echo crc32(md5(sha1(md5($cart_product_id))));?>"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                                <div class="right-divv">
                                    <a href="/products/<?php echo $cart_product_link; ?>/"><button class="btn-primary btn btn-to-cart">VIEW PRODUCT</button></a>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                        </div>
                        <div class="col-lg-3 w_sidebar show-bg">
                            <div class="w__sidebar">
                                <div class="w_summary">Wish-List Summary</div>
                                <div class="w_subtotal-line">
                                    <h6><span class="w_stt-name">SubTotal :</span>
                                    <span class="w_stt-price">0.00</span></h6>
                                </div>
                                <div class="w_subtotal-line">
                                    <h6><span class="w_stt-name">Shipping Fee :</span>
                                    <span class="w_stt-price">0.00</span></h6>
                                </div>
                                <div class="w_subtotal-line last">
                                    <h6><span class="w_stt-name">Discount :</span>
                                    <span class="w_stt-price">0.00</span></h6>
                                </div>
                                <hr>
                                <div>
                                    <a href="/all-products"><button class="btn w_btn-checkout btn-primary btn-check-disabled"><i class="fa fa-arrow-left"></i> Continue Shopping</button></a>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 check-div show-sm">
                            <a href="/all-products"><button class="btn-check-out btn-primary"><i class="fa fa-arrow-left"></i> Continue Shopping</button></a>
                        </div>
                    </div>
                <?php }else{?>
                    <div class="col-12 w_main">
                        <center>
                        <div class="w_icon">
                            <i class="fa fa-heart-circle-check"></i>
                        </div> <br>
                        <h5>You have not added any item to wishlist yet!</h5>
                        <p>Browse our products and select your preferred item(s).</p>
                        <a href="all-products" class="csp"><button class="btn btn-primary"><i class="fa fa-arrow-left"></i> Continue Shopping</button></a>
                        </center> 
                    </div>
                <?php } ?>
                </div>
                <button class="btn-delete-from-cart" hidden disabled=""></button>
            </section>
        </div>
        <div id="delete-cart-form" style="text-align:center;">
            <form method="post" action="">
                <input type="hidden" value="" name="product-sku" class="product-sku">
                <h6>Are you sure you want to delete "<span class="product-name"></span>" from wishlist?</h6>
                <br><button class="btn btn-primary btn-icon" name="delete"><i class="fa fa-trash"></i> DELETE PRODUCT</button>
            </form>
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
<script src="js/page/bootstrap-modal.js"></script>
<script>
    $(".btn-delete-from-cart").fireModal({
        title: '',
        footerClass: 'bg-whitesmoke',
        body: $("#delete-cart-form")
      
    });
    $('.btn-minus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepDown']();
    })

    $('.btn-plus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepUp']();
    })
    
    $('.btn-delete-from-cart').on('click', function () {
        var data_sku = $(this).attr("data-product-sku");
        var data_name = $(this).attr("data-name");
        
        if (!data_sku || data_sku == "" || data_sku == null || !data_name || data_name =="" || data_name == null){
            alert("Error 402! Product Error.");
            window.location.reload();
        }else{
            $('.product-sku').val(data_sku);
            $('.product-name').text(data_name);
        }
    });
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
</html>
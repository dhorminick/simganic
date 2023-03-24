<?php
    //dbconn
    include $_SERVER['DOCUMENT_ROOT'].'/_layout/_dbconnection.php';
    //if ($dbconn) {}else{ header("Location: 404");}
    
    $message = [];
    $CartResponse = [];

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
        //echo $_SESSION["email"];
    }

    include $_SERVER['DOCUMENT_ROOT'].'/_layout/_currency_converter.php';
    include $_SERVER['DOCUMENT_ROOT'].'/_layout/_user_details.php';
    include $_SERVER['DOCUMENT_ROOT'].'/_layout/_arrays.php';

    $_new_currency_symbol = $user_selected_currency_symbol;

    $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$page_product_id'";
    $ProductDetailsResult = $con->query($GetProductDetails);

    if ($ProductDetailsResult->num_rows > 0) {
        // output data of each row
        $row = $ProductDetailsResult->fetch_assoc();
        $_product_name = $row["product_name"];
        $_product_link = $row["product_link"];
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
        $wishlistBtn = '<button class="btn-primary btn-wlist-single" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
        if (isset($_POST["update-cart"])) {
            $newRecord = 1;
            $pID = strip_tags($_POST["sku-value"]);
            $size = strip_tags($_POST['sku-size']);

            if ($size === "250ml" || $size === "500ml") {
                
                if ($newRecord <= "0") {
                    # code...
                    array_push($message, "Error 402! Product Error.");
                    //echo '<script>$("#toastr-11").click();</script>';
                    exit();
                }

                
                    $Get_ProductsDetails = "SELECT * FROM product_details WHERE crc32(product_id) = '$pID'";
                    $Products_DetailsResult = $con->query($Get_ProductsDetails);
                    if ($Products_DetailsResult->num_rows > 0) {
                        // output data of each row
                        $row = $Products_DetailsResult->fetch_assoc();
                        $p__available = $row["products_available"];
                        $p__id = $row["product_id"];
                        $p__name = $row["product_name"];
                        $p__link = $row["product_link"];
                        $p__img = $row["product_img"];
                        $p__category = $row["product_category"];
                        $p__price = $row["product_prices"];

                        $p__available = unserialize($p__available);
                        $p__prices = unserialize($p__price);
                        if ($size === "250ml" && $newRecord >= $available["250ml"] - 1 || $size === "500ml" && $newRecord >= $available["500ml"] - 1) {
                            /*echo '
                                <span id="max-values"></span>
                                <script>
                                    $("#max-values").click(function() {
                                        iziToast.error({
                                        title: "Error 402!",
                                        message: "Maximum Products Available Exceeded.",
                                        position: "topRight"
                                        });
                                    });
                                    $("#max-values").click();
                                </script>
                            ';*/
                            array_push($message, "Error 402! Maximum Products Available Exceeded.");
                        }else{  
                            if ($size === "250ml") {
                                $pPrice = $p__prices["250ml"];
                                $arrId = $p__id.'.250ml';
                                $pAvailable = $p__available["250ml"];
                            }elseif ($size === "500ml") {
                                $pPrice = $p__prices["500ml"];
                                $arrId = $p__id.'.500ml';
                                $pAvailable = $p__available["500ml"];
                            }
                                 
                            $Not_Logged_In_Cart_Array = array(
                                $arrId=>array(
                                'name'=>$p__name,
                                'p__id'=>$p__id,
                                'size'=>$size,
                                'p__link'=>$p__link,
                                'price'=>$pPrice,
                                'available'=>$pAvailable,
                                'category'=>$p__category,
                                'quantity'=>1,
                                'image'=>$p__img)
                            ); 

                            if(empty($_SESSION["shopping_cart"])) {
                                $_SESSION["shopping_cart"] = $Not_Logged_In_Cart_Array;
                                    /*echo '
                                        <span id="added-to-cart"></span>
                                        <script>
                                            $("#added-to-cart").click(function() {
                                              iziToast.success({
                                                title: "Product Added To Cart Succesfully.",
                                                message: "",
                                                position: "topRight"
                                              });
                                            });
                                            $("#added-to-cart").click();
                                        </script>
                                    ';*/
                                    array_push($message, "Product Added To Cart Succesfully.");  
                            }else{
                                $array_keys = array_keys($_SESSION["shopping_cart"]);
                                if(in_array($arrId,$array_keys)) {
                                    /*echo '
                                        <span id="already-in-cart"></span>
                                        <script>
                                            $("#already-in-cart").click(function() {
                                              iziToast.warning({
                                                title: "Product Already In Cart.",
                                                message: "",
                                                position: "topRight"
                                              });
                                            });
                                            $("#already-in-cart").click();
                                        </script>
                                    ';  */
                                    array_push($message, "Product Already In Cart.");
                                } else {
                                    $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$Not_Logged_In_Cart_Array);
                                    /*echo '
                                        <span id="added-to-cart"></span>
                                        <script>
                                            $("#added-to-cart").click(function() {
                                              iziToast.success({
                                                title: "Product Added To Cart Succesfully.",
                                                message: "",
                                                position: "topRight"
                                              });
                                            });
                                            $("#added-to-cart").click();
                                        </script>
                                    ';  */
                                    array_push($message, "Product Added To Cart Succesfully.");
                                }
                            }                    
                        }
                    } else {
                        //User Probably Changed The Values. Echo Product Error
                        /*echo '
                            <span id="error-values"></span>
                            <script>
                                $("#error-values").click(function() {
                                    iziToast.error({
                                    title: "Error 402!",
                                    message: "Product Details Error.",
                                    position: "topRight"
                                    });
                                });
                                $("#error-values").click();
                            </script>
                        ';*/
                        array_push($message, "Error 402! Product Details Error.");
                        exit();
                    }
                
            }else{
                //User Probably Changed The Values. Echo Product Error
                echo '<script>$("#toastr-11").click();</script>';
                exit();
            }
        }
    }

    $revArray = [];
    $reactionResponse = [];

    if (isset($_POST["delete-review"])) {
        $rev =  strip_tags(htmlspecialchars($_POST["rev"]));
        $CheckReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$rev' LIMIT 1";
        $CheckReviewsResult = $con->query($CheckReviews);
        if ($CheckReviewsResult->num_rows > 0) {
            $DeleteReview = "DELETE FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$rev'";
            $DeleteReviewsResult = $con->query($DeleteReview);
            if ($DeleteReviewsResult) {
                array_push($reactionResponse, "Review Deleted Succesfully.");
                $GetRevs = "SELECT * FROM _reviews WHERE product_id = '$page_product_id'";
                $GetRevsResult = $con->query($GetRevs);
                $RevsCount = mysqli_num_rows($GetRevsResult);

                include $_SERVER['DOCUMENT_ROOT'].'/_layout/_update_review_count.php';
                //update product rating and review count in product details db
                $UpdateProdCount = "UPDATE product_details SET product_rating = '$AverageRating', product_no_reviews = '$RevsCount' WHERE product_id = '$page_product_id'";
                $UpdateProdCountResult = $con->query($UpdateProdCount);
            }else{
                array_push($reactionResponse, "Error 401! Unsuccesful.");
            }
        }else{
            array_push($reactionResponse, "Error 402! Review Error.");
        }
    }

    if (isset($_SESSION['loggedin'])) {
        if (isset($_POST["submit-review"])) {
            $review = strip_tags($_POST["review"]);
            $starrating = strip_tags($_POST["stars"]);
            $user = strip_tags(strtolower($_POST["user"]));
            $uploader_email = $_user_email_address;
            $review_ID = uniqid(); //to singulify (ha ha) products without their id

            $reviewid = strtoupper("#RV-".bin2hex(random_bytes(5)).mt_rand(00000,99999));
                                        //$newReviewId = strtoupper("#RV-".bin2hex(random_bytes(5)).mt_rand(00000,99999)); //for new like and dislike
            $uploaddate = date("d/m/Y");
                                            
            if ($review !== "" || $review !== null) {
                    if ($starrating === "width-100percent" || $starrating === "width-80percent" || $starrating === "width-60percent" || $starrating === "width-40percent" || $starrating === "width-20percent") {
                        # code...
                        $ReviewsArray = array();
                        $data = serialize($ReviewsArray);

                        $InsertReviews = "INSERT INTO _reviews (product_id, _reviewcode, username, email, _stars, _comment, _reaction, _date) VALUES ('$page_product_id', '$reviewid', '$user', '$uploader_email', '$starrating', '$review', '$data', '$uploaddate')";
                        $InsertedReviewsResult = $con->query($InsertReviews);

                        if ($InsertedReviewsResult) {
                            array_push($reactionResponse, "Review Uploaded Succesfully.");

                            $GetRevs = "SELECT * FROM _reviews WHERE product_id = '$page_product_id'";
                            $GetRevsResult = $con->query($GetRevs);
                            $RevsCount = mysqli_num_rows($GetRevsResult);

                            include $_SERVER['DOCUMENT_ROOT'].'/_layout/_update_review_count.php';
                            //update product rating and review count in product details db
                            $UpdateProdCount = "UPDATE product_details SET product_rating = '$AverageRating', product_no_reviews = '$RevsCount' WHERE product_id = '$page_product_id'";
                            $UpdateProdCountResult = $con->query($UpdateProdCount);
                            //echo "Error: " . $con->error;
                        }else{
                            array_push($reactionResponse, "Error 401! Review Upload Error.");
                            //array_push($revArray, $con->error);
                            //echo "Error: " . $con->error;
                        }
                    }else{
                        array_push($reactionResponse, "Error 402! Review Details Error. **Missing Star Rating.");
                    }
            }else{
                array_push($reactionResponse, "Error 402! Review Details Error. **Missing Review Message.");
            }
        }
    }else{
        if (isset($_POST["submit-review"])) {
            array_push($revArray, "Sign In To Upload Your Review.");
        }
    }

    $userMail = $_user_email_address;
    if (isset($_SESSION['loggedin'])) {
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
    }else{
        if (isset($_POST["upvote"])) {
            array_push($reactionResponse, "Sign In To React To Reviews.");
        }elseif (isset($_POST["downvote"])) {
            array_push($reactionResponse, "Sign In To React To Reviews.");
        }
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
    <title><?php echo $_product_name; ?> - SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="/assets/css/mystyle.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="/assets/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="/assets/modules/prism/prism.css">
    <link rel="stylesheet" href="/assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <link rel="stylesheet" href="/assets/css/components.min.css">
</head>

<body class="layout-1">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        
        <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_header_sidebar.php';?>

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item"><a href="/products/category/<?php echo strtolower($_product_category); ?>/"><?php echo $_product_category; ?></a></div>
                        <div class="breadcrumb-item"><?php echo $_product_name; ?></div>
                    </div>
                </div><span id="toastr-23"></span>

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
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-4 col-product">
                            <img class="w-100 item-img" src="/assets/img/products/<?php echo $_product_img; ?>" alt="Product Image">
                        </div>
                        <div class="col-12 col-md-12 col-lg-5 col-product">
                            <div class="article-title">
                                <h3><a><?php echo $_product_name; ?></a></h3>
                            </div>
                            <div class="article-category"><a href="/products/category/<?php echo strtolower($_product_category); ?>/"><?php echo $_product_category; ?></a> <div class="bullet"></div> <a href="#review"><?php echo $ReviewsCount; ?> Review(s)</a> <div class="bullet"></div> <?php echo $sum_of_product_available - 1; ?> Product(s) Left</div><br>
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
                            <?php if (isset($_SESSION['loggedin'])) { ?>
                            <h6>Quantity:</h6>
                            <div class="form-type-number div-quantity">
                                <button class="btn-primary btn-icon modal-cart" type="button" id="btn--minus"><i class="fa fa-minus"></i></button>
                                <span class="num num_count"><input type="number" name="qty" class="num-quantity" value="<?php echo $totalProducts; ?>" max="" min="0" readonly></span>
                                <button class="btn-primary btn-icon modal-cart" type="button" id="btn--plus"><i class="fa fa-plus"></i></button>
                            </div>
                            <p><hr></p>

                            <button class="btn-primary btn-cart-single modal-cart"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                            <?php }else{ ?>
                            <h6 style="margin-bottom:10px !important;">
                            <?php 
                            $qty = 0;
                            if(!empty($_SESSION["shopping_cart"])) {
                                foreach($_SESSION["shopping_cart"] as &$value){
                                    if($value['p__id'] === $page_product_id){
                                        $qty += $value['quantity'];
                                    }else{
                                        $qty = 0;
                                    }
                                }
                            }else{
                                $qty = 0;
                            }
                            if ($qty > 1) {
                                $plural = "s";
                            }else{
                                $plural = null;
                            }
                            ?>
                            (<?php echo $qty; ?>) Product<?php echo $plural;?> In Cart:</h6>
                            <button class="btn-primary btn-cart-single add-cart"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                            <?php }?>
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
                    <div class="owl-carousel owl-theme slider" id="more-slide">
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
                                    <img alt="image" src="/assets/img/products/<?php echo $pimg; ?>" class="img-fluid">
                                </div>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="p-name"><a href="/products/<?php echo $plink; ?>/"><?php echo ucwords($pname); ?></a></div>
                                    <div class="p-prices"><?php echo $_new_currency_symbol." ".$p_prices["250ml"]." - ".$_new_currency_symbol." ".$p_prices["500ml"]; ?></div>
                                    <div class="view-p">
                                        <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div style="margin:-15px !important;">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                //
                                $GetAllReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' LIMIT 5";
                                $GetAllReviewsResult = $con->query($GetAllReviews);
                                $AllReviewsCount = mysqli_num_rows($GetAllReviewsResult);
                                include $_SERVER['DOCUMENT_ROOT'].'/_layout/_star_summary.php';
                                
                            ?>
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item"><a class="nav-link" id="ship-details-tab" data-toggle="tab" href="#ship-details" role="tab" aria-controls="Shipping Details" aria-selected="true">Shipping Details</a></li>
                                <li class="nav-item"><a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="Customers Review" aria-selected="false">Customers Review (<?php echo $AllReviewsCount;?>)</a></li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade" id="ship-details" role="tabpanel" aria-labelledby="ship-details-tab">
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
                                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
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
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $FiveStarPercentage;?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>                          
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $FourStar;?></div>
                                                    <div class="font-weight-bold mb-1">4 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $FourStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $TwoStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="text-small float-right font-weight-bold text-muted"><?php echo $OneStar;?></div>
                                                    <div class="font-weight-bold mb-1">1 Stars</div>
                                                    <div class="progress" data-height="3">
                                                        <div class="progress-bar" role="progressbar" data-width="<?php echo $OneStarPercentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                    <input type="text" name="user" class="form-control"  placeholder="Your Full Name.." <?php if (isset($_SESSION['loggedin'])) { if($_firstname != null && $_lastname != null || $_firstname != "" && $_lastname != ""){ echo 'value="'.ucwords($_firstname).' '.ucwords($_lastname).'"'; echo 'readonly'; }else{ echo 'value="'.$_user_name.'"'; echo 'readonly'; } }else{} ?>>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control txt-area" name="review" placeholder="Review Message (Max 200 words)..." required=""></textarea>
                                                </div>
                                                <input type="hidden" name="stars" id="starsInput" data-note="no-edit" value="" required> 
                                                <button class="btn-primary btn-review" name="submit-review"><strong>SUBMIT REVIEW</strong></button>
                                            </form>
                                        </div>  
                                    </div>
                                    <hr>
                                    <?php

                                                $GetReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' ORDER BY id DESC LIMIT 5";
                                                $GetReviewsResult = $con->query($GetReviews);
                                                $rowcount = mysqli_num_rows($GetReviewsResult); ?>
                                                
                                                <?php while ($row = mysqli_fetch_assoc($GetReviewsResult)) {
                                                if ($GetReviewsResult->num_rows > 0) {
                                                    
                                                    $review = $row["_comment"];
                                                    $stars = $row["_stars"];
                                                    $date = $row["_date"];
                                                    $uploaders = $row["username"];
                                                    $uploader_email_add = $row["email"];
                                                    $reviewid = $row["_reviewcode"];
                                                    //$reaction = $row["_reaction"];

                                                    $ConfirmPurchaser = "SELECT * FROM _allorders WHERE items LIKE \"%$page_product_id%\" AND email = '$uploader_email_add' AND status = 'paid' OR status = 'shipped' OR status = 'delivered'";
                                                    //echo "<script>alert('$uploader_email_add');</script>";
                                                    $ConfirmPurchaserResult = $con->query($ConfirmPurchaser);
                                                    $ConfirmPurchaserRowCount = mysqli_num_rows($ConfirmPurchaserResult);

                                                    //echo "<script>alert('$uploader_email_add');</script>";
                                                    if ($ConfirmPurchaserResult -> num_rows <= 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:red;font-family:12px;"><i class="fa fa-times-circle"></i> <a style="color:red;" href="faqs#unverified-and-verified-purchaser">unverified purchaser</a></span>';
                                                    }elseif ($ConfirmPurchaserResult -> num_rows > 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:green;font-family:12px;"><i class="fa fa-check-circle"></i> <a style="color:green;" href="faqs#unverified-and-verified-purchaser">verified purchaser</a></span>';
                                                    }
                                                    //array_push($reactionResponse, "Review Liked.");
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="rating"><p class="star-rating"><span class="<?php echo $stars;?>"></span></p></div>
                                            <div>by <strong><?php echo ucwords($uploaders); ?></strong></div>
                                        </div>
                                        <div class="col-12 col-lg-12 show-sm" style="margin-top:5px;margin-bottom:5px;">
                                            <div><?php echo $review; ?></div>
                                            <?php if (isset($_SESSION['loggedin'])) { ?>
                                            <div>
                                                <?php

                                                    if (ucwords($uploaders) === ucwords($_firstname).' '.ucwords($_lastname) || ucwords($uploaders) === $_user_name) {
                                                ?>   
                                                <form action="" method="post" class="show-bg" style="margin-top:10px;">
                                                    <input type="hidden" value="<?php echo md5(sha1($reviewid)); ?>" name="rev">
                                                    <button class="btn_vote" style="margin-left: 0px !important;font-size:12px !important;font-weight:normal !important;" name="delete-review"><i class="fa fa-trash"></i> Delete Review</button>
                                                </form>     
                                                <?php }else{}?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="show-sm" style="text-align:right;">
                                                <div><?php echo $date; ?></div>
                                                <div><?php echo $isVerifiedPurchaser; ?></div>
                                            </div>
                                            <div class="show-bg">
                                                <div><?php echo $date; ?></div>
                                                
                                                <div><?php echo $isVerifiedPurchaser; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 show-bg">
                                            <h6>Was this review helpful?</h6>
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
                                                                <span class="btn_react" style="margin-left:17px !important;"><i class="fa fa-thumbs-down" aria-hidden="true" style="margin-right:3px !important;"></i> No ('.$NoCount.')</span>
                                                                <button class="btn_vote" name="upvote" title data-toggle="tooltip" data-placement="left" data-original-title="Like Review"><i class="fa fa-thumbs-up"></i> Yes ('.$YesCount.')</button>
                                                                <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            </form>';
                                                        }else if ($val === "Yes") {
                                                            echo '
                                                            <form id="reactForm" method="post" action="">
                                                                <span class="btn_react" style="margin-left:17px !important;"><i class="fa fa-thumbs-up" aria-hidden="true" style="margin-right:3px !important;"></i> Yes ('.$YesCount.')</span>
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
                                        <div class="col-12 col-lg-12 show-bg" style="margin-top:5px;">
                                            <div><?php echo $review; ?></div>
                                            <?php if (isset($_SESSION['loggedin'])) { ?>
                                            <div>
                                                <?php
                                                    if ($uploaders === $_firstname.' '.$_lastname || $uploaders === $_user_name) {
                                                ?>   
                                                <form action="" method="post" class="show-bg" style="margin-top:10px;">
                                                    <input type="hidden" value="<?php echo md5(sha1($reviewid)); ?>" name="rev">
                                                    <button class="btn_vote" style="margin-left: 0px !important;font-size:12px !important;font-weight:normal !important;" name="delete-review"><i class="fa fa-trash"></i> Delete Review</button>
                                                </form>     
                                                <?php }else{}?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php }else{ /* No review */}} ?>
                                    <?php
                                        if ($GetReviewsResult->num_rows <= 0){
                                            echo '<div><center><h6>No Review On This Product Yet.</h6></center></div>';
                                        }else{ 
                                    ?>
                                        <div>Showing <strong>1 - <?php if ($rowcount < 5){echo $rowcount;}else{echo "5";}?></strong> of <strong><?php echo $rowcount;?></strong> Review(s) <div class="bullet"></div> <a class="btn btn-primary" style="font-size:13px !important;" href="reviews?product=<?php echo crc32($page_product_id); ?>&reviews=all">See All Review(s) <i class="fa-xs fa fa-angle-right"></i></a></div>
                                    <?php } ?>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($_SESSION['loggedin'])) { ?>
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
                <?php }else{ ?>
                <div id="update-cart">
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
                    <form class="update-cart-details" method="post" action="">
                        <div class="row">
                            <div class="col-6 col-lg-7 col-md-6">
                                <h6>250ml <div class="bullet"></div> <?php echo $_new_currency_symbol." ".$price250ml." ";?></h6>
                            </div>
                            <div class="col-6 col-lg-5 col-md-6">
                                <?php if ($available['250ml'] > 0) {?>
                                <input type="hidden" name="sku-size" value="250ml">
                                <input type="hidden" name="sku-value" value="<?php echo crc32($page_product_id);?>">
                                <div class="form-type-number div-quantity" style="text-align:center;">
                                    <button class="btn-primary btn" name="update-cart"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                                </div>
                                <div style="margin-top:5px;text-align:center;">
                                    <?php echo "<strong>".($available['250ml'] - 1)."</strong> Products Left" ?>
                                </div>
                                <?php }else{echo "<center><strong>Out Of Stock!</strong></center>";} ?>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form class="update-cart-details" method="post" action="">
                        <div class="row">
                            <div class="col-6 col-lg-7 col-md-6">
                                <h6>500ml <div class="bullet"></div> <?php echo $_new_currency_symbol." ".$price500ml." ";?> <div class="bullet"></div> <span class="small-h1"><strong>Save <?php echo number_format($savings); ?>%</strong></span></h6>
                            </div>
                            <div class="col-6 col-lg-5 col-md-6">
                                <?php if ($available['500ml'] > 0) {?>
                                <input type="hidden" name="sku-size" value="500ml">
                                <input type="hidden" name="sku-value" value="<?php echo crc32($page_product_id);?>">
                                <div class="form-type-number div-quantity" style="text-align:center;">
                                    <button class="btn-primary btn" name="update-cart"><i class="fa fa-cart-plus"></i> Add To Cart</button>
                                </div>
                                <div style="margin-top:5px;text-align:center;">
                                    <?php echo "<strong>".($available['500ml'] - 1)."</strong> Products Left" ?>
                                </div>
                                <?php }else{echo "<center><strong>Out Of Stock!</strong></center>";} ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="wishlist-form">
                    <center>
                        <h6 style="margin-bottom:10px !important;">Sign In To Add Product To Wishlist.</h6>
                        <a href="sign-in?redirect=/products/<?php echo $_product_link;?>/" class="btn btn-primary btn-cart-single"><i class="fa fa-arrow-left"></i> SIGN IN</a>
                    </center>
                </div>
                <?php } ?>
            </section>
            <p id="response"></p>
            <span id="toastr-9"></span><span id="toastr-10"></span><span id="toastr-11"></span><span id="toastr-12"></span><span id="toastr-13"></span><span id="toastr-14"></span><span id="toastr-15"></span><span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span><span id="toastr-19"></span>
        </div>

        <!-- Start app Footer part -->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_footer.php';?>
    </div>
</div>
<style>
.nav-tabs .nav-item .nav-link.active {
    color: #563d7c !important;
}
</style>

<!-- General JS Scripts -->
<script src="/assets/bundles/lib.vendor.bundle.js"></script>
<script src="/js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="/assets/modules/izitoast/js/iziToast.min.js"></script>
<script src="/assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>

<!-- Page Specific JS File -->
<script src="/js/page/bootstrap-modal.js"></script>
<script src="/js/page/modules-toastr.js"></script>
<script type="text/javascript">
    <?php if (isset($_SESSION['loggedin'])) { ?>
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
    
    $('.btn-minus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepDown']();
    });

    $('.btn-plus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepUp']();
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

    <?php }else{ ?>

    $(".add-cart").fireModal({
      title: 'Please Select Bottle Size',
      footerClass: 'bg-whitesmoke',
      body: $("#update-cart"),
      
    });

    $('.update-cart-detail').on('submit', function (event){
        event.preventDefault();

        var formValues = $(this).serialize();

        //$("#update-cart-form button").prop('disabled', true);
        //$(".btn-form-cart").prop('disabled', true);

        $.post("_layout/_ajax.php", {updatecar: formValues}).done(function (data) {
            alert("posted");
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
        //$(".num-small").load(" .num-small > *");
        //$(".num-big").load(" .num-big > *");                                          
        $("#response").html(data);
        });                            

    });

    $(".btn-wlist-single").fireModal({
      title: '',
      footerClass: 'bg-whitesmoke',
      body: $("#wishlist-form"),
    });
    <?php }?>
    
   
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
    $("#more-slide").owlCarousel({
      items: 4,
      dots: false,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      margin: 13,
      autoplay: true,
      autoplayTimeout: 4000,
      loop: false,
      responsive: {
        0: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
</script>

<!-- Template JS File -->
<script src="/js/scripts.js"></script>
<script src="/js/custom.js"></script>
</body>

</html>
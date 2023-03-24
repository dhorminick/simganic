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

        //as the name implies, delete empty records on load
        //$DeleteEmptyRecords = "DELETE FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products = 0";
        //$DeleteEmptyRecords_Result = $con->query($DeleteEmptyRecords);
    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Shopping Cart - SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">

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
                        <div class="breadcrumb-item">Cart</div>
                    </div>
                </div>

                <div class="section-body">
                <p id="result"></p>
                <?php
                    
                    if (isset($_POST['upc'])){
                        $id = strip_tags(htmlspecialchars($_POST["sku-value"]));
                        $_size = strip_tags(htmlspecialchars($_POST["sku-size"]));
                        $qty = strip_tags(htmlspecialchars($_POST["qty"]));

                        
                        $_GetProductDetails = "SELECT * FROM product_details WHERE crc32(product_id) = '$id'";
                        $_GetProductDetailsResult = mysqli_query($con,$_GetProductDetails);
                        if ($_GetProductDetailsResult->num_rows > 0) {
                            $_rows = mysqli_fetch_array($_GetProductDetailsResult);
                            $unhashed_id = $_rows["product_id"];
                                if ($qty <= 0) {
                                unset($_SESSION["shopping_cart"][$unhashed_id.$_size]);
                            }else{

                            }
                            //$arrName = $unhashed_id.$_size;
                            foreach($_SESSION["shopping_cart"] as &$value){
                                if($value['p__id'] === $unhashed_id && $value['size'] === $_size){
                                    $value['quantity'] = $qty;
                                    array_push($message, "Cart Updated Succesfully.");
                                    break; // Stop the loop after we've found the product
                                    //array_push($message, "Cart Updated Succesfully.");
                                }else{
                                    //array_push($message, "Error 402! Product Error 1.");
                                }
                                        
                            }
                        }else{
                            array_push($message, "Error 402! Product Error.");
                        }
                    }
                    if (isset($_POST['delete'])){
                        $id = strip_tags($_POST["product-sku"]);
                        $size = strip_tags($_POST['product-size']);
                        if ($id || $id !== "" || $id !== null) {
                            if ($size || $size === "250ml" || $size === "500ml") {
                                $GetProductsDetails = "SELECT * FROM product_details WHERE crc32(md5(sha1(md5(product_id)))) = '$id'";
                                $ProductsDetailsResult = $con->query($GetProductsDetails);
                                if ($ProductsDetailsResult->num_rows > 0) {
                                    $row = $ProductsDetailsResult->fetch_assoc();
                                    $id = $row["product_id"];
                                    $newId = $id.'.'.$size;

                                    if(!empty($_SESSION["shopping_cart"])) {
                                        foreach($_SESSION["shopping_cart"] as $key => $value) {
                                            if($newId == $key){
                                                unset($_SESSION["shopping_cart"][$key]);
                                                array_push($message, "Product Deleted From Cart Succesfully.");
                                            }
                                            if(empty($_SESSION["shopping_cart"])){
                                                unset($_SESSION["shopping_cart"]);
                                            }
                                        }       
                                    }
                                }
                            }else{
                                array_push($message, "Error 402! Product Error.");
                            }
                        }else{
                            array_push($message, "Error 402! Product Error.");
                        }
                    }
                    if (isset($_SESSION['loggedin'])) {

                        if (isset($_POST["delete"])) {
                            $id = strip_tags($_POST["product-sku"]);
                            $size = strip_tags($_POST['product-size']);    
                            if ($id || $id !== "" || $id !== null) {
                                if ($size || $size === "250ml" || $size === "500ml") {
                                    $GetProductsDetails = "SELECT * FROM product_details WHERE crc32(md5(sha1(md5(product_id)))) = '$id'";
                                    $ProductsDetailsResult = $con->query($GetProductsDetails);
                                    if ($ProductsDetailsResult->num_rows > 0) {

                                        $SearchCartRecords = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND crc32(md5(sha1(md5(_product_id)))) = '$id' AND _size = '$size'";
                                        $SearchCartResult = mysqli_query($con,$SearchCartRecords);
                                        if ($SearchCartResult ->num_rows <= 0) {
                                            array_push($message, "Error 401! Product Not Found.");
                                        }else{
                                            $DeleteData = "DELETE FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND crc32(md5(sha1(md5(_product_id)))) = '$id' AND _size = '$size'";
                                            $DeleteDataResult = mysqli_query($con,$DeleteData);
                                            if ($DeleteDataResult) {
                                                array_push($message, "Product Deleted From Cart Succesfully.");
                                            }else{
                                                array_push($message, "Error 401! Product Error.");
                                            }
                                        }
                                    }else{
                                        array_push($message, "Error 402! Product Error.");
                                    }
                                }else{
                                    array_push($message, "Error 402! Product Error.");
                                }
                            }else{
                                array_push($message, "Error 402! Product Error.");
                            }
                        }
                        $GetCartsDetails = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0";
                        $GetCartsDetailsResult = $con->query($GetCartsDetails);
                        $CartCount = mysqli_num_rows($GetCartsDetailsResult);
                        //$isLoggedIn = TRUE;
                    }else{
                        if(!empty($_SESSION["shopping_cart"])) {
                            $CartCount = count(array_keys($_SESSION["shopping_cart"]));
                        }else{
                            $CartCount = 0;
                        }
                    }
                        if ($CartCount > 0) {
                            if (isset($_SESSION['loggedin'])) {
                                $HasProductsInCart = true;
                                if ($HasProductsInCart = true) {
                                    $sqli = "SELECT sum(_no_products * (_price * '$user_selected_currency_conversion_to_naira_rate')) AS total FROM _allcarts WHERE _emailaddress = '$_user_email_address'" ;
                                    $sqliResult = $con->query($sqli);
                                    foreach ($con->query($sqli) as $row) {
                                        if ($sqliResult->num_rows > 0) {
                                            $total = $row["total"];
                                            $total_in_user_currency = $total;
                                        }else{
                                            header("Location: Error");
                                        } 
                                    }
                                }else{
                                    //Cart Empty
                                    $total_in_user_currency = 0;
                                }
                            }else{
                               $total_in_user_currency = 0; 
                            }
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
                <h5 class="w-100 show-bg">
                    (<?php echo $CartCount;?>) Cart Item<?php if ($CartCount > 1) {echo "s";}else{}?>
                <br></h5>
                <div class="w-100 sub-div show-sm">
                        <h6><span>
                            SUBTOTAL:
                        </span>
                        <span class="right">
                            <?php
                            if (isset($_SESSION['loggedin'])) {
                                echo $currency_symbol." ".number_format($total_in_user_currency);
                            }else{
                                $h_total_in_user_currency = 0;
                                foreach ($_SESSION["shopping_cart"] as $total){ 
                                    $h_total_in_user_currency += ($total["price"]*$total["quantity"]);
                                }
                                 echo $currency_symbol." ".number_format($h_total_in_user_currency); 
                            }
                            ?>
                        </span></h6>
                        <hr>
                </div>

                <div class="row">
                    <?php if (isset($_SESSION['loggedin'])) { ?>
                    <div class="col-lg-9 div-cart-div">
                        <?php
                            $HasProductsInCart = true;

                            $GetCartDetails = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0 ORDER BY _timestamp ASC";
                            $GetCartDetailsResult = $con->query($GetCartDetails);

                            while ($cartRow = mysqli_fetch_assoc($GetCartDetailsResult)) {
                                if ($GetCartDetailsResult->num_rows > 0) {
                                    $_no_products_ordered = $cartRow["_no_products"];
                                    $productId = $cartRow["_product_id"];
                                    $_botttle_size = $cartRow["_size"];
                                    $cart_product_price_in_naira = $cartRow["_price"];

                                    //Get Product Details With Id
                                    $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$productId'";
                                    $GetProductDetailsResult = mysqli_query($con,$GetProductDetails);
                                    if ($GetProductDetailsResult->num_rows > 0) {
                                        $HasProductsInCart = true;
                                        $rows = mysqli_fetch_array($GetProductDetailsResult);
                                        $cart_product_name = $rows["product_name"];
                                        $cart_product_link = $rows["product_link"];
                                        $cart_product_category = $rows["product_category"];
                                        $cart_product_img = $rows["product_img"];
                                        $cart_products_available = $rows["products_available"];
                                    } else {
                                        header("Location: Error");
                                    }
                                    //no available
                                    $available = unserialize($cart_products_available);
                                    if ($_botttle_size === "250ml") {
                                        $noAvailable = $available["250ml"];
                                    }else if ($_botttle_size === "500ml") {
                                        $noAvailable = $available["500ml"];
                                    }

                                    $new_product_price_in_selected_currency = floatval($cart_product_price_in_naira) * $user_selected_currency_conversion_to_naira_rate;

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
                                        <h6><a href="/products/<?php echo $cart_product_link; ?>/"><?php echo $cart_product_name; ?></a></h6>
                                        <h6 class="small-h6"><span class="light">Category:</span> <a href="/products/category/<?php echo strtolower($cart_product_category); ?>/"><?php echo $cart_product_category; ?></a></h6>
                                        <h6 class="small-h6"><span class="light">Size:</span> <?php echo $_botttle_size; ?></h6>
                                    </span>
                                    <span class="float-div">
                                        <h6><?php echo $user_selected_currency_symbol." ".number_format($new_product_price_in_selected_currency);?></h6>
                                        <h6 class="small-h6 show-bg" style="<?php echo $cart_product_available_style;?>">(<?php echo intval($noAvailable) - 1;?>) <span class="light">Items Left</span></h6>
                                    </span>
                                </div>
                            </div>
                            <div class="second-div">
                                <div>
                                    <button class="btn-primary btn-delete btn-delete-from-cart" data-name="<?php echo $cart_product_name; ?>" data-product-sku="<?php echo crc32(md5(sha1(md5($productId))));?>" data-product-size="<?php echo $_botttle_size; ?>"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                                <div class="right-divv">
                                    <form id="update-cart">
                                        <div class="form-type-number div-quantity">
                                            <button class="btn-primary btn-icon modal-cart btn-minus" name="upc" id="btn-minus" <?php if($_no_products_ordered <= 1){echo 'disabled=""';}else{echo "";} ?>><i class="fa fa-minus"></i></button>
                                            <span class="num"><input type="number" name="qty" class="num-quantity" value="<?php echo $_no_products_ordered; ?>" max="<?php echo intval($noAvailable); ?>" min="0" readonly></span>
                                            <button class="btn-primary btn-icon modal-cart btn-plus" name="upc" id="btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <input type="hidden" value="<?php echo crc32($productId);?>" name="sku-value">
                                        <input type="hidden" value="<?php echo $_botttle_size; ?>" name="sku-size">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                    </div>
                    <?php }else{ ?>
                    <div class="col-lg-9 div-cart-div">
                        <?php
                            $HasProductsInCart = true;

                            if(isset($_SESSION["shopping_cart"])){
                                $total_in_user_currency = 0;

                            foreach ($_SESSION["shopping_cart"] as $product){      
                            $new_product_price_in_selected_currency = floatval($product["price"]) * $user_selected_currency_conversion_to_naira_rate;
                            $cart_product_available_style = '';
                            $total_in_user_currency += ($product["price"]*$product["quantity"]);
                        ?>
                        <div class="div-cart">
                            <div class="first-div">
                                <div class="img-divv">
                                     <img src="assets/img/products/<?php echo $product["image"]; ?>" class="product-img" width='100' height='100'>
                                </div>
                                <div class="mid-first-div">
                                    <span>
                                        <h6><a href="/products/<?php echo $product["p__link"]; ?>/"><?php echo $product["name"]; ?></a></h6>
                                        <h6 class="small-h6"><span class="light">Category:</span> <a href="/products/category/<?php echo strtolower($product["category"]); ?>/"><?php echo $product["category"]; ?></a></h6>
                                        <h6 class="small-h6"><span class="light">Sizes:</span> <?php echo $product["size"]; ?></h6>
                                    </span>
                                    <span class="float-div">
                                        <h6><?php echo $user_selected_currency_symbol." ".number_format($new_product_price_in_selected_currency);?></h6>
                                        <h6 class="small-h6 show-bg" style="<?php echo $cart_product_available_style;?>">(<?php echo intval($product["available"]) - 1;?>) <span class="light">Items Left</span></h6>
                                    </span>
                                </div>
                            </div>
                            <div class="second-div">
                                <div>
                                    <button class="btn-primary btn-delete btn-delete-from-cart" data-name="<?php echo $product["name"] ?>" data-product-sku="<?php echo crc32(md5(sha1(md5($product["p__id"]))));?>" data-product-size="<?php echo $product["size"] ?>"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                                <div class="right-divv">
                                    <form action="" method="post">
                                        <div class="form-type-number div-quantity">
                                            <button class="btn-primary btn-icon modal-cart btn-minus" name="upc" id="btn-minus" <?php //if($_no_products_ordered <= 1){echo 'disabled=""';}else{echo "";} ?>><i class="fa fa-minus"></i></button>
                                            <span class="num"><input type="number" name="qty" class="num-quantity" value="<?php echo $product["quantity"]; ?>" max="<?php echo intval($product["available"]); ?>" min="0" readonly onchange="this.form.submit()"></span>
                                            <button class="btn-primary btn-icon modal-cart btn-plus" name="upc" id="btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <input type="hidden" value="<?php echo crc32($product["p__id"]);?>" name="sku-value">
                                        <input type="hidden" value="<?php echo $product["size"]; ?>" name="sku-size">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                    </div>
                    <?php } // close if of is not logged in session?>

                    <div class="col-lg-3 w_sidebar show-bg">
                        <div class="spinner">
                            <h1><i class="fa fa-refresh fa-spin"></i></h1>
                        </div>
                        <div class="w__sidebar">
                            <div class="w_summary">Cart Summary</div>
                            <div class="w_subtotal-line">
                                <h6><span class="w_stt-name">SubTotal :</span>
                                <span class="w_stt-price"><?php echo $currency_symbol." ".number_format($total_in_user_currency); ?></span></h6>
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
                            <div class="">
                                <a href="checkout"><button class="btn w_btn-checkout btn-primary btn-check-out">Check out (<?php echo $user_selected_currency_symbol." ".number_format($total_in_user_currency); ?>)</button></a>
                            </div>
                        </div>
                    </div>                    
                </div>

                <div class="w-100 check-div show-sm">
                    <a href="checkout"><button class="btn-check-out btn-primary">checkout (<?php echo $currency_symbol." ".number_format($total_in_user_currency); ?>)</button></a>
                </div>
                <?php }else{?>
                    <div class="col-12 w_main">
                    <center>
                        <div class="w_icon">
                            <i class="fa fa-cart-plus"></i>
                        </div> <br>
                        <h5>You have not added any product to cart yet!</h5>
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
                <input type="hidden" value="" name="product-size" class="product-size">
                <h6>Are you sure you want to delete <span class="product-name"></span> (<span class="product-sz"></span>) from cart?</h6>
                <br><button class="btn btn-primary btn-icon" name="delete"><i class="fa fa-trash"></i> DELETE PRODUCT</button>
            </form>
        </div>

        
        <span id="toastr-9"></span><span id="toastr-10"></span><span id="toastr-11"></span><span id="toastr-12"></span><span id="toastr-13"></span><span id="toastr-14"></span><span id="toastr-15"></span><span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span><span id="toastr-19"></span>
        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/bootstrap-modal.js"></script>
<script src="js/page/modules-toastr.js"></script>
<script type="text/javascript">
    $(document).on("submit", "#update-cart", function (event){

        event.preventDefault();

        var formValues = $(this).serialize();

        $.post("_layout/_ajax.php", {update_cart_from_cart_page: formValues}).done(function (data) {
        
        $(".btn-minus").prop('disabled', true);
        $(".btn-plus").prop('disabled', true);
        //$(".btn-check-out").prop('disabled', true);
        $(".spinner").show();
        //Display the returned data in browser
        var x = document.getElementById("result");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1400);
        $("#result").html(data);
        setTimeout(function(){ 
            $(".btn-minus").prop('disabled', false);
            $(".btn-plus").prop('disabled', false);
            
        }, 1200);
        setTimeout(
            function() {
                $(".w__sidebar").load(" .w__sidebar > *");
                $(".btn-check-out").load(" .btn-check-out > *");
                //$(".btn-check-out").prop('disabled', false);
                $(".check-div").load(" .check-div > *");
                //$(".btn-minus").load(" .btn-minus > *");
                $(".sub-div").load(" .sub-div > *");
        }, 1000); 
        setTimeout(
            function() {
                $(".spinner").hide();
        }, 1200);                                
        });  
    }); 
    $(".btn-delete-from-cart").fireModal({
        title: '',
        footerClass: 'bg-whitesmoke',
        body: $("#delete-cart-form"),
      
    });

    $('.btn-delete-from-cart').on('click', function () {
        var data_sku = $(this).attr("data-product-sku");
        var data_size = $(this).attr("data-product-size");
        var data_name = $(this).attr("data-name");
        
        if (!data_sku || data_sku == "" || data_sku == null || !data_size || data_size =="" || data_size == null){
            alert("Error 402");
            window.location.reload();
        }else{
            if (data_size == "250ml" ||  data_size == "500ml") {
                $('.product-sku').val(data_sku);
                $('.product-size').val(data_size);
                $('.product-sz').text(data_size);
                $('.product-name').text(data_name);
            }else{
                alert("Error 402");
                window.location.reload();
            };
        }
    });

    $('.btn-minus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepDown']();
    })

    $('.btn-plus').on('click', function (e) {
        var input = $(e.target).closest('.div-quantity').find('input');
        input[0]['stepUp']();
    })
    var message = $('.alert-body').text();
    var messageBox = $('.alert-div');
    if (message != "" || message != null) {
        setTimeout(hideMsg, 3000);
    }
    function hideMsg() {
        message = "";
        messageBox.fadeOut(500);
    }
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
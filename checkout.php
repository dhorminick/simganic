<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    

    $message = [];

    if (!isset($_SESSION['loggedin'])) {
        header("Location: sign-in?redirect=cart");
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
        include '_layout/_user_details.php';

    }

    include '_layout/_arrays.php';
    $city =  $cities[$_city];

    include '_layout/_currency_converter.php';
    
    $currency_symbol = $user_selected_currency_symbol;

    $sqli = "SELECT sum(_no_products * (_price * '$user_selected_currency_conversion_to_naira_rate')) AS total FROM _allcarts WHERE _emailaddress = '$_user_email_address'" ;
    $sqliResult = $con->query($sqli);
    foreach ($con->query($sqli) as $row) {
        if ($sqliResult->num_rows > 0) {
            $total = $row["total"];
            $total_in_user_currency = $total;
        }else{
            $checkout = false;
        } 
    }

    $inv_id = "INV-".bin2hex(random_bytes(4)).mt_rand(0000,9999);
    $inv_date = date("F jS, Y");
    $inv_time = date("h:i:s a");
    $ship_address = $_shippingaddress.", ".$cities[$_city].", ".$_state.", Nigeria.";

    if (isset($_POST['process-payment'])) {
        # code...
        $_name = $_firstname." ".$_lastname;

        //insert invoice to db with status: unpaid
        $AddNewOrder = "INSERT INTO _allorders (email, name, invoice, _date, _time, status) VALUES ('$_user_email_address', '$_name', '$inv_id', '$inv_date', '$inv_time', 'unpaid')";
        $OrderAdded = $con->query($AddNewOrder);
        if ($OrderAdded) {
            //header("Location: pay");
        }else{
            array_push($message, "Error 401! Error In Updating Page.");
        }

        //Get Data
        $GetCartsDetails = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0";
        $GetCartsDetailsResult = $con->query($GetCartsDetails);
        $rows_count = mysqli_num_rows($GetCartsDetailsResult);
        while ($cart_row = mysqli_fetch_assoc($GetCartsDetailsResult)) {
                     
            if ($GetCartsDetailsResult->num_rows > 0) {
                    $id = $cart_row["_product_id"];
                    $size = $cart_row["_size"];
                    //$price = $cart_row["_price"];

                    //for ($i=0; $i < $rows_count; $i++) { 
                        $val = $cart_row["_product_id"].'-'.$cart_row["_size"];
                        $item  = array(
                            $val=>array(
                                'p_id'=>$cart_row["_product_id"],
                                'p_size'=>$cart_row["_size"],
                                'p_qty'=>$cart_row["_no_products"],
                                'p_price'=>$cart_row["_price"]
                            )
                        );
                    //}
                    //$items = array_merge_recursive($item);    
                    //$order_items = serialize($items);
                    if(empty($_SESSION["items"])) {
                        $_SESSION["items"] = $item;
                    }else{
                        $_SESSION["items"] = array_merge($_SESSION["items"],$item);
                    }
                    $order_items = serialize($_SESSION["items"]);

                    $shipaddress = $_shippingaddress.", ".$cities[$_city].", ".$_state.", Nigeria.";
                       
                    $UpdateOrder = "UPDATE _allorders SET items = '$order_items', total_price = '$total_in_user_currency', address = '$shipaddress', phone_number = '$_phone' WHERE invoice = '$inv_id'";
                    $UpdateAdded = $con->query($UpdateOrder);
                    if ($UpdateOrder) {
                        header("Location: pay");
                    }
            }
        }
        unset($_SESSION['items']);
    } 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Check Out - SimGanic</title>

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
                    <div class="section-header-breadcrumb" style="margin-left: auto;">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item">Check Out</div>
                    </div>
                </div>
                <?php 
                    $GetCartDetails = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0 ORDER BY _timestamp ASC";
                    $GetCartDetailsResult = $con->query($GetCartDetails);
                    $rowcount = mysqli_num_rows($GetCartDetailsResult);
                    if ($rowcount <= 0) {
                ?> 
                <div class="section-body">
                    <div class="col-12 w_main">
                        <center>
                            <div class="w_icon">
                                <i class="fa fa-cart-plus"></i>
                            </div> <br>
                            <h5>You have no product to check-out yet!</h5>
                            <p>Browse our products and add your preferred item(s) to cart.</p>
                            <a href="all-products" class="csp"><button class="btn btn-primary"><i class="fa fa-arrow-left"></i> Continue Shopping</button></a>
                        </center> 
                    </div>
                </div>       
                <?php }else{ ?>
                <div class="section-body">
                    <div class="col-md-12">
                        <div class="invoice-title">
                            <h5>INVOICE ID: <span style="font-weight:normal !important;"><?php echo $inv_id ?></span></h5>
                        </div><hr><br>
                        <address>
                            <h6>ORDERED ON</h6>
                            <?php echo $inv_date ?>
                            <div class="bullet"></div>
                            <?php echo $inv_time ?>
                        </address><br>
                        <address>
                            <h6>BILLED TO:</h6>
                            <strong>Name :</strong> <?php echo ucwords($_firstname)." ".ucwords($_lastname);?><div class="bullet show-bg"></div><br class="show-sm">
                            <strong>Email <span class="show-bg">Address</span>:</strong> <?php echo $_email; ?><div class="bullet show-bg"></div><br class="show-sm">
                            <strong>Phone No :</strong> <?php echo $_phone; ?>
                            <div style="margin-top:10px;"><a href="/update-account-details/"><button class="btn btn-primary btn-update-"><i class="fa fa-arrow-left"></i> Update Account Details</button></a></div>
                        </address><br>
                        <address>
                            <h6>SHIPPED TO:</h6>
                            <?php echo $ship_address ;?>
                            <div style="margin-top:10px;"><a href="/update-shipping-address/"><button class="btn btn-primary btn-update-"><i class="fa fa-arrow-left"></i> Update Shipping Address</button></a></div>
                        </address><br>
                        <hr>
                        <h5><i class="fa fa-hashtag"></i> Order Summary</h5><br>
                        <div class="table-responsie">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th data-width="40">#</th>
                                    <th>Item(s)</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right show-bg">Total</th>
                                </tr>
                                <?php
                                    $GetCartDetails = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0 ORDER BY _timestamp ASC";
                                    $GetCartDetailsResult = $con->query($GetCartDetails);
                                    $rowcount = mysqli_num_rows($GetCartDetailsResult);
                                    while ($cartRow = mysqli_fetch_assoc($GetCartDetailsResult)) {
                                        //var_dump($cartRow);
                                        //exit();
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
                                            $new_product_price_in_selected_currency = floatval($cart_product_price_in_naira) * $user_selected_currency_conversion_to_naira_rate;
                                            $shippingFee = 2000;

                                            $totalPlusShippping = intval($total_in_user_currency) + intval($shippingFee);
                                ?>
                                <tr>
                                    <td><strong>#</strong></td>
                                    <td><?php echo $cart_product_name." (".$_botttle_size.")"; ?></td>
                                    <td class="text-center"><?php echo $currency_symbol."<span class='show-bg'> </span>".$new_product_price_in_selected_currency; ?></td>
                                    <td class="text-center"><?php echo $_no_products_ordered; ?></td>
                                    <td class="text-right show-bg"><?php echo $currency_symbol."<span class='show-bg'> </span>".$new_product_price_in_selected_currency * $_no_products_ordered; ?></td>
                                </tr>
                                <?php }}?>
                            </table>
                            <div class="text-right table-total">
                                <strong>SubTotal:</strong> <?php echo $currency_symbol."<span class='show-bg'> </span>".number_format($total_in_user_currency, 2); ?>
                                <div class="mg-10"><strong>Total (+ Shipping Fee):</strong> <?php echo $currency_symbol."<span class='show-bg'> </span>".number_format(($total_in_user_currency + $shippingFee), 2); ?></div>
                            </div>
                            <div  style="float:left;">
                                <a href="cart" class="btn btn-danger btn-icon icon-left"><span class="show-bg"><i class="fas fa-times"></i> Cancel Check-Out</span><span class="show-sm"><i class="fas fa-times"></i> Cancel</span></a>
                            </div>
                            <div  style="float:right;">
                                <form method="post" action="">
                                    <button class="btn btn-primary btn-icon icon-left" name="process-payment"><i class="fas fa-credit-card"></i> Process Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </section>
        </div>

        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>
<style>
    .table-total{
        border: 1px solid rgba(0,0,0,0.02) !important;
        background-color: rgba(0,0,0,0.02);
        padding: 15px;
        margin-top: -15px;
        margin-bottom: 20px;
    }
    .mg-10{
        margin-top: 10px;
    }
    .table-total-btns{
        margin-top: 20px;
    }
    
    h6{
        text-transform: uppercase;
    }
</style>


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
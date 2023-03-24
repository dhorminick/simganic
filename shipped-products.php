<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    if(isset($_POST["sign-out"])){
        session_destroy();
        // Redirect to the login page:
        header('Location: sign-in?redirect=shipped-products');  
    }

    $message = [];
    $messages = [];

    if (!isset($_SESSION['loggedin'])) {
        header('Location: sign-in?redirect=shipped-products');    
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    if (isset($_POST["confirm-order"])) {
        $order = trim(strip_tags(htmlspecialchars($_POST["inv"])));
        $CheckIfOrderExist = "SELECT * FROM _allorders WHERE crc32(invoice) = '$order' AND email = '$_user_email_address' AND status = 'Delivered'";
        $OrderExist = $con->query($CheckIfOrderExist);
        if ($OrderExist->num_rows > 0) {
            $row = mysqli_fetch_array($OrderExist);
            $_inv = $row["invoice"];
            $date = date("F jS, Y");
            $Dismissps = "UPDATE _allorders SET status = 'Closed', updated_on = '$date' WHERE invoice = '$_inv' AND email = '$_user_email_address' AND status = 'Delivered'";
            $DismisspsResult = $con->query($Dismissps);
            if ($DismisspsResult) {
                array_push($messages, "Order With Invoice: ".$order." Closed Succesfully.");
                # send mail
                # send mail
                require '_mailer/PHPMailer.php';
                require '_mailer/SMTP.php';
                require '_mailer/Exception.php';
                            
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'mail.tedmaniatv.com'; # prolly use simganic smtp
                $mail->SMTPAuth = true;
                $mail->Username = 'admin@tedmaniatv.com'; # paste one generated by Mailtrap
                $mail->Password = '@lhZkJC_9*p{'; # paste one generated by Mailtrap
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $id = $order;
                $page_link = "https://simganic.com/shipped-products?order-id=".$id;
                $pre_link = "https://simganic.com/products/";
                $faq_link = "https://simganic.com/faqs#cancel-order";
                $web = "https://simganic.com/";
                $website = "https://simganic.com/";
                $report_link = "https://simganic.com/report-order?order=".$id;

                $mail->setFrom("support@simganic.com", "SimGanic");
                $mail->addReplyTo("support@simganic.com", "SimGanic");
                $mail->addAddress($_user_email_address); # name is optional

                $mail->Subject = "Order: ".strtoupper($_inv)." Delivery Confirmed";
                $mail->isHTML(true);
                
                $user_confirmed_order_delivered_email = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    </head>
                    <body>
                        <div class="content bg-light" style="color:#563d7c;border: 1px solid #563d7c;padding: 10px;border-radius: 5px;background-color:#DCE1E5 !important;font-family: \'Raleway\', \'Segoe UI\', arial;font-size:15px;">
                            <div class="logo">
                                
                            </div>
                            <div class="content-body" style="background: white;padding: 20px;border-radius: 5px;">
                            '; 
                                # session start and db connection above
                                $SingleOrders = "SELECT * FROM _allorders WHERE crc32(invoice) = '$id' AND email = '$_user_email_address' AND status != 'Closed'";
                                $SingleOrdersResult = $con->query($SingleOrders);
                                if ($SingleOrdersResult -> num_rows > 0) {
                                    while($_row = mysqli_fetch_array($SingleOrdersResult)){
                                        $order_email = $_row["email"];
                                        $order_name = $_row["name"];
                                        $order_items = $_row["items"];
                                        $order_address = $_row["address"];
                                        $order_phone_number = $_row["phone_number"];
                                        $order_total_price = $_row["total_price"];
                                        $order_invoice = $_row["invoice"];
                                        $order_shipping_fee = $_row["shipping_fee"];
                                        $order_date = $_row["_date"];
                                        $order_time = $_row["_time"];
                                        $order_status = ucwords($_row["status"]);
                                        $order_delivery_date = $_row["delivery_date"];

                                        $order_items = unserialize($order_items);

                                        $_user_email_address = $order_email;

                                        include "_layout/_currency_converter.php";
                                        if ($order_shipping_fee == null) {
                                            $order_shipping_fee = 0;
                                        }
                                        if ($_SESSION['lastname'] != null) {$_usr = $_SESSION['lastname'];}else{$_usr = $_SESSION['username'];}
                        
                                        $currency_symbol = $user_selected_currency_symbol;
                            $user_confirmed_order_delivered_email .= '
                                <div class="content-header-text" style="font-weight:700;margin-bottom: 10px;font-size:25px;">
                                Order: '.strtoupper($order_invoice).' Delivery Confirmed</div>
                                <hr style="margin-bottom:20px;">
                                <div style="font-size:17px;">
                                	<div style="display:none;">Hi '.ucwords($_usr).',</div>
                                    Your order: '.strtoupper($order_invoice).' has been confirmed. You can cross-check order details below.
                                </div>
                                <address style="font-style:normal !important;margin-top:30px;">
                                    <div class="" style="font-weight:700;font-size:17px;margin-bottom:10px;text-decoration:none;">Ordered On</div>
                                    '.$order_date.' 
                                    <div class="bullet" style="margin:5px;"></div>
                                    '.$order_time.'                        
                                </address>
                                <address style="font-style:normal !important;margin-top:30px;">
                                    <div class="" style="font-weight:700;font-size:17px;margin-bottom:10px;text-decoration:none;">Delivered On</div>
                                    '.$order_delivery_date.'                        
                                </address>
                                <address style="font-style:normal !important;margin-top:30px;">
                                    <div class="" style="font-weight:700;font-size:17px;margin-bottom:10px;text-decoration:none;">Billed To:</div>
                                    <div><strong>Name :</strong> '.ucwords($order_name).' </div>
                                    <div style="margin-top:5px;"><strong>Email Address :</strong> '.$order_email.'</div>
                                    <div style="margin-top:5px;"><strong>Phone No :</strong> '.$order_phone_number.' </div>                       
                                </address>
                                <address style="font-style:normal !important;margin-top:30px;">
                                    <div class="" style="font-weight:700;font-size:17px;margin-bottom:10px;text-decoration:none;">Shipped To:</div>
                                    '.$order_address.'
                                </address>
                                <div style="font-weight:700;font-size:17px;margin-bottom:15px;margin-top:30px;">Order Summary :</div>

                                <table class="table table-striped table-hover table-md" style="width:100%;color:#563d7c;border: 1px solid #563d7c;border-collapse: collapse;">
                                    <tr>
                                        <th style="padding: 7px;border: 1px solid #563d7c;border-collapse: collapse;">#</th>
                                        <th style="padding: 7px;border: 1px solid #563d7c;border-collapse: collapse;text-align:left;">Product(s)</th>
                                        <th style="padding: 7px;border: 1px solid #563d7c;border-collapse: collapse;text-align:center;">Price</th>
                                        <th style="padding: 7px;border: 1px solid #563d7c;border-collapse: collapse;text-align:center;">Quantity</th>
                                        <th style="padding: 7px;border: 1px solid #563d7c;border-collapse: collapse;text-align:right;">Total</th>
                                    </tr>
                                    ';
                                        foreach ($order_items as $key => $value) {
                                            $val = $value['p_id'];
                                            $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$val'";
                                            $GetProductDetailsResult = $con->query($GetProductDetails);
                                            while ($row = mysqli_fetch_assoc($GetProductDetailsResult)) {
                                                if ($GetProductDetailsResult->num_rows > 0) {
                                                    $name = $row["product_name"];  
                                                    $link = $row["product_link"];            
                                    $user_confirmed_order_delivered_email .= '
                                    <tr>
                                        <td style="border: 1px solid #563d7c;border-collapse: collapse;padding:5px;text-align:center;"><strong>#</strong></td>
                                        <td style="border: 1px solid #563d7c;border-collapse: collapse;padding:5px;text-align:left;"><a style="text-decoration:none;" href="'.$pre_link.$link.'/">'.$name.' ('.$value['p_size'].')</a></td>
                                        <td style="border: 1px solid #563d7c;border-collapse: collapse;padding:5px;text-align:center;">'.$currency_symbol."".$value['p_price'].'</td>
                                        <td style="border: 1px solid #563d7c;border-collapse: collapse;padding:5px;text-align:center;">'.$value['p_qty'].'</td>
                                        <td style="border: 1px solid #563d7c;border-collapse: collapse;padding:5px;text-align:right;">'.$currency_symbol."".number_format((intval($value['p_price']) * intval($value['p_qty'])), 2).'</td>
                                    </tr>
                                    '; }}} $user_confirmed_order_delivered_email .= '
                                </table>
                            '; }} $user_confirmed_order_delivered_email .= '

                                <div class="text-right table-total" style="text-align:right;">
                                    <div style="margin: 10px 0px !important;"><strong>SubTotal :</strong> '.$currency_symbol."<span class='show-bg'> </span>".number_format($order_total_price, 2).'</div>
                                    <div><strong>Total (+ Shipping Fee) :</strong> '.$currency_symbol."<span class='show-bg'> </span>".number_format(($order_total_price + $order_shipping_fee), 2).'</div>
                                </div>
                                <div style="margin-top:20px;margin-bottom:20px;">
                                    How was your shopping experience? We rely on customer reviews to help shoppers learn more abut our products. You can share a thought by adding a star rating and comment. 
                                    <div style="margin-top:20px;margin-bottom:20px;">
                                    <a href="'.$pre_link.$link.'/" style="text-align: center;box-shadow:0 2px 6px #7a58ad;background-color:#563d7c;border-color:#563d7c;padding: 10px 10px;color:white;text-decoration:none;border-radius:5px;">
                                    Submit A Review &raquo;
                                    </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right" style="text-align:right;margin-top:40px;">
                                    <div>Thanks For Shopping With Us,</div>
                                    <a href="mailto:support@simganic.com" style="text-decoration:none;">support@simganic.com</a>
                                    <div class="content-footer">
                                    <a href=""><i class="fa-brands fa-facebook"></i></a> 
                                    <a href=""><i class="fa-brands fa-whatsapp"></i></a> 
                                    <a href=""><i class="fa-brands fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>
                '; # send invoice
                $mail->Body = $user_confirmed_order_delivered_email; # order invoice
                $mail->AltBody = "Order: ".strtoupper($_inv)." Delivery Confirmed";

                $mail->send();
                if($mail->send()){
                    header("Location: shipped-products");
                }else{ 
                    array_push($messages, "<i class='fa fa-cancel'></i> Error 501! Status Update Mail Not Sent. Mailer Error: {$mail->ErrorInfo}");
                    # header("redirect: 4;url=shipped-products");
                }
            }else{
                array_push($messages, "<i class='fa fa-cancel'></i> Error 501! Order Update Error.");
            }
        }else{
            array_push($messages, "<i class='fa fa-cancel'></i> Error 402 Invoice Error! Refrain From Switching Order Invoice Values To Avoid Getting Banned On SimGanic");
        }
    }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Track Your Ordered Products - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.min.css">
<link rel="stylesheet" href="assets/css/components.min.css">
<link rel="stylesheet" href="assets/css/mystyle.css">
<link rel="stylesheet" href="assets/css/trck.css">
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
                        <div class="breadcrumb-item">Orders</div>
                    </div>
                </div>

                <div class="section-body">
                    <?php if (count($messages) > 0) : ?>
                        <div class="alert-div">
                            <?php foreach ($messages as $error) : ?>
                            <div class="alert alert-primary alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <?php echo $error ?>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <?php 
                        if (isset($_GET["order-id"])) {
                            $id = trim(strip_tags($_GET["order-id"]));
                            $SingleOrders = "SELECT * FROM _allorders WHERE crc32(invoice) = '$id' AND email = '$_user_email_address' AND status != 'Closed'";
                            $SingleOrdersResult = $con->query($SingleOrders);
                            if ($SingleOrdersResult -> num_rows > 0) {
                                while($_row = mysqli_fetch_array($SingleOrdersResult)){
                                    $order_email = $_row["email"];
                                    $order_name = $_row["name"];
                                    $order_items = $_row["items"];
                                    $order_address = $_row["address"];
                                    $order_phone_number = $_row["phone_number"];
                                    $order_total_price = $_row["total_price"];
                                    $order_invoice = $_row["invoice"];
                                    $order_date = $_row["_date"];
                                    $order_time = $_row["_time"];
                                    $order_status = ucwords($_row["status"]);
                                    $order_delivery_date = $_row["delivery_date"];

                                    $order_items = unserialize($order_items);

                                    switch (ucwords($order_status)) {
                                        case 'Unpaid':
                                            $btn_class = "btn btn-danger";
                                            $updateStatus = "Cancelled";
                                            break;

                                        case 'Paid':
                                            $btn_class = "btn btn-light";
                                            $updateStatus = "Shipped";
                                            break;

                                        case 'Shipped':
                                            $btn_class = "btn btn-warning";
                                            $updateStatus = "Delivered";
                                            break;

                                        case 'Delivered':
                                            $btn_class = "btn btn-success";
                                            $updateStatus = "Delivered";
                                            break;

                                        default:
                                            $btn_class = "btn btn-primary";
                                            $updateStatus = "Shipped";
                                            break;
                                    }

                                    $_user_email_address = $order_email;

                                    include '_layout/_currency_converter.php';
    
                                    $currency_symbol = $user_selected_currency_symbol;
                    ?>
                    <div class="col-md-12">
                        <div class="invoice-title">
                            <h5>INVOICE ID: <span style="font-weight:normal !important;"><?php echo $order_invoice ?></span></h5>
                        </div><hr><br>
                        <address>
                            <h6>ORDERED ON</h6>
                            <?php echo $order_date ?>
                            <div class="bullet"></div>
                            <?php echo $order_time ?>
                        </address><br>
                        <?php if($order_status === "Delivered"){ ?>
                        <address>
                            <h6>DELIVERED ON</h6>
                            <?php echo $order_delivery_date ?>
                            <div class="bullet"></div>
                            <button class="btn btn-primary btn-icon close-order"> Confirm / Report Products</button>
                            <div id="div-update-order">
                                <form action="" method="post">
                                    <input type="hidden" value="<?php echo crc32($order_invoice); ?>" name="inv">
                                    Confirm The Delivery Of Order With Invoice ID: <strong><?php echo $order_invoice; ?></strong><br><br>
                                    <button class="btn btn-danger" style="float:right;margin-left:10px;" name="confirm-order"><i class="fa fa-check"></i> Confirm Delivery</button>
                                    <a href="report-order?order=<?php echo crc32($order_invoice); ?>" target="_blank" class="btn btn-danger" style="float:right;"><i class="fa fa-cancel"></i> Report Order</a>
                                </form>
                            </div>
                        </address><br>
                        <?php } ?>
                        <address>
                            <h6>BILLED TO:</h6>
                            <strong>Name :</strong> <?php echo ucwords($order_name);?><div class="bullet show-bg"></div><br class="show-sm">
                            <strong>Email <span class="show-bg">Address</span>:</strong> <?php echo $order_email; ?><div class="bullet show-bg"></div><br class="show-sm">
                            <strong>Phone No :</strong> <?php echo $order_phone_number ; ?>
                        </address><br>
                        <address>
                            <h6>SHIPPED TO:</h6>
                            <?php echo $order_address ;?>
                        </address><br>
                        <div>
                            <strong>Order Status <div class="bullet"></div> <button class="close-d <?php echo $btn_class; ?>" type="button"> <?php echo ucwords($order_status);?></button></strong>
                            <!--<div class="bullet"></div> <button class="btn btn-success btn-icon"><i class="fa fa-check"></i> Confirm Order Delivery</button>-->
                        </div><hr>
                        <h5><i class="fa fa-hashtag"></i> Order Summary</h5><br>
                        <div class="table-responsie">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th data-width="40">#</th>
                                    <th>Item(s)</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                <?php
                                    foreach ($order_items as $key => $value) {
                                        $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$value[p_id]'";
                                        $GetProductDetailsResult = $con->query($GetProductDetails);
                                        while ($row = mysqli_fetch_assoc($GetProductDetailsResult)) {
                                            if ($GetProductDetailsResult->num_rows > 0) {
                                                $name = $row["product_name"];            
                                ?>
                                <tr>
                                    <td><strong>#</strong></td>
                                    <td><?php echo $name." (".$value['p_size'].")"; ?></td>
                                    <td class="text-center"><?php echo $currency_symbol."<span class='show-bg'> </span>".$value['p_price']; ?></td>
                                    <td class="text-center"><?php echo $value['p_qty']; ?></td>
                                    <td class="text-right"><?php echo $currency_symbol."<span class='show-bg'> </span>".number_format((intval($value['p_price']) * intval($value['p_qty'])), 2); ?></td>
                                </tr>
                                <?php }}}?>
                                
                            </table>
                            <div class="text-right table-total">
                                <strong>SubTotal:</strong> <?php echo $currency_symbol."<span class='show-bg'> </span>".number_format($order_total_price, 2); ?>
                            </div>
                        </div>
                    </div>
                    <?php }}else{echo "<script>alert('Error 402! Order Invoice Error.')</script><div class='col-12 w_main'><center><div class='w_icon'><i class='fa fa-cancel' style='transform:none !important;'></i></div><br><h3>Oops!! Nothing To Show Here.</h3><p></p><a href='all-products' class='csp'><button class='btn btn-primary btn-update-s'><i class='fa fa-arrow-left'></i> Continue Shopping</button></a></center></div>";}}else{ ?>
                    <div class="w-100">
                        <?php
                            $AllOrders = "SELECT * FROM _allorders WHERE email = '$_user_email_address' AND status = 'paid' OR email = '$_user_email_address' AND status ='shipped' OR email = '$_user_email_address' AND status = 'delivered' ORDER BY _date DESC";
                            $AllOrdersResult = $con->query($AllOrders);
                            if ($AllOrdersResult -> num_rows > 0) { 
                        ?>
                        <div class="card">
                            <div class="card-hader" style="padding:20px 0px 0px 15px;">
                                <h4 style="font-size:18px !important;text-transform:uppercase;">Recent Orders</h4>
                            </div><br>
                            <div class="card-body p-0">
                                <div class="table-responsve">
                                    <table class="table table-striped table-md">
                                    <tbody><tr>
                                        <th style="text-transform:uppercase;"><span class="show-bg">Order</span> Invoice</th>
                                        <th style="text-transform:uppercase;" class="text-center"><span class="show-bg">Order</span> Status</th>
                                        <th style="text-transform:uppercase;" class="text-center"><span class="show-bg">Order</span> Date</th>
                                        <th style="text-transform:uppercase;" class="text-right"><span class="show-bg">Order</span> Details</th>
                                    </tr>
                                    <?php
                                            while($row = mysqli_fetch_array($AllOrdersResult)){
                                                $invoice = $row["invoice"];
                                                $name = $row["name"];
                                                //$items = $row["items"];
                                                $date = $row["_date"];
                                                $status = ucwords($row["status"]);

                                                switch ($status) {
                                                    case 'Unpaid':
                                                        $btn_class = "btn-warning";
                                                        break;

                                                    case 'Paid':
                                                        $btn_class = "btn-dark";
                                                        break;

                                                    case 'Shipped':
                                                        $btn_class = "btn-warning";
                                                        break;

                                                    case 'Delivered':
                                                        $btn_class = "btn-success";
                                                        break;

                                                    default:
                                                        $btn_class = "btn-primary";
                                                        break;
                                                }
                                    ?>
                                    <tr>
                                        <td><a href="?order-id=<?php echo crc32($invoice); ?>"><?php echo '<span class="show-bg">'.$invoice.'</span><span class="show-sm">'.wordwrap($invoice,4," ",TRUE).'</span>'; ?></a></td>
                                        <td class="text-center"><div class="btn btn-status <?php echo $btn_class; ?>"><?php echo ucwords($status); ?></div></td>
                                        <td class="text-center"><?php echo $date; ?></td>
                                        <td class="text-right">
                                        <a href="?order-id=<?php echo crc32($invoice); ?>" target="_blank" class="btn btn-status btn-primary"><?php if($status === "Delivered"){echo "Confirm<span class='show-bg'> Delivery</span>";}else{echo "Details";}?> <i class="fas fa-arrow-right"></i></a>
                                        </td>
                                    </tr>

                                    <?php } ?></tbody></table><?php }else{ ?>
                                    <div class="col-12 w_main">
                                        <center>
                                            <div class="w_icon">
                                                <i class="fa fa-shipping-fast" style="transform:none !important;"></i>
                                            </div> <br>
                                            <h5>You have not ordered any product yet!</h5>
                                            <p>Browse our categories and purchase your preferred product(s).</p>
                                            <a href="all-products" class="csp"><button class="btn btn-primary"><i class="fa fa-arrow-left"></i> Continue Shopping</button></a>
                                        </center> 
                                    </div>
                                    <?php } ?>
                                    
                                    <div style="margin-left:25px;margin-bottom:10px;display:none;">
                                        Showing <strong>1 - 10</strong> of <strong>10</strong> orders <div class="bullet"></div> <a href="#" class="btn btn-danger">View All <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

            </section>
        </div>

        <style>
            .table.table-bordered td, .table.table-bordered th{
                border: 1px solid #dee2e6 !important;
            }
            .btn-status{
                text-transform: uppercase;
                font-weight: bolder;
                letter-spacing: 1px;
            }
            .table-total{
                border: 1px solid rgba(0,0,0,0.02) !important;
                background-color: rgba(0,0,0,0.02);
                padding: 15px;
                margin-top: -15px;
            }
            .status{
                font-weight: normal;
            }
            .btn.btn-success.btn-icon{

            }
        </style>

        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->
<script>
    $(".close-order").fireModal({
      title: 'Update Order Status',
      footerClass: 'bg-whitesmoke',
      body: $("#div-update-order"),
    });
</script>
<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "";
        header("Location: open-dispute");
        exit();
    }else{
        $_user_email_address = $_SESSION['email'];
    }

    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    $message = [];

    if (isset($_POST["report-order"])) {
        if ($_POST["email"] !== null && $_POST["order"] !== null && $_POST["message"] !== null) {
            $id = strtoupper("#ID-".bin2hex(random_bytes(4)).mt_rand(0000,9999));
            $email = strip_tags(trim($_POST["email"]));
            $order = strip_tags(trim(htmlspecialchars($_POST["order"])));
            $d_message = strip_tags(trim($_POST["message"]));
            $CheckIfOrderExist = "SELECT * FROM _allorders WHERE invoice = '$order'";
            $OrderExist = $con->query($CheckIfOrderExist);
            if ($OrderExist->num_rows > 0) {
                $AddDispute = "INSERT INTO _disputes (dispute_id, dispute_category, dispute_email, dispute_header, dispute_message, status) VALUES ('$id', 'report-an-order', '$email', 'Report $order', '$d_message', 'open')";
                $DisputeAdded = $con->query($AddDispute);
                if ($DisputeAdded) {
                    array_push($message, "Order Reported. SimGanic Will Contact You Via E-Mail As Soon As Possible.");
                }else{
                    array_push($message, "Error 501! Error In Submitting Dispute.");
                }
            }else{
                array_push($message, "Error 402 Invoice Error! Refrain From Switching Order Invoices To Avoid Getting Banned On SimGanic");
            }
        }else{
            array_push($message, "Error 402! Details Error");
        }
    }

    $value = null;

    if (isset($_GET["order"])) {
        $order_id = strip_tags(trim($_GET["order"]));

        $CheckIfOrderExist = "SELECT * FROM _allorders WHERE crc32(invoice) = '$order_id'";
        $OrderExist = $con->query($CheckIfOrderExist);
        if ($OrderExist->num_rows > 0) {
            $row = mysqli_fetch_array($OrderExist);
            $inv = $row["invoice"];
            $value = 'value="'.$inv.'" readonly=""';
        }else{
            array_push($message, "Error 402! Order Doesn't Exist."); 
            $value = null;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Report An Order - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="assets/modules/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
<link rel="stylesheet" href="assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

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
                        <div class="breadcrumb-item">Report Order</div>
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
                    <form method="POST" action="">
                        <div class="card-body pb-0">
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="email" placeholder="Enter Email Address..." value="<?php echo $_user_email_address;?>" <?php if (isset($_SESSION['loggedin'])) { echo 'readonly=""';}else{}?>>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Order Invoice</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="order" placeholder="Enter Dispute Subject..." <?php echo $value;?> required="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Report</label>
                                <textarea class="form-control txt-area" name="message" placeholder="Report.." required=""></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-disputes" name="report-order">Submit Dispute <i class="fa fa-arrow-right"></i></button>
                            </div>
                            <style>
                                .select2-search__field{
                                    display: none !important;
                                }
                                .btn-disputes{
                                    text-transform: uppercase;
                                    letter-spacing: 1px !important;
                                }
                            </style>
                        </div>
                    </form>
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
<script src="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="assets/modules/select2/dist/js/select2.full.min.js"></script>
<script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/forms-advanced-forms.js"></script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
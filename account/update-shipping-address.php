<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header("Location: /sign-in?redirect=update-shipping-address");
        exit();
    }else{
        
    }
    //dbconn
    $dbconn = include $_SERVER['DOCUMENT_ROOT'].'/_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    $message = [];
    //echo md5(sha1("@lhZkJC_9*p{"));exit();

    $_user_email_address = $_SESSION['email'];
    $_user_name = $_SESSION['username'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    if (isset($_POST["update"])) {

            $up_shippingaddress = strip_tags($_POST["address"]);
            if (isset($_POST["city"])) {
                $up_city = strip_tags($_POST["city"]);
            }else{
                $up_city = null;
            }
            
            $up_state = "Lagos";

            if ($up_shippingaddress && $up_shippingaddress !== null & $up_city && $up_city !== null) {
                # code...
                $UpdateUser = "UPDATE _users SET _shippingaddress = '$up_shippingaddress', _city = '$up_city', _state = '$up_state' WHERE _email = '$_user_email_address'";
                $IsUserUpdated = $con->query($UpdateUser);

                if ($IsUserUpdated) {
                    array_push($message, "Shipping Address Updated Succesfully.");
                    //header("Refresh: 2");
                }else{
                    array_push($message, "Error 401. Error.");
                }
            }else{
                array_push($message, "Error 402! Address Details Error.");
            }
    }
    
    //Check If Shipping Address Has Been Added Already
    $CheckAddress = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $AddressAdded = $con->query($CheckAddress);

    if ($AddressAdded->num_rows > 0) {
        $row = $AddressAdded->fetch_assoc();
        $shippingaddress = $row["_shippingaddress"];
        $city = $row["_city"];
        $state = $row["_state"];
        //if ($state === ) {echo "selected";}
    }else{
        header("Location: 404");
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Update Shipping Address &mdash; SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="/assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="/assets/modules/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="/assets/modules/jquery-selectric/selectric.css">
<link rel="stylesheet" href="/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

<!-- Template CSS -->
<link rel="stylesheet" href="/assets/css/style.min.css">
<link rel="stylesheet" href="/assets/css/components.min.css">
<link rel="stylesheet" href="/assets/css/mystyle.css">
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
                    <div class="section-header-breadcrumb"  style="margin-left:auto;">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item show-bg"><a href="/my-account">Account</a></div>
                        <div class="breadcrumb-item">Update <span class="show-bg">Account</span> Address</div>
                    </div>
                </div>

                <div class="section-body">
                    <h5>Saved Addresses</h5>
                    <div class="card-body">
                    <form method="post" action="">
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
                        <div class="form-group">
                            <label for="inputAddress">Address 1</label>
                            <input type="text" class="form-control" value="<?php echo $shippingaddress;?>" name="address" placeholder="Enter Address..." required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label>Select City</label>
                                <select class="form-control select2" name="city">
                                    <option value="" disabled="" <?php if ($city === "" || $city = null) {echo "selected";}?>>--Select City--</option>
                                    <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_shippingcities.php';?>                                    
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Select Region</label>
                                <select class="form-control select2" name="state">
                                    <option value="" disabled="" <?php if ($state === "" || $state = null) {echo "selected";}?>>--Select Region--</option>
                                    <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_shippingstates.php';?>
                                </select>
                            </div>
                        </div>
                        <div><strong>NB:</strong> Shippings are restricted to Lagos only.</div><br>
                    <div class="form-group">
                        <button class="btn btn-primary btn-updates" name="update">Update Address</button>
                    </div>

                    </form>
                    </div>
                </div>
            </section>
        </div>

        <!-- Start app Footer part -->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="/assets/bundles/lib.vendor.bundle.js"></script>
<script src="/js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="/assets/modules/select2/dist/js/select2.full.min.js"></script>
<script src="/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

<!-- Page Specific JS File -->
<script src="/js/page/forms-advanced-forms.js"></script>

<!-- Template JS File -->
<script src="/js/scripts.js"></script>
<script src="/js/custom.js"></script>
</body>


</html>
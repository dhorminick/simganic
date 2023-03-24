<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header("Location: /sign-in?redirect=update-account-details");
        exit();
    }else{

    }
    //dbconn
    $dbconn = include $_SERVER['DOCUMENT_ROOT'].'/_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    $message = [];
    //array_push($message, "Test");

    $_user_email_address = $_SESSION['email'];
    $_user_name = $_SESSION['username'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $phone1 = $_SESSION['phone'];

    //Check If Phone Number Two Has Been Added Already
    $CheckPhone = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $PhoneTwoAdded = $con->query($CheckPhone);

    if ($PhoneTwoAdded->num_rows > 0) {
        $row = $PhoneTwoAdded->fetch_assoc();
        $user_firstname = $row["_firstname"];
        $user_lastname = $row["_lastname"];
        $user_username = $row["_username"];
        $user_phone1 = $row["_phone"];
        $user_phone2 = $row["phone_add"];
    }else{
        header("Location: 404");
    }

    if (isset($_POST["update"])) {
        $up_username = strip_tags($_POST["username"]);
        $up_firstname = strip_tags($_POST["firstname"]);
        $up_lastname = strip_tags($_POST["lastname"]);
        $up_phone1 = strip_tags($_POST["phone1"]);
        $up_phone2 = strip_tags($_POST["phone2"]);

        $UpdateUser = "UPDATE _users SET _username = '$up_username', _firstname = '$up_firstname', _lastname = '$up_lastname', _phone = '$up_phone1', phone_add = '$up_phone2' WHERE _email = '$_user_email_address'";
        $IsUserUpdated = $con->query($UpdateUser);

        if ($IsUserUpdated) {
            array_push($message, "Account Details Updated.");
            array_push($message, "Refreshing Details.");

            $_SESSION['username'] = $up_username;
            $_SESSION['firstname'] = $up_firstname;
            $_SESSION['lastname'] = $up_lastname;
            $_SESSION['phone'] = $up_phone1;

            header("Refresh: 0");
        }
    }

    include $_SERVER['DOCUMENT_ROOT'].'/_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Update Account Details - SimGanic</title>

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
                        <div class="breadcrumb-item">Update <span class="show-bg">Account</span> Details</div>
                    </div>
                </div>

                <div class="section-body">
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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">FirstName</label>
                                <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" placeholder="FirstName" name="firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">LastName</label>
                                <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" placeholder="LastName" name="lastname">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Username</label>
                                <input type="text" class="form-control" value="<?php echo $user_username; ?>" placeholder="UserName" name="username">
                            </div>
                            <div class="form-group col-md-6">
                                <label data-toggle="tooltip" data-placement="right" title="" data-original-title="Only Naira Is Accepted!">Currency</label>
                                <select class="form-control *select2" disabled="">
                                    <option value="">--Select Currency--</option>
                                    <option value="NGN" selected="">Naira (NGN)</option>
                                    <option value="USD" disabled="">Dollars (USD) </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Phone Number">Phone Number</label>
                                <input type="text" class="form-control" maxlength="11" value="<?php echo $user_phone1; ?>" placeholder="Phone Number" name="phone1">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Additional Phone Number">Additional Phone Number</label>
                                <input type="text" class="form-control" maxlength="11" value="<?php echo $user_phone2; ?>" placeholder="Additional Phone Number (Optional)" name="phone2">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-updates" name="update">UPDATE DETAILS</button>
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
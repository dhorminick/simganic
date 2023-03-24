<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
    }else{
        header("Location: /account/update-account-password");
        exit();
    }
    $_user_email_address = $_SESSION['email'];
    $_user_name = $_SESSION['username'];
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    $messages = [];
    //array_push($messages, "<i class='fa fa-check'></i> Email Account Verification Complete.");

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Activate Account - SimGanic</title>

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
                        <div class="breadcrumb-item">Activate Account</div>
                    </div>
                </div>

                <div class="section-body">
                    <?php
                        if (isset($_GET["e"]) && isset($_GET["token"]) && $_GET["e"] != null && $_GET["token"] != null) {
                            $email = trim(htmlspecialchars(strip_tags($_GET["e"])));
                            $token = trim(htmlspecialchars(strip_tags($_GET["token"])));
                            //$email = hex2bin($email);

                            $CheckIfUserExist = "SELECT * FROM _users WHERE md5(_email) = '$email' AND _token = '$token'";
                            $UserExist = $con->query($CheckIfUserExist);
                            if ($UserExist->num_rows > 0) {

                                $row = mysqli_fetch_array($UserExist);
                                $u_email = $row["_email"];
                                $isverified = $row["isverified"];

                                if ($isverified === "1") {
                                    array_push($messages, "<i class='fa fa-cancel'></i> Error 402! Invalid Request: Token Error");
                                    //header("refresh:4;url='/'");
                                    //echo '<script>setTimeout(function(){ window.location.assign("/") }, 3000);</script>';
                                } else {
                                    $UpdateUser = "UPDATE _users SET isverified = true WHERE _email = '$u_email' AND _token = '$token'";
                                    $IsUserUpdated = $con->query($UpdateUser);
                                    if ($IsUserUpdated) {
                                        $_SESSION['login_email'] = $u_email;
                                        array_push($messages, "<i class='fa fa-check'></i> Email Account Verification Complete.");
                                        array_push($messages, "Redirecting To Sign In Page.");
                                        echo '<script>setTimeout(function(){ window.location.assign("sign-in") }, 3500);</script>';
                                    }else{
                                        array_push($messages, "Error 501! Server Error.");
                                    }
                                }
                            } 
                    ?>
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
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-bottom:-90px !important;">
                        <div class="card">
                            <div class="card-body">
                                <div class="empty-state" data-height="400" style="height: 400px;">
                                    <div class="empty-state-icon bg-primary"><i class="fa-solid fa-envelope-circle-check"></i></div>
                                    <h2>Verify Your Email Account</h2>
                                    <p class="lead">Login to your mail and click on the verify button sent to your email address to verify your email account.<br>In case of missing mail, check spam folder or contact us @ <a href="mailto:support@simganic.com">support@simganic.com</a></p>
                                    <a href="/" class="btn btn-primary mt-4"><i class="fas fa-arrow-left"></i> Back To Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else{ ?>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-bottom:-90px !important;">
                        <div class="card">
                            <div class="card-body">
                                <div class="empty-state" data-height="400" style="height: 400px;">
                                    <div class="empty-state-icon bg-primary"><i class="fa-solid fa-envelope-circle-check"></i></div>
                                    <h2>Verify Your Email Account</h2>
                                    <p class="lead">Login to your mail and click on the verify button sent to your email address to verify your email account.<br>In case of missing mail, check spam folder or contact us @ <a href="mailto:support@simganic.com">support@simganic.com</a></p>
                                    <a href="/" class="btn btn-primary mt-4"><i class="fas fa-arrow-left"></i> Back To Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
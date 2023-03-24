<?php
    session_start();
    
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    if (isset($_SESSION['admin_loggedin'])) {
        header('Location: /');    
    }

    $message = [];

    if (isset($_POST["sign-in"])) {
        $user = trim($_POST["user"]);
        $password = trim($_POST["password"]);

        if ($user == null && $password == null) {
            array_push($message, "Email Address and Password Error.");
        }else{
            //filter strings
            $user = strip_tags($user);
            $password = strip_tags($password);
            
            if ($user === "admin" && $password === "admin") {
                $_SESSION['admin_loggedin'] = TRUE;
                $_SESSION['username'] = "Admin";
                
                if (isset($_GET["redirect"])) {
                    array_push($message, "Login Successful.");
                    $prevUrl = $_GET["redirect"];
                    header("Location: $prevUrl");
                }else{
                    array_push($message, "Login Successful.");
                    header("Location: /");
                }
                
            }elseif ($user === "admin2" && $password === "admin2") {
                $_SESSION['admin_loggedin'] = TRUE;
                $_SESSION['username'] = "Admin 2";
                
                if (isset($_GET["redirect"])) {
                    array_push($message, "Login Successful.");
                    $prevUrl = $_GET["redirect"];
                    header("Location: $prevUrl");
                }else{
                    array_push($message, "Login Successful.");
                    header("Location: /test");
                }
                
            }else{
                array_push($message, "Login Unsuccessful! Email and Password Combination Doesn't Exist.");
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Sign In To Your Account &mdash; SimGanic</title>

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
        
        <?php include '_layout/_header_sidebar_admin.php';?>
        
        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Sign In To Your SimGanic Account</h1>
                </div>

                <div class="section-body">
                    <div class="card" id="sample-login">
                        <form method="post" action="">
                            <div class="card-body pb-0">
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
                                    <label>Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="user" placeholder="Enter Username..." required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        </div>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                                        <div class="input-group-append" title data-toggle="tooltip" data-placement="left" data-original-title="Toggle Password Visibility">
                                            <div class="input-group-text">
                                                <i class="fa fa-eye eye-fa"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="csrfToken" value="">
                            </div>
                            <div class="card-footer pt-">
                                <button type="submit" name="sign-in" class="btn btn-primary btn btn-form">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <style>
            .btn-form{
                text-transform: uppercase;
                font-weight: bolder;
                letter-spacing: 2px;
                padding: 10px 15px;
            }
            .see{
                position: absolute;
                right: 3px;
                top: 3px;
                font-size: 20px;
                margin: auto;
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
    $(".input-group-append").click(function(){
        var x = document.getElementById("password");
        var y = document.getElementById("pass-confirm");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
            $(".eye-fa").removeClass("fa-eye");
            $(".eye-fa").addClass("fa-eye-slash");
        } else {
            x.type = "password";
            y.type = "password";
            $(".eye-fa").addClass("fa-eye");
            $(".eye-fa").removeClass("fa-eye-slash");
        }
    });

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
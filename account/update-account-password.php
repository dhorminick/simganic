<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header("Location: /sign-in?redirect=update-account-password");
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
        $up_old_password = md5(sha1(strip_tags(trim($_POST["old-password"]))));
        $up_new_password = strip_tags(trim($_POST["new-password"]));
        $up_confirm_password = strip_tags(trim($_POST["confirm-password"]));

        if ($up_new_password != $up_confirm_password) {
            array_push($message, "Error 402! Passwords Don't Match.");
        }else{
            $CheckIfUserExist = "SELECT * FROM _users WHERE _email = '$_user_email_address' AND _password = '$up_old_password'";
            $UserExist = $con->query($CheckIfUserExist);
            if ($UserExist->num_rows > 0) {
                //passwords match, hash it
                $new_password = md5(sha1($up_new_password));
                $UpdateUser = "UPDATE _users SET _password = '$new_password' WHERE _email = '$_user_email_address' AND _password = '$up_old_password'";
                $IsUserUpdated = $con->query($UpdateUser);

                if ($IsUserUpdated) {
                    array_push($message, "Account Password Updated Successfully.");
                }else{
                    array_push($message, "Error 401! Password Error.");
                }
            }else{
                array_push($message, "Error 402! Password Incorrect.");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Update Account Password - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="/assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->

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
                        <div class="breadcrumb-item">Update <span class="show-bg">Account</span> Password</div>
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
                        <div class="form-group">
                            <label for="inputAddress2">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="n-p" name="new-password" value="" placeholder="Enter New Password...">
                                <div class="input-group-append" title data-toggle="tooltip" data-placement="left" data-original-title="Toggle Password Visibility">
                                    <div class="input-group-text">
                                        <i class="fa fa-eye eye-fa"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="c-p" name="confirm-password" value="" placeholder="Retype New Password...">
                                <div class="input-group-append" title data-toggle="tooltip" data-placement="left" data-original-title="Toggle Password Visibility">
                                    <div class="input-group-text">
                                        <i class="fa fa-eye eye-fa"></i>
                                    </div>
                                </div>
                            </div><br>
                            <span style="font-size: 15px;color:red;" id="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-updates" name="update">Update Password</button>
                        </div>
                    </form>
                    </div>
                </div>
            </section>
        </div>
        <style>
        
        </style>

        <!-- Start app Footer part -->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="/assets/bundles/lib.vendor.bundle.js"></script>
<script src="/js/CodiePie.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->
<script>
    $(".input-group-append").click(function(){
        var x = document.getElementById("o-p");
        var y = document.getElementById("n-p");
        var z = document.getElementById("c-p");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
            z.type = "text";
            $(".eye-fa").removeClass("fa-eye");
            $(".eye-fa").addClass("fa-eye-slash");
        } else {
            x.type = "password";
            y.type = "password";
            z.type = "password";
            $(".eye-fa").addClass("fa-eye");
            $(".eye-fa").removeClass("fa-eye-slash");
        }
    });

    $("#c-p").keyup(function(){

        var x = document.getElementById("o-p");
        var y = $("#n-p").val();
        var z = $("#c-p").val();
        var errorMessage = document.getElementById("errorMessage");
        var submitBtn = $(".btn-updates");
        
        if (z != y) {
            errorMessage.style.color = "red";
            errorMessage.innerHTML = "***Passwords don't match &#10008;";
            submitBtn.disabled = true;
            submitBtn.addClass("disabled");
            return false;
        }else{
            errorMessage.style.color = "green";
            errorMessage.innerHTML = "***Passwords match &check;";
            submitBtn.disabled = false;
            submitBtn.removeClass("disabled");
            return true;
        };
    });
</script>
<!-- Template JS File -->
<script src="/js/scripts.js"></script>
<script src="/js/custom.js"></script>
</body>

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
</html>
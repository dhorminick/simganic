<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    if (isset($_SESSION['loggedin'])) {
        header('Location: /');    
    }

    $message = [];

    if (isset($_POST["sign-in"])) {
        $emailaddress = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if ($emailaddress == null && $password == null) {
            array_push($message, "Email Address and Password Error.");
        }else{
            //filter strings
            $emailaddress = htmlspecialchars(strip_tags($emailaddress));
            $password = md5(sha1(htmlspecialchars(strip_tags($password))));

            $CheckIfUserExist = "SELECT * FROM _users WHERE _email = '$emailaddress' AND _password = '$password'";
            $UserExist = $con->query($CheckIfUserExist);
            if ($UserExist->num_rows > 0) {
                //user exist
                $row = mysqli_fetch_array($UserExist);
                $username = $row["_username"];
                $firstname = $row["_firstname"];
                $lastname = $row["_lastname"];
                $phone1 = $row["_phone"];
                $verified = $row["isverified"];

                if ($verified === "0") {
                    array_push($message, "<i class='fa fa-cancel'></i> Email Address Not Verified.");
                    array_push($message, "Login To Email Account To Confirm Your Email Address.");
                }else{
                    array_push($message, "Login Successful.");

                    # set sessions
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['email'] = $emailaddress;
                    $_SESSION['username'] = $username;
                    $_SESSION['firstname'] = $firstname;
                    $_SESSION['lastname'] = $lastname;
                    $_SESSION['phone'] = $phone1;

                    # unset random sessions from reset password and sign up pages
                    if ($_SESSION['login_email'] && $_SESSION['login_password']) {
                        unset($_SESSION['login_email']);
                        unset($_SESSION['login_password']);
                    }elseif ($_SESSION["reset-email"] && $_SESSION["reset-password"]) {
                        unset($_SESSION["reset-email"]);
                        unset($_SESSION["reset-password"]);
                    }else{}

                    if (isset($_GET["redirect"])) {
                        $prevUrl = $_GET["redirect"];
                        header("Location: $prevUrl");
                    }else{
                        header("Location: /");
                    }            
                }
            }else{
                //user dows not exist
                array_push($message, "Email and Password Combination Does Not Exist.");
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Sign In To Your Account - SimGanic</title>

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
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email Address..." value="<?php if (isset($_SESSION['login_email'])) { echo $_SESSION['login_email']; } if (isset($_SESSION['reset-email'])) { echo $_SESSION['reset-email']; } ?>" required="">
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
                                        <input type="password" class="form-control" name="password" id="password" value="<?php if (isset($_SESSION['login_password'])) { echo $_SESSION['login_password']; } if (isset($_SESSION['reset-password'])) { echo $_SESSION['reset-password']; } ?>" placeholder="Enter Password">
                                        <div class="input-group-append" title data-toggle="tooltip" data-placement="left" data-original-title="Toggle Password Visibility">
                                            <div class="input-group-text">
                                                <i class="fa fa-eye eye-fa"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="csrfToken" value="">
                                <div class="">
                                    <input type="checkbox" name="remember">
                                    <label for="remember">Remember Me</label>
                                    <a href="forgot-password" class="show-sm" style="float:right !important;">Forgot Your Password?</a>
                                </div>
                            </div>
                            <div class="card-footer pt-">
                                <button type="submit" name="sign-in" class="btn-primary btn btn-form">Sign In</button>
                                <span class="ml-2">Don't Have An Account Yet, <a href="sign-up">Register?</a></span>
                                <span class="show-bg"><br><br>
                                <a href="forgot-password">Forgotten Your Password?</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        !-- Start app Footer part -->
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
<?php
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    session_start();

    $message = [];

    if (!isset($_SESSION['loggedin'])) {
        header("Location: sign-in?redirect=cart");
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
        //include '_layout/_user_details.php';
    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;

    $sqli = "SELECT sum(_no_products * (_price * '$user_selected_currency_conversion_to_naira_rate')) AS total FROM _allcarts WHERE _emailaddress = '$_user_email_address'";
    $sqliResult = $con->query($sqli);
    foreach ($con->query($sqli) as $row) {
        if ($sqliResult->num_rows > 0) {
            $checkout = true;
            $total = $row["total"];
            $total_in_user_currency = $total;
        }else{
            $checkout = false;
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Process Payment &mdash; SimGanic</title>

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
                    <h1>Blank Page</h1>
                </div>

                <div class="section-body">
                    <form action="" method="get" class="form-group">
                        <input type="text" id="input-" value="<?php echo $total; ?>" class="form-control"><br>
                        <button class="btn btn-primary" id="btn-submit">SUBMIT</button>
                    </form>
                </div>
                <script>
                    var total = "<?php echo $total; ?>";
                    alert(total);
                    $("#btn-submit").click(function(){
                        $("#input-").val(total);
                    });
                </script>
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
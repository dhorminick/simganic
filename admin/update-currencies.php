<?php
    session_start();
    include '_layout/_dbconnection.php';
    $errors = [];
    
    
    if (!isset($_SESSION['admin_loggedin'])) {
        header('Location: sign-in?redirect=update-currencies');    
    }

    if (isset($_POST["upload-currency"])) {
        $currency_name = $_POST["currency_name"];
        $currency_value = $_POST["currency_value"];
        $currency_symbol = $_POST["currency_symbol"];
        
        $InsertCurrency = "INSERT INTO _currency (_currency_name, _value, _symbol) VALUES ('$currency_name', '$currency_value' , '$currency_symbol')";
        $vaildresponse = mysqli_query($con, $InsertCurrency) or die(mysqli_error($con));
        if ($vaildresponse) {
            array_push($errors, "Currency Registered Succesfully.");
        }else{
            array_push($errors, "Currency <b>NOT</b> Registered Succesfully.");
        }
    }

    if (isset($_POST["update-currency"])) {
        $newcurrency_name = $_POST["currencyname"];
        $newcurrency_value = $_POST["_currencylink"];
        
        $UpdateCurrency = "UPDATE _currency SET currency_name = '$newcurrency_name', _value = '$newcurrency_value' WHERE _currency_name = '$newcurrency_name'";
        $UpdateCurrencysResult = $con->query($UpdateCurrency);
        if ($UpdateCurrencysResult) {
            array_push($errors, "Currency Updated Succesfully.");
        }else{
            array_push($errors, "Currency <b>NOT</b> Updated Succesfully.");
        }
    }

    $prods = "No Currency(s) Selected.";

    if (isset($_POST["SearchCurrency"])) {
        $currency = $_POST["_currencyname"];
        //Get More currencys Based On Category
        $GetCurrencyies = "SELECT * FROM _currency WHERE _currency_name = '$currency'";
        $GetCurrencyiesResult = $con->query($GetCurrencyies);

        if ($GetCurrencyiesResult->num_rows > 0) {
            // output data of each row
            $row = $GetCurrencyiesResult->fetch_assoc();
            $_currency_name = $row["_currency_name"];
            $_currency_value = $row["_value"];
            $_currency_symbol = $row["_symbol"];
            

            $prods = "
                <div class='form-row'>
                                        <div class='form-group col-md-6'>
                                            <label for='inputEmail4'>Currency Name</label>
                                            <input type='text' class='form-control' id='inputEmail4' value='$_currency_name' name='currency_name' placeholder='Currency Name (NGN, USD...)'>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <label for='inputPassword4'>Currency Value (Currency => Naira Rate)</label>
                                            <input type='number' class='form-control' id='inputPassword4' value='$_currency_value' name='currency_value' placeholder='Currency Value (1, 2.5...)'>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <label for='inputPassword4'>Currency Symbol</label>
                                            <input type='text' class='form-control' id='inputPassword4' value='$_currency_symbol' name='currency_symbol' placeholder='Currency Name (&dollar;, &#8358;...)'>
                                        </div>
                                    </div>
            ";

                                
        } else {
                                
        }
    }else{
        $prods = "No Currency(s) Selected.";
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Update Currencies &mdash; SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/select2/dist/css/select2.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/components.min.css">
</head>

<body class="layout-4">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <!--header-->
        <?php 
            include '_layout/_header_sidebar_admin.php';
        ?>
        <!--header-->

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Upload New Currencies</h1>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="card col-12 col-md-6 col-lg-12">
                                <form action="currency" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                <?php if (count($errors) > 0) : ?>
                                  <div class="msg">
                                  
                                    <?php foreach ($errors as $error) : ?>
                                      <span><?php echo $error ?></span>
                                      <style>
                                      .msg {
                                        margin: 5px auto;
                                        border-radius: 5px;
                                        border: 1px solid #563d7c;
                                        background: #563d7c;
                                        text-align: left;
                                        color: white;
                                        font-family: inherit;
                                        font-weight: bold;
                                        padding: 10px;
                                      }
                                  </style>
                                    <?php endforeach ?>
                                  </div>
                                  
                                <?php endif ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Currency Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" name="currency_name" placeholder="Currency Name (NGN, USD...)">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Currency Value (Currency => Naira Rate)</label>
                                            <input type="number" class="form-control" id="inputPassword4" name="currency_value" placeholder="Currency Value (1, 2.5...)">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Currency Symbol</label>
                                            <input type="text" class="form-control" id="inputPassword4" name="currency_symbol" placeholder="Currency Name (&dollar;, &#8358;...)">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit" name="upload-currency">UPLOAD CURRENCY</button>
                                </div>
                                </form>
                        </div>

                        <div class="form-group col-md-12">
                            <h1>Update Currencies</h1>
                        </div>

                        <div class="card col-12 col-md-6 col-lg-12">
                                
                                <div class="card-body">
                                    <form method="POST" action="">
                                    <div class="form-row">
                                        <div class="form-group search-box col-md-9">
                                            <label for="inputEmail4">Search Currency</label>
                                            <input type="text" class="form-control" name="_currencyname" placeholder="Currency Name" autocomplete="off">
                                            <div class="result"></div>
                                        </div>
                                        <div style="margin-top:30px !important;">
                                            <button class="btn btn-primary" name="SearchCurrency" type="submit">SEARCH</button>
                                        </div>
                                        <style>
                                            /* Formatting result items */
                                            .result{
                                                
                                            }
                                            
                                            /* Formatting result items */
                                            .result p{
                                                margin-bottom: 10px;
                                                padding: 10px;
                                                border: 1px solid #563d7c;
                                                cursor: pointer;
                                                background: #f2f2f2;
                                            }
                                            .result p:hover{
                                                background: #563d7c;
                                                color: white;
                                            }
                                        </style>
                                    </div>
                                </form>  
                                <form action="" method="POST" enctype="multipart/form-data" id="UpdateCurrency"> 
                                    <?php echo $prods;?>
                                </form>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit" name="update-currency">UPDATE CURRENCY</button>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Start app Footer part -->
        <?php 
            include '_layout/_footer.php';
        ?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->

<script src="assets/modules/select2/dist/js/select2.full.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/forms-advanced-forms.js"></script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>

</body>

</html>
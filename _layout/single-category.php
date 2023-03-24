<?php
    //dbconn
    require '_dbconnection.php';
    
    $errors = [];

    //$page_product_category = "Dairy";

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    include '_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title><?php echo $page_product_category;?> Products - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="/assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="/assets/modules/izitoast/css/iziToast.min.css">

<!-- Template CSS -->
<link rel="stylesheet" href="/assets/css/style.min.css">
<link rel="stylesheet" href="/assets/css/components.min.css">
<link rel="stylesheet" href="/assets/css/mystyle.css">
</head>

<body class="layout-1">
<!-- Page Loader -->
<div class="page-loder-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        
        <?php include '_header_sidebar.php';?>
        
        <?php
            $ProductsExist = "SELECT * FROM product_details WHERE product_category = '$page_product_category'";
            $ProductsExistResult = $con->query($ProductsExist);
            if ($ProductsExistResult->num_rows > 0) {
        ?>
        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1><?php echo $page_product_category;?> Products:</h1>
                </div>

                <div class="section-body">
                    <span class="show-bg"><h5><i class="fa fa-hashtag"></i> Fresly Added <?php echo $page_product_category;?> Products</h5></span>
                    <span class="show-sm"><h6><i class="fa fa-hashtag"></i> Fresly Added <?php echo $page_product_category;?> Products</h6></span>
                    <div class="row">
                    <?php
                        $GetNewProductDetails = "SELECT * FROM product_details WHERE product_category = '$page_product_category' ORDER BY _timestamp DESC LIMIT 4";
                        $NewProductDetailsResult = $con->query($GetNewProductDetails);

                        while ($NewProductRow = mysqli_fetch_assoc($NewProductDetailsResult)) {
                            if ($NewProductDetailsResult->num_rows > 0) {
                                $pname = $NewProductRow["product_name"];
                                $pid = $NewProductRow["product_id"];
                                $pcategory = $NewProductRow["product_category"];
                                $pimg = $NewProductRow["product_img"];
                                $pprices = $NewProductRow["product_prices"];
                                $plink = $NewProductRow["product_link"];
                                $pavailable = $NewProductRow["products_available"];
                                $p_prices = unserialize($pprices);

                                $GetCart250ml = "SELECT * FROM _allcarts WHERE _product_id = '$pid' AND _size = '250ml'";
                                $CartDetails250ml = $con->query($GetCart250ml);
                                if ($CartDetails250ml->num_rows > 0) {
                                    $row = mysqli_fetch_assoc($CartDetails250ml);
                                    $noProducts250ml = $row["_no_products"];
                                }

                                $GetCart500ml = "SELECT * FROM _allcarts WHERE _product_id = '$pid' AND _size = '500ml'";
                                $CartDetails500ml = $con->query($GetCart500ml);
                                if ($CartDetails500ml->num_rows > 0) {
                                    $row = mysqli_fetch_assoc($CartDetails500ml);
                                    $noProducts500ml = $row["_no_products"];
                                }

                                $new_pprice250ml = floatval($p_prices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $new_pprice500ml = floatval($p_prices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                                
                                $savings = (((intval($new_pprice250ml) * 2) - intval($new_pprice500ml)) / (intval($new_pprice250ml) * 2) * 100);

                            } else {
                                //error in product category 
                                header("Location: 404");
                                exit();
                                
                            }
                    ?>
                        <div class="col-6 col-md-3 col-lg-3 prod-div">
                            <article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="/assets/img/products/<?php echo $pimg; ?>">
                                        <div class="poke-div">NEW</div>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <center>
                                    <div class="article-category"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="article-title">
                                        <h2><a href="/products/<?php echo $plink; ?>/"><?php echo $pname; ?></a></h2>
                                    </div>
                                    <div><strong><?php echo $currency_symbol." ".$p_prices["250ml"]." - ".$currency_symbol." ".$p_prices["500ml"]; ?></strong></div>
                                    <div class="article-user">
                                        <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                    </center>
                                </div>
                            </article>
                        </div>
                    <?php }?>
                    </div>
                    <span class="show-bg"><h5><i class="fa fa-hashtag"></i> All <?php echo $page_product_category;?> Products</h5></span>
                    <span class="show-sm"><h6><i class="fa fa-hashtag"></i> All <?php echo $page_product_category;?> Products</h6></span>
                    <div class="row">
                    <?php
                        $GetAllProductDetails = "SELECT * FROM product_details WHERE product_category = '$page_product_category'";
                        $AllProductDetailsResult = $con->query($GetAllProductDetails);

                        while ($AllProductRow = mysqli_fetch_assoc($AllProductDetailsResult)) {
                            if ($AllProductDetailsResult->num_rows > 0) {
                                $_pname = $AllProductRow["product_name"];
                                $_pid = $AllProductRow["product_id"];
                                $_pcategory = $AllProductRow["product_category"];
                                $_pimg = $AllProductRow["product_img"];
                                $_pprices = $AllProductRow["product_prices"];
                                $_plink = $AllProductRow["product_link"];
                                $_pavailable = $AllProductRow["products_available"];
                                $_p_prices = unserialize($_pprices);

                                $_pprice250ml = floatval($_p_prices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $_pprice500ml = floatval($_p_prices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                                
                                $_savings = (((intval($_pprice250ml) * 2) - intval($_pprice500ml)) / (intval($_pprice250ml) * 2) * 100);

                            } else {
                                //error in product category 
                                header("Location: 404");
                                exit();
                                
                            }
                    ?>
                        <div class="col-6 col-md-3 col-lg-3 prod-div">
                            <article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="/assets/img/products/<?php echo $_pimg; ?>"></div>
                                </div>
                                <div class="article-details">
                                    <center>
                                    <div class="article-category"><a href="/products/category/<?php echo strtolower($_pcategory); ?>/"><?php echo $_pcategory; ?></a></div>
                                    <div class="article-title">
                                        <h2><a href="/products/<?php echo $_plink; ?>/"><?php echo $_pname; ?></a></h2>
                                    </div>
                                    <div><strong><?php echo $currency_symbol." ".$_p_prices["250ml"]." - ".$currency_symbol." ".$_p_prices["500ml"]; ?></strong></div>
                                    <div class="article-user">
                                        <a href="/products/<?php echo $_plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                    </center>
                                </div>
                            </article>
                        </div>
                    <?php }?>
                    </div>
                </div>

            </section>
        </div>
        <?php }else{ ?>

        <!-- Start app main Content -->
        <div class="main-content" style="margin-bottom:-70px !important;">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div style="width:100%;text-align:center !important;">
                                        <h3>PRODUCT COMING SOON</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="empty-state" data-height="400">
                                        <div class="empty-state-icon"><i class="fa fa-parachute-box"></i></div>
                                        <h2><?php echo $page_product_category;?> Products Not Added Yet!</h2>
                                        <p class="lead">Page will be updated once products have been added.</p>
                                        <a href="/" class="btn btn-primary mt-4"><i class="fa fa-arrow-left"></i> Back To Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php } ?>
        <!-- Start app Footer part -->
        <?php include '_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="/assets/bundles/lib.vendor.bundle.js"></script>
<script src="/js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="/js/page/bootstrap-modal.js"></script>
<script src="/js/page/modules-toastr.js"></script>
<script src="/assets/modules/izitoast/js/iziToast.min.js"></script>

<!-- Page Specific JS File -->


<!-- Template JS File -->
<script src="/js/scripts.js"></script>
<script src="/js/custom.js"></script>
</body>

</html>
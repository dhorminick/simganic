<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    
    $errors = [];

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;

    if (isset($_GET["sort"])){
        $sortHeader = strip_tags($_GET["sort"]);

        if (isset($_GET["pref"])){
            $prefHeader = strip_tags($_GET["pref"]);
            //$prefHeader = str_replace("-"," ",$prefHeader);
        }else{
            $prefHeader = "";
        }

    }else{
        $sortHeader = "Default Sorting";
        $prefHeader = "";
        
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sort Products "<?php echo 'By '.$sortHeader;if ($prefHeader != "") {echo " : ".$prefHeader; }?>" &mdash; SimGanic</title>

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
                    <div class="section-header-breadcrumb" style="margin-left: auto;">
                        <div class="breadcrumb-item active"><a href="/">Home</a></div>
                        <div class="breadcrumb-item">Sort Products</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="div-sort-by row" style="margin-top:40px;margin-bottom:20px;">
                        <div class="col-lg-6 col-md-6" style="text-align:left !important;">
                            <span class="show-sm">
                                <h6>
                                    <i class="fa fa-hashtag"></i> <?php echo ucwords(str_replace("-"," ",$sortHeader));if ($prefHeader != "") {if($prefHeader === "highest-to-lowest"){$prefHeader_sm = 'Highest'; $prefFollow = '<i class="fa fa-arrow-down"></i>';}elseif($prefHeader === "lowest-to-highest"){$prefHeader_sm = 'Lowest'; $prefFollow ='<i class="fa fa-arrow-up"></i>';}else{$prefHeader_sm = null; $prefFollow = null;} echo " : ".ucwords(str_replace("-"," ",$prefHeader_sm))." ".$prefFollow; }?>
                                </h6>
                            </span>
                            <span class="show-bg">
                                <h5>
                                    <i class="fa fa-hashtag"></i> Sorted By "<?php echo str_replace("-"," ",$sortHeader);if ($prefHeader != "") {echo " : ".$prefHeader; }?>"
                                </h5>
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 sort-main-div">
                            <h6>Sort By 
                            <div class="dropdown d-inline mr-2" style="margin-left:10px;">
                                <button class="btn btn-primary dropdown-toggle btn-sort-by" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default Sorting
                                </button>
                                <div class="dropdown-menu drop-menu-edit">
                                    <a class="dropdown-item" href="sort?sort=price&pref=lowest-to-highest"><strong>Price:</strong> Lowest To Highest</a>
                                    <a class="dropdown-item" href="sort?sort=price&pref=highest-to-lowest"><strong>Price:</strong> Highest To Lowest</a>
                                    <a class="dropdown-item" href="sort?sort=popularity"><strong>Ratings Popularity</strong></a>
                                    <a class="dropdown-item" href="sort?sort=freshly-added"><strong>Freshly Added</strong></a>
                                </div>
                            </div></h6>
                        </div>
                    </div>
                    <style>
                        .section .section-title {
                            margin: 0 !important;
                        }
                        .dropdown-menu.drop-menu-edit{
                            transform: translate3d(-62px, 28px, 0px) !important;
                            z-index: 1000;
                        }
                        @media screen and (max-width: 1000px) {
                            .sort-main-div{
                                padding-right: 0px;
                                margin-top: -36px !important;
                            }

                        }
                        .sort-main-div{
                            text-align:right;
                        }
                    </style>
                    <div class="row">
                    <?php
                        //attempted pagination
                        if (isset($_GET['page']) && $_GET['page']!="") {
                            $page = trim(strip_tags($_GET['page']));
                            if (!filter_var($page, FILTER_VALIDATE_INT) === false) {
                                
                            } else {
                                $page = 1;
                            }
                        } else {
                            $page = 1;
                        }

                        $total_records_per_page = 16;
                        $offset = ($page-1) * $total_records_per_page;
                        $previous_page = $page - 1;
                        $next_page = $page + 1;
                        $adjacents = "2"; 

                        $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `product_details`");
                        $total_records = mysqli_fetch_array($result_count);
                        $total_records = $total_records['total_records'];
                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                        $second_last = $total_no_of_pages - 1; // total page minus 1

                        if ( isset($_GET["sort"]) || isset($_GET["sort"]) && isset($_GET["pref"])){
                                $sort = strip_tags($_GET["sort"]);
                                $sortPgCount = "sort=$sort";
                                if (isset($_GET["pref"])){
                                    $pref = strip_tags($_GET["pref"]);
                                    $prefPgCount = "pref=$pref";
                                    $prefBefore = "&";
                                }else{
                                    $pref = "";
                                    $prefPgCount = null;
                                    $prefBefore = null;
                                }

                                /*ifs*/
                                 if($_GET["sort"] === "most-purchase" || $_GET["sort"] === "freshly-added" || $_GET["sort"] === "popularity" || $_GET["sort"] === "price" && $pref === "highest-to-lowest" || $_GET["sort"] === "price" && $pref === "lowest-to-highest" ){
                                    if ($sort === "most-purchase") {
                                        $GetAllProducts = "SELECT * FROM product_details ORDER BY id desc LIMIT $offset, $total_records_per_page";
                                    }elseif ($sort === "freshly-added") {
                                        $GetAllProducts = "SELECT * FROM product_details ORDER BY _timestamp asc LIMIT $offset, $total_records_per_page";
                                    }elseif ($sort === "popularity") {
                                        $GetAllProducts = "SELECT * FROM product_details ORDER BY product_rating desc LIMIT $offset, $total_records_per_page";
                                    }elseif ($sort === "price" && $pref === "lowest-to-highest") {
                                        $GetAllProducts = "SELECT * FROM product_details ORDER BY product_prices asc LIMIT $offset, $total_records_per_page";
                                    }elseif ($sort === "price" && $pref === "highest-to-lowest") {
                                        $GetAllProducts = "SELECT * FROM product_details ORDER BY product_prices desc LIMIT $offset, $total_records_per_page";
                                    }
                                }else{
                                    $GetAllProducts = "SELECT * FROM product_details LIMIT $offset, $total_records_per_page";
                                }
                                /**/

                                $AllProductDetails = $con->query($GetAllProducts);
                                while ($AllProductRow = mysqli_fetch_assoc($AllProductDetails)) {  

                                if ($AllProductDetails->num_rows > 0) {
                                    // output data of each row
                                    $pname = $AllProductRow["product_name"];
                                    $pid = $AllProductRow["product_id"];
                                    $pcategory = $AllProductRow["product_category"];
                                    $pimg = $AllProductRow["product_img"];
                                    $prating = $AllProductRow["product_rating"];
                                    $pno_reviews = $AllProductRow["product_no_reviews"];
                                    $plink = $AllProductRow["product_link"];
                                    $pprices = $AllProductRow["product_prices"];
                                    //$pprice = $AllProductRow["product_price"];
                                    $pavailable = $AllProductRow["products_available"];
                                } else {
                                    echo "Page Error!";
                                    exit();
                                } 
                                if (isset($_GET["sort"])) {
                                    if ($_GET["sort"] === "popularity") {
                                        if ($prating <= 0) {
                                            $_averagePercentage = 0;
                                        }else{
                                            $_averagePercentage = ($prating / 5) * 100;
                                        }
                                        $prod_rating = "<div><div class='star-rating'><span class='width-".$_averagePercentage."percent'></span></div></div>";

                                    }else{
                                        $prod_rating = null;
                                    }
                                }else{
                                    $prod_rating = null;
                                }

                                $AllbottlePrices = unserialize($pprices);
                                        
                                $price250ml = floatval($AllbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $price500ml = floatval($AllbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $savings = (((intval($price250ml) * 2) - intval($price500ml)) / (intval($price250ml) * 2) * 100);                                
                    ?>
                        <div class="col-6 col-md-3 col-lg-3 prod-div">
                            <a href="/products/<?php echo $plink; ?>/"><article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="assets/img/products/<?php echo $pimg; ?>">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <center>
                                    <div class="article-category"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="article-title">
                                        <h2><a href="/products/<?php echo $plink; ?>/"><?php echo $pname; ?></a></h2>
                                    </div>
                                    <div><strong><?php echo "$currency_symbol".$price250ml ." - ". "$currency_symbol".$price500ml; ?></strong></div>
                                    <?php echo $prod_rating;?>
                                    <div class="article-user">
                                        <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage" style="color:white !important;">View Product</a>
                                    </div>
                                    </center>
                                </div>
                            </article></a>
                        </div>                                                                                                                       
                    <?php
                        }}else{
                                $GetAllProducts = "SELECT * FROM product_details LIMIT $offset, $total_records_per_page";

                                $AllProductDetails = $con->query($GetAllProducts);
                                while ($AllProductRow = mysqli_fetch_assoc($AllProductDetails)) {  

                                if ($AllProductDetails->num_rows > 0) {
                                    // output data of each row
                                    $pname = $AllProductRow["product_name"];
                                    $pid = $AllProductRow["product_id"];
                                    $pcategory = $AllProductRow["product_category"];
                                    $pimg = $AllProductRow["product_img"];
                                    $plink = $AllProductRow["product_link"];
                                    $pprices = $AllProductRow["product_prices"];
                                    //$pprice = $AllProductRow["product_price"];
                                    $pavailable = $AllProductRow["products_available"];
                                } else {
                                    echo "Page Error!";
                                    exit();
                                } 

                                $AllbottlePrices = unserialize($pprices);
                                        
                                $price250ml = floatval($AllbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $price500ml = floatval($AllbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                    ?>
                        <div class="col-6 col-md-3 col-lg-3 prod-div">
                            <a href="/products/<?php echo $plink; ?>/"><article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="assets/img/products/<?php echo $pimg; ?>">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <center>
                                    <div class="article-category"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="article-title">
                                        <h2><a href="/products/<?php echo $plink; ?>/"><?php echo $pname; ?></a></h2>
                                    </div>
                                    <div><strong><?php echo "$currency_symbol".$price250ml ." - ". "$currency_symbol".$price500ml; ?></strong></div>
                                    <div class="article-user">
                                        <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage" style="color:white !important;">View Product</a>
                                    </div>
                                    </center>
                                </div>
                            </article></a>
                        </div>
                    <?php }} ?>
                    </div>

                    <hr>
                    <center>
                        <h6 class="h6-paginaton">Page <?php echo $page." of ".$total_no_of_pages; ?></h6>
                        <div class="paginaton w-100 show-bg">

                            <?php if (isset($_GET['sort'])) {$get = "?$sortPgCount$prefBefore$prefPgCount&";} else {$get = "?";} // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                            
                            <a class="" <?php if($page <= 1){ echo "disabled"; } ?> <?php if($page > 1){ echo "href='".$get."page=$previous_page'"; } ?>>&laquo; Previous</a>
                            
               
                            <?php 

                                if ($total_no_of_pages <= 10){       
                                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                        if ($counter == $page) {
                                       echo "<a class=' active'>$counter</a>";  
                                            }else{
                                       echo "<a class='' href='".$get."page=$counter'>$counter</a>";
                                            }
                                    }
                                }
                                elseif($total_no_of_pages > 10){
                    
                                    if($page <= 4) {         
                                        for ($counter = 1; $counter < 8; $counter++){       
                                            if ($counter == $page) {
                                                echo "<a class='active'>$counter</a>";  
                                            }else{
                                                echo "<a class='' href='".$get."page=$counter'>$counter</a>";
                                            }
                                        }
                                        echo "<a class=''>...</a>";
                                        echo "<a class='' href='".$get."page=$second_last'>$second_last</a>";
                                        echo "<a class='' href='".$get."page=$total_no_of_pages'>$total_no_of_pages</a>";
                                    } elseif($page > 4 && $page < $total_no_of_pages - 4) {         
                                        echo "<a class='' href='".$get."page=1'>1</a>";
                                        echo "<a class='' href='".$get."page=2'>2</a>";
                                        echo "<a class=''>...</a>";
                                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {         
                                           if ($counter == $page) {
                                           echo "<a  class='active '>$counter</a>";  
                                                }else{
                                           echo "<a class='' href='".$get."page=$counter'>$counter</a>";
                                                }                  
                                       }
                                       echo "<a class=''>...</a>";
                                       echo "<a class='' href='".$get."page=$second_last'>$second_last</a>";
                                       echo "<a class='' href='".$get."page=$total_no_of_pages'>$total_no_of_pages</a>";      
                                    } else {
                                        echo "<a class='' href='".$get."page=1'>1</a>";
                                        echo "<a class='' href='".$get."page=2'>2</a>";
                                        echo "<a class=''>...</a>";

                                        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                            if ($counter == $page) {
                                                echo "<a class='active '>$counter</a>";  
                                            }else{
                                                echo "<a class='' href='".$get."page=$counter'>$counter</a>";
                                            }                   
                                        }
                                    }
                                }
                            ?>
            
                            <!--<li class='page-item <?php if($page >= $total_no_of_pages){ echo "disabled"; } ?>'>
                            <a class='page-link' <?php if($page < $total_no_of_pages) { echo "href='?page=$next_page'"; } ?>>Next &raquo;</a>
                            </li>-->
                            <?php 
                                if($page < $total_no_of_pages){
                                    echo "<a class='' href='".$get."page=$total_no_of_pages'>Last &raquo;</a>";
                                } 
                            ?>
                        </div>
                        <div class="paginaton w-100 show-sm">

                            <?php if (isset($_GET['sort'])) {$get = "?$sortPgCount$prefBefore$prefPgCount&";} else {$get = "?";} // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                            
                            <a class="" <?php if($page <= 1){ echo "disabled"; } ?> <?php if($page > 1){ echo "href='".$get."page=$previous_page'"; } ?>>&laquo; Previous</a>
                            
               
                            <?php 
                                
                                if ($page < $total_no_of_pages) {
                                    echo "<a class='active'>$page</a>";
                                    echo "<a href='".$get."page=$next_page'>$next_page</a>";
                                }elseif ($page >= $total_no_of_pages){
                                    echo "<a class='active'>$page</a>";
                                }
                            ?>
                            
                            <a class='<?php if($page >= $total_no_of_pages){ echo "disabled"; } ?>' <?php if($page < $total_no_of_pages) { echo "href='".$get."page=$next_page'"; } ?>>Next &raquo;</a>
                        </div>
                    </center>
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
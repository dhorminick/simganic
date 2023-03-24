<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}

    $message = [];

    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];

    }

    include '_layout/_currency_converter.php';
    $currency_symbol = $user_selected_currency_symbol;

    if (isset($_GET["q"])) {
        $keyword = trim(strip_tags($_GET["q"]));
    }

    if (isset($_GET["filter"])){
        $filter = trim(strip_tags($_GET["filter"]));
        $hasFilter = "&filter=";
    }else{
        $filter = null;
        $hasFilter = null;
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php if (isset($_GET["q"])) {echo 'You Searched For "'.$keyword.'"';}else{echo "Search For Your Favourite Product";}?> &mdash; SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

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
                        <div class="breadcrumb-item">Search</div>
                    </div>
                </div>

                <div class="section-body">
                <span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span>
                    <?php
                        if (isset($_GET["q"]) && $keyword !== ""){
                            if ($filter === "most-purchase" || $filter === "freshly-added" || $filter === "popularity" || $filter === "price-highest-to-lowest" || $filter === "price-lowest-to-highest" ) {
                                if ($filter === "most-purchase") {
                                    $filterSql = "id DESC";
                                }elseif ($filter === "freshly-added") {
                                    $filterSql = "_timestamp DESC";
                                }elseif ($filter === "popularity") {
                                    $filterSql = "product_rating desc";
                                }elseif ($filter === "price-lowest-to-highest") {
                                    $filterSql = "product_prices ASC";
                                }elseif ($filter === "price-highest-to-lowest") {
                                    $filterSql = "product_prices DESC";
                                }
                            }else{
                                $filterSql = "_timestamp DESC";
                            }

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

                            $SearchDB = "SELECT * FROM product_details WHERE search_tags LIKE \"%$keyword%\" ORDER BY $filterSql LIMIT $offset, $total_records_per_page";
                            $SearchResult = $con->query($SearchDB);
                            if ($SearchResult->num_rows > 0) {
                    ?>
                    <div class="div-sort-by row" style="margin-top:40px;margin-bottom:20px;">
                        <div class="col-lg-6 col-md-6" style="text-align:left !important;">
                            <span class="show-sm"><h6><i class="fa fa-hashtag"></i> <?php echo $keyword;?><h6></span><span class="show-bg"><h5><i class="fa fa-hashtag"></i> Searched For: <?php echo $keyword;?></h5></span>
                        </div>
                        <div class="col-lg-6 col-md-6 sort-main-div">
                            <h6>Filter Search 
                            <div class="dropdown d-inline mr-2" style="margin-left:10px;">
                                <button class="btn btn-primary dropdown-toggle btn-sort-by" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default Filter
                                </button>
                                <div class="dropdown-menu drop-menu-edit2">
                                    <?php if (isset($_GET['q'])) {$f = "?q=$keyword&";} else {$f = "?";} ?>
                                    <a class="dropdown-item" href="<?php echo $f;?>filter=price-lowest-to-highest"><strong>Price:</strong> Lowest To Highest</a>
                                    <a class="dropdown-item" href="<?php echo $f;?>filter=price-highest-to-lowest"><strong>Price:</strong> Highest To Lowest</a>
                                    <a class="dropdown-item" href="<?php echo $f;?>filter=popularity"><strong>Ratings Popularity</strong></a>
                                    <a class="dropdown-item" href="<?php echo $f;?>filter=fresly-added"><strong>Freshly Added</strong></a>
                                </div>
                            </div></h6>
                        </div>
                    </div>
                    <div class="row">
                    <?php 
                        while($row = mysqli_fetch_assoc($SearchResult)){
                            $search_product_id = $row["product_id"];
                                $search_product_name = $row["product_name"];
                                $search_product_id = $row["product_id"];
                                $search_product_category = $row["product_category"];
                                $search_product_img = $row["product_img"];
                                $prating = $row["product_rating"];
                                $pno_reviews = $row["product_no_reviews"];
                                $search_product_prices = $row["product_prices"];
                                $search_product_link = $row["product_link"];
                                $search_product_available = $row["products_available"];

                                $SearchbottlePrices = unserialize($search_product_prices);
                                    
                                $SearchPrice250ml = floatval($SearchbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $SearchPrice500ml = floatval($SearchbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                                $SearchSavings = (((intval($SearchPrice250ml) * 2) - intval($SearchPrice500ml)) / (intval($SearchPrice250ml) * 2) * 100);

                                if (isset($_GET["filter"])) {
                                    if ($_GET["filter"] === "popularity") {
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

                                if (isset($_SESSION['loggedin'])) {
                                    $id = crc32($search_product_id);
                                    $IsSearchInWishlist = "SELECT * FROM _allwishlist WHERE _product_id = '$search_product_id' AND _emailaddress = '$_user_email_address'";
                                    $searchWishlistResult = $con->query($IsSearchInWishlist);
                                    if ($searchWishlistResult -> num_rows <= 0) {
                                        $search_wishlistBtn = '<button data-sku="'.$id.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                                    }else{
                                        $search_wishlistBtn = '<button data-sku="'.$id.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
                                    }

                                
                                }else{
                                    $search_wishlistBtn = '<button class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                                }
                    ?>

                    <div class="col-6 col-md-6 col-lg-3 prod-div">
                        <a href="/products/<?php echo $search_product_link; ?>/"><article class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image" data-background="assets/img/products/<?php echo $search_product_img; ?>"></div>
                            </div>
                            <div class="article-details">
                                <center>
                                <div class="article-category"><a href="/products/category/<?php echo strtolower($search_product_category); ?>/"><?php echo $search_product_category; ?></a></div>
                                <div class="article-title">
                                    <h2><a href="/products/<?php echo $search_product_link; ?>/"><?php echo $search_product_name; ?></a></h2>
                                </div>
                                <div><strong><?php echo "$currency_symbol".$SearchPrice250ml ." - ". "$currency_symbol".$SearchPrice500ml; ?></strong></div>
                                <?php echo $prod_rating;?>
                                <div class="article-user">
                                    <a href="/products/<?php echo $search_product_link; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    <?php echo $search_wishlistBtn; ?>
                                </div>
                                </center>
                            </div>
                        </article></a>
                    </div>

                    <?php } ?>
                    </div>
                    <hr>
                        <center>
                            <h6 class="h6-paginaton">Page <?php echo $page." of ".$total_no_of_pages; ?></h6>
                            <div class="paginaton w-100 show-bg">

                                <?php if (isset($_GET['q'])) {$get = "?q=$keyword$hasFilter$filter&";} else {$get = "?";} // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                                
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

                                <?php if (isset($_GET['q'])) {$get = "?q=$keyword$hasFilter$filter&";} else {$get = "?";} // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                                
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
                        <div class="row">
                    <?php }else{ ?>
                    <div class="no-result col-12 col-lg-12">
                        <center>
                            <div class="w_icon">
                                <i class="fa fa-exclamation-triangle" style="transform:none !important;"></i>
                            </div> <br>
                            <h4>Your Search "<?php echo $keyword; ?>" has no result.</h4>
                            <br><div>
                            - Check your spelling for spelling errors<br>
                            - Try searching with short and simple keywords
                            </div>
                            <br><div>
                                <a href="/all-products"><button class="btn btn-primary btn-back"><i class="fa fa-arrow-left"></i> All Products</button></a>
                            </div>
                        </center>
                    </div>
                    
                    <?php }}else{ ?>
                    

                    <!--end-->
                    <div class="row">
                        <form action="" method="get" class="col-lg-12">
                            <div class="search-element" style="display:flex;">
                                <input class="form-control header-search-box" name="q" type="search" placeholder="Search" aria-label="Search" style="color:#563d7c; !important;" required>
                                <button class="btn" type="submit" style="margin-left:4px;"><i class="fas fa-search"></i></button>
                            </div>
                        </form>                    
                    </div>
                    <?php } ?>
                    </div>
                    
                    <br><br>
                    <h5><span class="show-sm"><i class="fa fa-hashtag"></i> You May Like</span><span class="show-bg"><i class="fa fa-hashtag"></i> Products You May Like</span></h5>
                    <div class="owl-carousel owl-theme slider" id="fresh">
                        <?php
                            $GetNewProducts = "SELECT * FROM product_details ORDER BY _timestamp LIMIT 7";
                            $NewProductDetails = $con->query($GetNewProducts);

                            while ($NewProductRow = mysqli_fetch_assoc($NewProductDetails)) {  
                            if ($NewProductDetails->num_rows > 0) {
                                // output data of each row
                                $newpname = $NewProductRow["product_name"];
                                $newpid = $NewProductRow["product_id"];
                                $newpcategory = $NewProductRow["product_category"];
                                $newpimg = $NewProductRow["product_img"];
                                $newpprices = $NewProductRow["product_prices"];
                                $newplink = $NewProductRow["product_link"];
                                $newpavailable = $NewProductRow["products_available"];
                            } else {
                                echo "Page Error!";
                                exit();
                            }
                            $encodedPId = crc32($newpid);
                            $IsInWishlistNewProducts = "SELECT * FROM _allwishlist WHERE _product_id = '$newpid' AND _emailaddress = '$_user_email_address'";
                            $WishlistResultNewProducts = $con->query($IsInWishlistNewProducts);
                            if ($WishlistResultNewProducts -> num_rows <= 0) {
                                $wishlistBtnNp = '<button data-sku="'.$encodedPId.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                            }else{
                                $wishlistBtnNp = '<button data-sku="'.$encodedPId.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
                            }
                            if (!isset($_SESSION['loggedin'])) {
                                $wishlistBtnNp = '<button class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                            }

                            $NewbottlePrices = unserialize($newpprices);
                            $NewCount = unserialize($newpavailable);
                            $TotalNewCount = intval($NewCount['250ml']) + intval($NewCount['500ml']);
                            $newprice250ml = floatval($NewbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                            $newprice500ml = floatval($NewbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                            $savings = (((intval($newprice250ml) * 2) - intval($newprice500ml)) / (intval($newprice250ml) * 2) * 100);
                        ?>
                        <div>
                            <div class="p-">
                                <a href="/products/<?php echo $newplink; ?>/"><div class="p-image">
                                    <img alt="image" src="assets/img/products/<?php echo $newpimg; ?>" class="img-fluid">
                                </div></a>
                                <div class="p-details">
                                <center>
                                    <div class="p-category text-small"><a href="/products/category/<?php echo strtolower($newpcategory); ?>/"><?php echo $newpcategory; ?></a></div>
                                    <div class="p-name"><a href="/products/<?php echo $newplink; ?>/"><?php echo $newpname; ?></a></div>
                                    <div class="p-prices"><?php echo "$currency_symbol".$newprice250ml ." - ". "$currency_symbol".$newprice500ml; ?></div>
                                    <div class="view-p">
                                        <a href="/products/<?php echo $newplink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                    </div>
                                </center>
                                </div>  
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <br>

                </div>
            </section>
        </div>
        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>
<?php if (isset($_SESSION['loggedin'])) { ?>
<p id="response"></p>
<form class="update-wishlist">
    <input type="text" class="wishlist-sku" name="sku-value" value="">
    <button class="wishlist-btn">submit</button>
</form>
<?php }else{ ?>
<div id="wishlist-form">
    <center>
        <h6 style="margin-bottom:10px !important;">Sign In To Add Product To Wishlist.</h6>
        <a href="sign-in?redirect=all-products" class="btn btn-primary btn-cart-single"><i class="fa fa-arrow-left"></i> SIGN IN</a>
    </center>
</div>
<?php }?>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>

<script src="js/page/bootstrap-modal.js"></script>
<script src="js/page/modules-toastr.js"></script>


<!-- Page Specific JS File -->
<script type="text/javascript">
    <?php if (isset($_SESSION['loggedin'])) { ?>

    $(".btn-to-wishlist").click(function(){
        var sku = $(this).attr("data-sku");
        if (!sku || sku == "" || sku == null){

        }else{
            $(".wishlist-sku").val(sku);
            $(".wishlist-btn").click();
        }
    });

    $('.update-wishlist').on('submit', function (event){
        event.preventDefault();
        var formValues = $(this).serialize();

        $.post("_layout/_ajax.php", {updatewishlist: formValues}).done(function (data) {
        
        setTimeout(function(){ $("#response").load(" #response > *") }, 5000);
        //$(".n_wishlist_btn").load(" .n_wishlist_btn > *"); 
                                                  
        $("#response").html(data);
        });
    }); 
    
    <?php }else{ ?>

    $(".btn-to-wishlist").fireModal({
      title: '',
      footerClass: 'bg-whitesmoke',
      body: $("#wishlist-form"),
    });

    <?php } ?>

    $("#fresh").owlCarousel({
      items: 4,
      dots: false,
      stagePadding: 0,
      nav: true,
      navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      margin: 13,
      autoplay: true,
      autoplayTimeout: 4000,
      loop: false,
      responsive: {
        0: {
          items: 2
        },
        1200: {
          items: 4
        }
      }
    });
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
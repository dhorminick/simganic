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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>All Products List - SimGanic</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/components.min.css">
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
                        <div class="breadcrumb-item">All Products</div>
                    </div>
                </div>
                <div class="div-sort-by row" style="margin-top:40px;margin-bottom:20px;">
                    <div class="col-lg-6 col-md-6" style="text-align:left !important;">
                        <h5><span><i class="fa fa-hashtag"></i> <span class="show-bg">All </span>Products<span class="show-bg"> List</span></span></h5>
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
                <style>.article-user a{color: white !important;}</style>
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
                            $pavailable = $AllProductRow["products_available"];
                        } else {
                            echo "Page Error!";
                            exit();
                        }
                        $encodedPID = crc32($pid);
                        $IsInWishlist = "SELECT * FROM _allwishlist WHERE _product_id = '$pid' AND _emailaddress = '$_user_email_address'";
                        $WishlistResult = $con->query($IsInWishlist);
                        if ($WishlistResult -> num_rows <= 0) {
                            $wishlistBtn = '<button data-sku="'.$encodedPID.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }else{
                            $wishlistBtn = '<button data-sku="'.$encodedPID.'" class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Product Already In WishList"><i class="fa fa-heart-circle-check"></i></button>';
                        }
                        if (!isset($_SESSION['loggedin'])) {
                            $wishlistBtn = '<button class="btn btn-primary btn-wishlist-fpage btn-to-wishlist" title data-toggle="tooltip" data-placement="left" data-original-title="Add Product To WishList"><i class="fa fa-heart"></i></button>';
                        }

                        $AllbottlePrices = unserialize($pprices);
                        
                        $price250ml = floatval($AllbottlePrices['250ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $price500ml = floatval($AllbottlePrices['500ml']) * $user_selected_currency_conversion_to_naira_rate;
                        $savings = (((intval($price250ml) * 2) - intval($price500ml)) / (intval($price250ml) * 2) * 100);
                    ?>
                        
                        <div class="col-6 col-md-6 col-lg-3 prod-div">
                            <a href="/products/<?php echo $plink; ?>/"><article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="assets/img/products/<?php echo $pimg; ?>"></div>
                                </div>
                                <div class="article-details">
                                    <center>
                                    <div class="article-category"><a href="/products/category/<?php echo strtolower($pcategory); ?>/"><?php echo $pcategory; ?></a></div>
                                    <div class="article-title">
                                        <h2><a href="/products/<?php echo $plink; ?>/"><?php echo $pname; ?></a></h2>
                                    </div>
                                    <div><strong><?php echo "$currency_symbol".$price250ml ." - ". "$currency_symbol".$price500ml; ?></strong></div>
                                    <div class="article-user">
                                        <a href="/products/<?php echo $plink; ?>/" class="btn btn-primary btn-cart-fpage">View Product</a>
                                        <?php echo $wishlistBtn; ?>
                                    </div>
                                    </center>
                                </div>
                            </article></a>
                        </div>
                    <?php }?>

                </div>
                <hr>
                <center>
                <h6 class="h6-paginaton">Page <?php echo $page." of ".$total_no_of_pages; ?></h6>
                <div class="paginaton w-100 show-bg">

                    <?php // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                    
                    <a class="" <?php if($page <= 1){ echo "disabled"; } ?> <?php if($page > 1){ echo "href='?page=$previous_page'"; } ?>>&laquo; Previous</a>
                    
       
                    <?php 

                        if ($total_no_of_pages <= 10){       
                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                if ($counter == $page) {
                               echo "<a class=' active'>$counter</a>";  
                                    }else{
                               echo "<a class='' href='?page=$counter'>$counter</a>";
                                    }
                            }
                        }
                        elseif($total_no_of_pages > 10){
            
                            if($page <= 4) {         
                                for ($counter = 1; $counter < 8; $counter++){       
                                    if ($counter == $page) {
                                        echo "<a class='active'>$counter</a>";  
                                    }else{
                                        echo "<a class='' href='?page=$counter'>$counter</a>";
                                    }
                                }
                                echo "<a class=''>...</a>";
                                echo "<a class='' href='?page=$second_last'>$second_last</a>";
                                echo "<a class='' href='?page=$total_no_of_pages'>$total_no_of_pages</a>";
                            } elseif($page > 4 && $page < $total_no_of_pages - 4) {         
                                echo "<a class='' href='?page=1'>1</a>";
                                echo "<a class='' href='?page=2'>2</a>";
                                echo "<a class=''>...</a>";
                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {         
                                   if ($counter == $page) {
                                   echo "<a  class='active '>$counter</a>";  
                                        }else{
                                   echo "<a class='' href='?page=$counter'>$counter</a>";
                                        }                  
                               }
                               echo "<a class=''>...</a>";
                               echo "<a class='' href='?page=$second_last'>$second_last</a>";
                               echo "<a class='' href='?page=$total_no_of_pages'>$total_no_of_pages</a>";      
                            } else {
                                echo "<a class='' href='?page=1'>1</a>";
                                echo "<a class='' href='?page=2'>2</a>";
                                echo "<a class=''>...</a>";

                                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                    if ($counter == $page) {
                                        echo "<a class='active '>$counter</a>";  
                                    }else{
                                        echo "<a class='' href='?page=$counter'>$counter</a>";
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
                            echo "<a class='' href='?page=$total_no_of_pages'>Last &raquo;</a>";
                        } 
                    ?>
                </div>
                <div class="paginaton w-100 show-sm">

                    <?php // if($page > 1){ echo "<li><a href='?page=1'>First Page</a></li>"; } ?>
                    
                    <a class="" <?php if($page <= 1){ echo "disabled"; } ?> <?php if($page > 1){ echo "href='?page=$previous_page'"; } ?>>&laquo; Previous</a>
                    
       
                    <?php 
                        
                        if ($page < $total_no_of_pages) {
                            echo "<a class='active'>$page</a>";
                            echo "<a href='?page=$next_page'>$next_page</a>";
                        }elseif ($page >= $total_no_of_pages){
                            echo "<a class='active'>$page</a>";
                        }
                    ?>
                    
                    <a class='<?php if($page >= $total_no_of_pages){ echo "disabled"; } ?>' <?php if($page < $total_no_of_pages) { echo "href='?page=$next_page'"; } ?>>Next &raquo;</a>
                </div>
                </center>

                <p id="response"></p>
                <span id="toastr-9"></span><span id="toastr-10"></span><span id="toastr-11"></span><span id="toastr-12"></span><span id="toastr-13"></span><span id="toastr-14"></span><span id="toastr-15"></span><span id="toastr-16"></span><span id="toastr-17"></span><span id="toastr-18"></span><span id="toastr-19"></span>
                <?php if (isset($_SESSION['loggedin'])) { ?>
                <form class="update-wishlist" style="display:none;">
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
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>

<!-- Page Specific JS File -->

<script src="js/page/bootstrap-modal.js"></script>
<script src="js/page/modules-toastr.js"></script>

<script type="text/javascript">

    /*$(".btn-to-cart").fireModal({
      title: 'Please Select Bottle Size',
      footerClass: 'bg-whitesmoke',
      body: $("#to-cart"),
      buttons: [
        {
          text: 'Add Item(s) To Cart',
          class: 'btn btn-primary btn-shadow btn-add-to-cart',
          id: 'update-cart',
          handler: function(modal) {
          }
        }]
    });
    
    $('.update-cart').on('submit', function (event){
        
        event.preventDefault();

        var formValues = $(this).serialize();

        //$("#update-cart-form button").prop('disabled', true);
        //$(".btn-form-cart").prop('disabled', true);

        $.post("_layout/_ajax.php", {updatecart: formValues}).done(function (data) {
        //Display the returned data in browser
        //var x = document.getElementById("response");
        //x.className = "show";
        //setTimeout(function(){ 
            //x.className = x.className.replace("show", "");
            //$("#update-cart-form button").prop('disabled', false);
            //$(".btn-form-cart").prop('disabled', false);
            //$(".num").load(" .num > *");
            //$(".item-count").load(" .item-count > *");
        //}, 1000);
        setTimeout(function(){ $("#response").load(" #response > *") }, 5000);
        //$(".num_count").load(" .num_count > *"); 
        //$(".num_count_form").load(" .num_count_form > *");                                          
        $("#response").html(data);
        });                            

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

    $(".btn-to-cart").click(function(){
        
        var data_sku = $(this).attr("data-sku");
        var data_price_small = $(this).attr("data-price-small");
        var data_price_big = $(this).attr("data-price-big");
        var data_savings = $(this).attr("data-save-percent");
        var data_currency = $(this).attr("data-curr");

        

        if (!data_sku || data_sku == "" || data_sku == null || !data_price_small || data_price_small == "" || data_price_small == null || !data_price_big || data_price_big == "" || data_price_big == null || !data_savings || data_savings == "" || data_savings == null) {
            alert("Error 401");
            window.location.reload();
        }else{
            $(".price-big").text(data_price_big);
            $(".price-small").text(data_price_small);
            $(".savings").text(data_savings);
            $(".curr").text(data_currency);
            $(".data-sku-val").val(data_sku);
        };
    });*/
    <?php if (isset($_SESSION['loggedin'])) { ?>
    $(".btn-to-wishlist").click(function(){
        var sku = $(this).attr("data-sku");
        if (!sku || sku == "" || sku == null){

        }else{
            $(".wishlist-sku").val(sku);
            $(".wishlist-btn").click();
        }
    });
    <?php }else{ ?>

    $(".btn-to-wishlist").fireModal({
      title: '',
      footerClass: 'bg-whitesmoke',
      body: $("#wishlist-form"),
    });

    <?php } ?>
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
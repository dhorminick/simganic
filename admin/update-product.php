<?php
    session_start();
    include '_layout/_dbconnection.php';
    
    $errors = [];

    if (!isset($_SESSION['admin_loggedin'])) {
        header('Location: sign-in?redirect=update-product');    
    }
    
    if (isset($_POST["update-product"])) {
        $newproduct_name = $_POST["productname"];
        $newproduct_id = $_POST["productid"];
        $newproduct_category = $_POST["_productcategory"];
        $newproduct_price_250 = $_POST["_productprice_250ml"];
        $newproduct_price_500 = $_POST["_productprice_500ml"];
        $newproduct_link = $_POST["_productlink"];
        $newproduct_available_250 = $_POST["_productavailable_250ml"];
        $newproduct_available_500 = $_POST["_productavailable_500ml"];

        $updPrice = array('250ml' => $newproduct_price_250, '500ml' =>  $newproduct_price_500);
        $updAvail = array('250ml' => $newproduct_available_250, '500ml' =>  $newproduct_available_500); 

        $dataPrice = serialize($updPrice);
        $dataAvail = serialize($updAvail);
        
        
        $UpdateProduct = "UPDATE product_details SET product_name = '$newproduct_name', product_category = '$newproduct_category', product_prices = '$dataPrice', products_available = '$dataAvail' WHERE product_id = '$newproduct_id'";
        $UpdateProductsResult = $con->query($UpdateProduct);
        if ($UpdateProductsResult) {
            array_push($errors, "Product Updated Succesfully.");
        }else{
            array_push($errors, "Product <b>NOT</b> Updated Succesfully.");
        }
        
        
    }

    $prods = "No Product(s) Selected.";

    if (isset($_POST["SearchProducts"])) {
        $product = $_POST["_productname"];
        //Get More Products Based On Category
        $GetProducts = "SELECT * FROM product_details WHERE product_name = '$product'";
        $GetProductsResult = $con->query($GetProducts);

        if ($GetProductsResult->num_rows > 0) {
            // output data of each row
            $row = $GetProductsResult->fetch_assoc();
            $_product_name = $row["product_name"];
            $_product_img = $row["product_img"];
            $_product_id = $row["product_id"];
            $_product_category = $row["product_category"];
            //$_product_price = $row["product_price"]; 
            $_product_link = $row["product_link"];
            //$_product_available = $row["product_available"];
            $_product_prices = $row["product_prices"];
            $_product_available = $row["products_available"];

            $ProductPrices = unserialize($_product_prices);
            $ProductAvailable = unserialize($_product_available);
            $price250 = $ProductPrices['250ml'];
            $price500 = $ProductPrices['500ml'];
            $avail250 = $ProductAvailable['250ml'];
            $avail500 = $ProductAvailable['500ml'];

            $prods = "
                <div class='form-row'>
                    <div class='form-group col-md-3'>
                        <label for='inputEmail4'>Product Name</label>
                        <input type='text' class='form-control' id='prodName' name='productname' placeholder='Product Name'  value='$_product_name'>
                    </div>
                    <div class='form-group col-md-3'>
                        <label for='inputEmail4'>Product ID</label>
                        <input type='text' class='form-control' id='prodId' name='productid' placeholder='Product ID' value='$_product_id' readonly>
                    </div>
                    <div class='form-group col-md-3'>
                        <label>Product Price (250ml)</label>
                        <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'><del>N</del></span>
                            </div>
                            <input type='number' class='form-control' aria-label='Amount (to the nearest dollar)' name='_productprice_250ml' value='$price250'>
                        </div>
                    </div>
                    <div class='form-group col-md-3'>
                        <label>Product Price (500ml)</label>
                        <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'><del>N</del></span>
                            </div>
                            <input type='number' class='form-control' aria-label='Amount (to the nearest dollar)' name='_productprice_500ml' value='$price500'>
                        </div>
                    </div>
                </div>
                <div class='form-row'>
                    <div class='form-group col-md-4'>
                        <label for='inputCity'>Product File Name</label>
                        <input type='text' class='form-control' name='_productlink' value='$_product_link' id='inputCity'>
                    </div>
                    <div class='form-group col-md-4'>
                        <label>Product Category</label>
                        <select class='form-control select2' name='_productcategory'>
                            <option value='$_product_category' selected>$_product_category</option>
                            <option value='Flour'>Flour</option>
                            <option value='Dairy'>Dairy</option>
                            <option value='Spices'>Spices And Seasonings</option>
                        </select>
                    </div>
                    <div class='form-group col-md-2'>
                        <label for='inputZip'>Product Avail. (250ml)</label>
                        <input type='number' class='form-control' name='_productavailable_250ml' value='$avail250' id='inputZip'>
                    </div>
                    <div class='form-group col-md-2'>
                        <label for='inputZip'>Product Avail. (500ml)</label>
                        <input type='number' class='form-control' name='_productavailable_500ml' value='$avail500' id='inputZip'>
                    </div>
                </div>
                <div class='form-group'>
                    <label>Product Image</label>
                    <input type='text' class='form-control' name='_productimg' value='$_product_img'>
                    <input type='file' name='file'>
                </div>
                </div>
                                <div class='card-footer'>
                                    <button class='btn btn-primary' type='submit' name='update-product'>UPDATE PRODUCT DETAILS</button>
                                </div>
            ";
                                
        } else {
                                
        }
    }else{
        $prods = "No Product(s) Selected.";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Update Product &mdash; SimGanic</title>

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
                    <h1>Update Product Details</h1>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="card col-12 col-md-6 col-lg-12">
                                
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
                                
                                <form method="POST" action="">
                                    <div class="form-row">
                                        <div class="form-group search-box col-md-9">
                                            <label for="inputEmail4">Search Product</label>
                                            <input type="text" class="form-control" name="_productname" placeholder="Product Name" autocomplete="off">
                                            <div class="result"></div>
                                        </div>
                                        <div style="margin-top:30px !important;">
                                            <button class="btn btn-primary" name="SearchProducts" type="submit">SEARCH</button>
                                        </div>
                                        <style>
                                            /* Formatting result items */
                                            .result{
                                                max-height: 220px;
                                                height: auto;
                                                overflow: auto;
                                                margin-left: 10px;
                                                margin-right: 10px;
                                                margin-top: 5px;
                                            }
                                            .search-box input[type="text"], .result{
                                                
                                                
                                            }
                                            /* Formatting result items */
                                            .result p{
                                                margin-bottom: 5px;
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
                                <form action="update-product" method="POST" enctype="multipart/form-data"> 
                                    <?php echo $prods;?>
                                </form>
                            </div>
                    </div>
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

<script src="assets/modules/select2/dist/js/select2.full.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/forms-advanced-forms.js"></script>

<script>
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            //alert("test");
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("_layout/search_db.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });
                                                
        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
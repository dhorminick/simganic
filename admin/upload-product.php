<?php
    session_start();
    include '_layout/_dbconnection.php';
    
    $errors = [];
    
    if (!isset($_SESSION['admin_loggedin'])) {
        header('Location: sign-in?redirect=upload-product');    
    }

    $product_id = strtoupper("#PD-".bin2hex(random_bytes(5)).mt_rand(00000,99999));

    if (isset($_POST["upload-product"])) {
        $product_name = $_POST["product_name"];
        $product_category = $_POST["product_category"];
        $product_price_250 = $_POST["product_price_250ml"];
        //$_is500 = $_POST["is500"];
        $product_price_500 = $_POST["product_price_500ml"];
        //$product_image = $_POST["productimg"];
        $product_link = $_POST["product_link"];
        $product_available_250 = $_POST["product_available_250ml"];
        $product_available_500 = $_POST["product_available_500ml"];
        //$product_available = $_POST["product_available"];

        $ProductPrice = array('250ml' => $product_price_250, '500ml' => $product_price_500);
        $ProductAvailable = array('250ml' => $product_available_250, '500ml' => $product_available_500);
        

        $data = serialize($ProductPrice);
        $dataAvailable = serialize($ProductAvailable);

       
        $tmpfile = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        $uploaddir = 'usr/';
        $uploadfile = $uploaddir . $filename;

        if(move_uploaded_file($tmpfile, $uploadfile)) {
        $insert_to_db = "INSERT INTO product_details (product_name, product_img, product_id, product_category, product_prices, product_link, products_available) VALUES ('$product_name', '$uploadfile' , '$product_id' , '$product_category', '$data', '$product_link', '$dataAvailable')";
        $vaildresponse = mysqli_query($con, $insert_to_db) or die(mysqli_error($con));
        if ($vaildresponse) {
            //create file
            $url = "products";
            $fileName = $product_link;
            $ProductPage = fopen("$url/$fileName.php", "w") or die("Unable to open file!");
            $txt = '<?php
    $page_product_id = "'.$product_id.'";

    include "_layout/single-product.php";
?>';
        fwrite($ProductPage, $txt);
        fclose($ProductPage);
            array_push($errors, "Product Registered Succesfully.");
        }else{
            array_push($errors, "Product <b>NOT</b> Registered Succesfully.");
        }
        }
        
        
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Upload Product &mdash; SimGanic</title>

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
                    <h1>Upload Product</h1>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="card col-12 col-md-6 col-lg-12">
                                <form action="upload-product" method="POST" enctype="multipart/form-data">
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
                                            <label for="inputEmail4">Product Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" name="product_name" placeholder="Product Name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Product ID</label>
                                            <input type="text" class="form-control" id="inputPassword4" name="product_id" value="<?php echo $product_id;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Product Category</label>
                                            <select class="form-control select2" name="product_category" required>
                                                <option value="">Select Category</option>
                                                <option value="Flour">Flour</option>
                                                <option value="Dairy">Dairy</option>
                                                <option value="Spices">Spices And Seasonings</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Product Price (250ml)</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8358;</span>
                                                </div>
                                                <input type="number" class="form-control" name="product_price_250ml" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Product Price (500ml)</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8358;</span>
                                                </div>
                                                <input type="number" class="form-control" name="product_price_500ml" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <input type="file" name="file">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">Product File Name</label>
                                            <input type="text" class="form-control" name="product_link" id="inputCity" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Product Available (250ml)</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="product_available_250ml" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Product Available (500ml)</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="product_available_500ml" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit" name="upload-product">UPLOAD PRODUCT</button>
                                </div>
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

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>

</body>

</html>
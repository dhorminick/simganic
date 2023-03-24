<?php
    session_start();
    
    //dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    

    $message = [];
    $reactionResponse = [];
    //$headerlink = $_SERVER["REQUEST_URI"];
    
    //exit();
    if (!isset($_SESSION['loggedin'])) {
        $_user_email_address = "demo@demo.com";
        $_user_name = "user449431";
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    include '_layout/_user_details.php';
    include '_layout/_arrays.php';

    if (isset($_GET["product"])) {
        $productID = strip_tags(htmlspecialchars($_GET["product"]));

        $GetNewProducts = "SELECT * FROM product_details WHERE crc32(product_id) = '$productID'";
        $NewProductDetails = $con->query($GetNewProducts);
        if ($NewProductDetails->num_rows > 0) {
            $NewProductRow = mysqli_fetch_assoc($NewProductDetails);
            $pname = $NewProductRow["product_name"];
        }else{
            //array_push($message, "No Product(s) Selected");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title><?php if (isset($_GET["product"]) && $NewProductDetails->num_rows > 0) { echo "All Reviews On '".$pname."' &mdash; SimGanic;";}else{echo "All Reviews  &mdash; SimGanic";} ?></title>

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
        <?php
            $GetNewProducts = "SELECT * FROM product_details WHERE crc32(product_id) = '$productID'";
            $NewProductDetails = $con->query($GetNewProducts);
            if ($NewProductDetails->num_rows > 0) {
                $NewProductRow = mysqli_fetch_assoc($NewProductDetails);
                $pname = $NewProductRow["product_name"];
                $page_product_id = $NewProductRow["product_id"];
            
        ?>
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>All Reviews on "<?php echo $pname; ?>" :</h1>
                </div>

                <div class="section-body">
                    <?php

                                                $userMail = $_user_email_address;
                                                if (isset($_SESSION['loggedin'])) {
                                                    if (isset($_POST["upvote"])) {
                                                        $_rvc =  strip_tags($_POST["-rvc"]);
                                                        if ($_rvc || $_rvc !== "" || $_rvc !== null) {
                                                            # code...
                                                            $GetArray = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                            $ArrayResult = $con->query($GetArray);
                                                            if ($ArrayResult->num_rows > 0) {
                                                                $row = mysqli_fetch_assoc($ArrayResult);
                                                                $reactionSingle = $row["_reaction"];
                                                                $reactionDataSingle = unserialize($reactionSingle);

                                                                $reactionDataSingle[$userMail] = "Yes";
                                                                $newData4 = serialize($reactionDataSingle);

                                                                $UpdateReview4 = "UPDATE _reviews SET _reaction = '$newData4' WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                                $UpdateReviewResult4 = $con->query($UpdateReview4);
                                                                if ($UpdateReviewResult4) {
                                                                    //array_push($reactionResponse, "Review Liked.");
                                                                }else{
                                                                    array_push($reactionResponse, "Error 401! Records Not Updated.");
                                                                    //echo "Error: " . $con->error;
                                                                }
                                                            }else{
                                                                array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                            }
                                                        }else{
                                                            array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                        }
                                                    }elseif (isset($_POST["downvote"])) {
                                                        $_rvc =  strip_tags($_POST["-rvc"]);
                                                        if ($_rvc || $_rvc !== "" || $_rvc !== null) {
                                                            # code...
                                                            $GetArray = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                            $ArrayResult = $con->query($GetArray);
                                                            if ($ArrayResult->num_rows > 0) {
                                                                $row = mysqli_fetch_assoc($ArrayResult);
                                                                $reactionSingle = $row["_reaction"];
                                                                $reactionDataSingle = unserialize($reactionSingle);

                                                                $reactionDataSingle[$userMail] = "No";
                                                                $newData4 = serialize($reactionDataSingle);

                                                                $UpdateReview4 = "UPDATE _reviews SET _reaction = '$newData4' WHERE product_id = '$page_product_id' AND md5(sha1(_reviewcode)) = '$_rvc'";
                                                                $UpdateReviewResult4 = $con->query($UpdateReview4);
                                                                if ($UpdateReviewResult4) {
                                                                    //array_push($reactionResponse, "Review Liked.");
                                                                }else{
                                                                    array_push($reactionResponse, "Error 401! Records Not Updated.");
                                                                    //echo "Error: " . $con->error;
                                                                }
                                                            }else{
                                                                array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                            }
                                                        }else{
                                                            array_push($reactionResponse, "Error 402! Records Not Updated.");
                                                        }
                                                    }
                                                }else{
                                                    if (isset($_POST["upvote"])) {
                                                        array_push($reactionResponse, "Sign In To React To Reviews.");
                                                    }elseif (isset($_POST["downvote"])) {
                                                        array_push($reactionResponse, "Sign In To React To Reviews.");
                                                    }
                                                }

                                                $GetReviews = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' ORDER BY id DESC LIMIT 5";
                                                $GetReviewsResult = $con->query($GetReviews);
                                                $rowcount = mysqli_num_rows($GetReviewsResult); ?>
                                                <?php if (count($reactionResponse) > 0) : ?>
                                                    <div class="alert-div">
                                                        <?php foreach ($reactionResponse as $response) : ?>
                                                        <div class="alert alert-primary alert-dismissible show fade">
                                                            <div class="alert-body">
                                                                <button class="close" data-dismiss="alert"><span>×</span></button>
                                                                <?php echo $response ?>
                                                            </div>
                                                        </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                <?php endif ?>
                                                <?php while ($row = mysqli_fetch_assoc($GetReviewsResult)) {
                                                if ($GetReviewsResult->num_rows > 0) {
                                                    
                                                    $review = $row["_comment"];
                                                    $stars = $row["_stars"];
                                                    $date = $row["_date"];
                                                    $uploader = $row["username"];
                                                    $uploader_email_add = $row["email"];
                                                    $reviewid = $row["_reviewcode"];
                                                    //$reaction = $row["_reaction"];

                                                    $ConfirmPurchaser = "SELECT * FROM _allorders WHERE items LIKE \"%$page_product_id%\" AND email = '$uploader_email_add' AND status = 'paid' OR status = 'shipped' OR status = 'delivered'";
                                                    //echo "<script>alert('$uploader_email_add');</script>";
                                                    $ConfirmPurchaserResult = $con->query($ConfirmPurchaser);
                                                    $ConfirmPurchaserRowCount = mysqli_num_rows($ConfirmPurchaserResult);

                                                    //echo "<script>alert('$uploader_email_add');</script>";
                                                    if ($ConfirmPurchaserResult -> num_rows <= 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:red;font-family:12px;"><i class="fa fa-times-circle"></i> <a style="color:red;" href="faqs#unverified-purchaser">unverified purchaser</a></span>';
                                                    }elseif ($ConfirmPurchaserResult -> num_rows > 0) {
                                                        $isVerifiedPurchaser = '<span class="" style="color:green;font-family:12px;"><i class="fa fa-check-circle"></i> <a style="color:green;" href="faqs#unverified-purchaser">verified purchaser</a></span>';
                                                    }
                                                    //array_push($reactionResponse, "Review Liked.");
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="rating"><p class="star-rating"><span class="<?php echo $stars;?>"></span></p></div>
                                            <div>by <strong><?php echo $uploader; ?></strong></div>
                                        </div>
                                        <div class="col-12 col-lg-12 show-sm" style="margin-top:5px;margin-bottom:5px;">
                                            <div><?php echo $review; ?></div>
                                            <?php if (isset($_SESSION['loggedin'])) { ?>
                                            <div>
                                                <?php

                                                    if ($uploader === $_firstname.' '.$_lastname || $uploader === $_user_name) {
                                                ?>   
                                                <form action="" method="post" class="show-bg" style="margin-top:10px;">
                                                    <input type="hidden" value="<?php echo md5(sha1($reviewid)); ?>" name="rev">
                                                    <button class="btn_vote" style="margin-left: 0px !important;font-size:12px !important;font-weight:normal !important;" name="delete-review"><i class="fa fa-trash"></i> Delete Review</button>
                                                </form>     
                                                <?php }else{}?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="show-sm" style="text-align:right;">
                                                <div><?php echo $date; ?></div>
                                                <div><?php echo $isVerifiedPurchaser; ?></div>
                                            </div>
                                            <div class="show-bg">
                                                <div><?php echo $date; ?></div>
                                                
                                                <div><?php echo $isVerifiedPurchaser; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 show-bg">
                                            <h6>Was this review helpful?</h6>
                                            <?php
                                                        
                                                $IfHaveReviewied = "SELECT * FROM _reviews WHERE product_id = '$page_product_id' AND _reviewcode = '$reviewid'";
                                                $IfHaveReviewiedResult = $con->query($IfHaveReviewied);
                                                if ($IfHaveReviewiedResult -> num_rows > 0) {
                                                    $row = mysqli_fetch_array($IfHaveReviewiedResult);
                                                    $data = unserialize($row["_reaction"]);
                                                    //var_dump($data);
                                                    $YesCount = count(array_keys($data, 'Yes'));
                                                    $NoCount = count(array_keys($data, 'No'));
                                                    if (array_key_exists($userMail,$data)){
                                                        $isNew = false;
                                                        $val = $data[$userMail];
                                                        //echo $val;
                                                        if ($val === "No") {
                                                            echo '
                                                            <form id="reactForm" method="post" action="">
                                                                <span class="btn_react"><i class="fa fa-thumbs-down" aria-hidden="true" style="margin-right:3px !important;"></i> No ('.$NoCount.')</span>
                                                                <button class="btn_vote" name="upvote" title data-toggle="tooltip" data-placement="left" data-original-title="Like Review"><i class="fa fa-thumbs-up"></i> Yes ('.$YesCount.')</button>
                                                                <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            </form>';
                                                        }else if ($val === "Yes") {
                                                            echo '
                                                            <form id="reactForm" method="post" action="">
                                                                <span class="btn_react"><i class="fa fa-thumbs-up" aria-hidden="true" style="margin-right:3px !important;"></i> Yes ('.$YesCount.')</span>
                                                                <button class="btn_vote" name="downvote" title data-toggle="tooltip" data-placement="left" data-original-title="Dislike Review"><i class="fa fa-thumbs-down"></i> No ('.$NoCount.')</button>
                                                                <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            </form>';
                                                        }
                                                    }else{
                                                        $isNew = true;
                                                        echo '
                                                        <form id="reactForm" method="post" action="">
                                                            <input type="hidden" value="'.md5(sha1($reviewid)).'" name="-rvc">
                                                            <button type="submit" name="upvote" class="btn_vote"><i class="fa fa-thumbs-up"  style="margin-right:3px !important;" aria-hidden="true"></i> Yes ('.$YesCount.')</button>
                                                            <button type="submit" name="downvote" class="btn_vote"><i class="fa fa-thumbs-down"  style="margin-right:3px !important;" aria-hidden="true"></i> No ('.$NoCount.')</button>
                                                        </form>';
                                                    }
                                                }else{
                                                    $noReview = true;            
                                                }
                                            ?>
                                        </div>
                                        <div class="col-12 col-lg-12 show-bg" style="margin-top:5px;">
                                            <div><?php echo $review; ?></div>
                                            <?php if (isset($_SESSION['loggedin'])) { ?>
                                            <div>
                                                <?php
                                                    if ($uploader === $_firstname.' '.$_lastname || $uploader === $_user_name) {
                                                ?>   
                                                <form action="" method="post" class="show-bg" style="margin-top:10px;">
                                                    <input type="hidden" value="<?php echo md5(sha1($reviewid)); ?>" name="rev">
                                                    <button class="btn_vote" style="margin-left: 0px !important;font-size:12px !important;font-weight:normal !important;" name="delete-review"><i class="fa fa-trash"></i> Delete Review</button>
                                                </form>     
                                                <?php }else{}?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php }else{ /* No review */}} ?>
                                    <?php
                                        if ($GetReviewsResult->num_rows <= 0){
                                            echo '<div><center><h6>No Review On This Product Yet.</h6></center></div>';
                                        }else{ 
                                    ?>
                                    <?php } ?>
                </div>
            </section>
        </div>

        <?php }else{ ?>
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>All Reviews:</h1>
                </div> 

                <div class="section-body">
                    <h4>Error 402! No Product Selected.</h4>
                </div>  
            </section>
        </div>     
        <?php } ?>

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

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
</html>
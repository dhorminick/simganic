<?php
    
    $dbconn = include '_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header("Location: sign-in?redirect=my-account");
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
    }

    if (isset($_POST["updatecart"])) {
        $value = $_POST["updatecart"];
        if (isset($_SESSION['loggedin'])) {
            header("Location: _ajax.php?$value&updatecart=Submit");
        }else{
            header("Location: _ajax.php?$value&updatecart_notloggedin=Submit");
        }
    }

    if (isset($_POST["update_cart_from_cart_page"])) {
        $value = $_POST["update_cart_from_cart_page"];
        header("Location: _ajax.php?$value&updatecart=Submit");
    }

    if (isset($_POST["updatewishlist"])) {
        $value = $_POST["updatewishlist"];
        header("Location: _ajax.php?$value&updatewishlist=Submit");
    }

    if (isset($_POST["add_to_newsletter"])) {
        $value = $_POST["add_to_newsletter"];
        header("Location: _ajax.php?$value&newsletter=Submit");
    }

    $todayDate = date("d-m-Y");



if (isset($_GET["updatecart"])) {
    $newRecord = trim(strip_tags($_GET["qty"]));
    
    if ($newRecord == 0) {
        # code...
    }else{
        if (!filter_var($newRecord, FILTER_VALIDATE_INT) === false) {
        
        } else {
            echo '<script>$("#toastr-23").click();</script>';
            exit();
        }
    }

    $pID = trim(strip_tags($_GET["sku-value"]));
    $size = trim(strip_tags($_GET['sku-size']));

    if ($size === "250ml" || $size === "500ml") {
        //echo $newRecord;
        //exit();
        if ($newRecord <= "0") {
            # code...
            $CheckCartRecord_ToDeleteZeroRecords = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND crc32(_product_id) = '$pID' AND _size = '$size'";
            $CheckCartRecord_ToDeleteZeroRecordsResult = mysqli_query($con,$CheckCartRecord_ToDeleteZeroRecords);
            if ($CheckCartRecord_ToDeleteZeroRecordsResult -> num_rows > 0) {
                $row = $CheckCartRecord_ToDeleteZeroRecordsResult->fetch_assoc();
                $_noInCart = $row["_no_products"];
                if ($_noInCart <= 0) {
                    $DeleteEmptyRecords = "DELETE FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products <= 0";
                    $DeleteEmptyRecords_Result = $con->query($DeleteEmptyRecords);
                    echo '<script>$("#toastr-19").click();</script>';
                    echo '<script> setTimeout(function(){ window.location.reload() }, 2000);</script>';
                    exit();
                }else{

                }
            }else{
                echo '<script>$("#toastr-11").click();</script>';
                exit();
            }
        }

        
            $GetProductsDetails = "SELECT * FROM product_details WHERE crc32(product_id) = '$pID'";
            $ProductsDetailsResult = $con->query($GetProductsDetails);
            if ($ProductsDetailsResult->num_rows > 0) {
                // output data of each row
                $row = $ProductsDetailsResult->fetch_assoc();
                $p_available = $row["products_available"];
                $p_id = $row["product_id"];
                $p_price = $row["product_prices"];

                $available = unserialize($p_available);
                $prices = unserialize($p_price);
                if ($size === "250ml" && $newRecord >= $available["250ml"] - 1 || $size === "500ml" && $newRecord >= $available["500ml"] - 1) {
                    echo '<script>$("#toastr-15").click();</script>';
                }else{    
                    $CheckCartRecord = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND crc32(_product_id) = '$pID' AND _size = '$size'";                                          
                    $CheckCartRecordResult = mysqli_query($con,$CheckCartRecord);
                    if ($CheckCartRecordResult -> num_rows > 0) {
                        $row = mysqli_fetch_array($CheckCartRecordResult);
                        $noInCart = $row["_no_products"];

                        $UpdateCartRecords = "UPDATE _allcarts SET _no_products = '$newRecord' WHERE _emailaddress = '$_user_email_address' AND crc32(_product_id) = '$pID'  AND _size = '$size'";
                        $UpdateCartResult = mysqli_query($con,$UpdateCartRecords);
                        if ($UpdateCartResult) {
                            echo '<script>$("#toastr-9").click();</script>';
                        }else{
                            echo '<script>$("#toastr-13").click();</script>';
                        }
                        
                    }else{
                        //echo "Error: " . $con->error;
                        //exit();
                        if ($size === "250ml") {
                            $pPrice = $prices["250ml"];
                        }elseif ($size === "500ml") {
                            $pPrice = $prices["500ml"];
                        }
                        $cartDate = date("d-m-Y");
                        $UpdateCartRecords = "INSERT INTO _allcarts (_emailaddress, _product_id, _price, _size, _no_products, _timestamp) VALUES ('$_user_email_address', '$p_id', '$pPrice', '$size', '$newRecord', '$cartDate')";
                        $UpdateCartResult = mysqli_query($con,$UpdateCartRecords);
                        if ($UpdateCartResult) {
                            //echo "Product Added To Cart Succesfully.";
                            echo '<script>$("#toastr-14").click();</script>';
                            //echo '<script>$("#toastr-9").click();</script>';
                        }else{
                            echo '<script>$("#toastr-10").click();</script>';
                        }
                    }
                }
            } else {
                //User Probably Changed The Values. Echo Product Error
                echo '<script>$("#toastr-11").click();</script>';
                exit();
            }
        
    }else{
        //User Probably Changed The Values. Echo Product Error
        echo '<script>$("#toastr-11").click();</script>';
        exit();
    }
}

if (isset($_GET["updatecart_notloggedin"])) {
    echo '<script>$("#toastr-11").click();</script>';
    exit();
    $newRecord = 1;
    $pID = strip_tags($_GET["sku-value"]);
    $size = strip_tags($_GET['sku-size']);

    if ($size === "250ml" || $size === "500ml") {
        
        if ($newRecord <= "0") {
            # code...
            echo '<script>$("#toastr-11").click();</script>';
            exit();
        }

        
            $GetProductsDetails = "SELECT * FROM product_details WHERE crc32(product_id) = '$pID'";
            $ProductsDetailsResult = $con->query($GetProductsDetails);
            if ($ProductsDetailsResult->num_rows > 0) {
                // output data of each row
                $row = $ProductsDetailsResult->fetch_assoc();
                $p_available = $row["products_available"];
                $p_id = $row["product_id"];
                $p_name = $row["product_name"];
                $p_img = $row["product_img"];
                $p_category = $row["product_category"];
                $p_price = $row["product_prices"];

                $available = unserialize($p_available);
                $prices = unserialize($p_price);
                if ($size === "250ml" && $newRecord >= $available["250ml"] - 1 || $size === "500ml" && $newRecord >= $available["500ml"] - 1) {
                    echo '
                        <span id="max-values"></span>
                        <script>
                            $("#max-values").click(function() {
                                iziToast.error({
                                title: "Error 402!",
                                message: "Maximum Products Available Exceeded.",
                                position: "topRight"
                                });
                            });
                            $("#max-values").click();
                        </script>
                    ';
                }else{  
                    if ($size === "250ml") {
                        $pPrice = $prices["250ml"];
                        $pAvailable = $available["250ml"];
                    }elseif ($size === "500ml") {
                        $pPrice = $prices["500ml"];
                        $pAvailable = $available["500ml"];
                    }
                         
                    $Not_Logged_In_Cart_Array = array(
                        $p_id=>array(
                        'name'=>$p_name,
                        'p_id'=>$p_id,
                        'p_link'=>$p_link,
                        'price'=>$pPrice,
                        'available'=>$pAvailable,
                        'category'=>$p_category,
                        'quantity'=>1,
                        'image'=>$p_img)
                    ); 

                    if(empty($_SESSION["shopping_cart"])) {
                        $_SESSION["shopping_cart"] = $Not_Logged_In_Cart_Array;
                            echo '
                                <span id="added-to-cart"></span>
                                <script>
                                    $("#added-to-cart").click(function() {
                                      iziToast.success({
                                        title: "Product Added To Cart Succesfully.",
                                        message: "",
                                        position: "topRight"
                                      });
                                    });
                                    $("#added-to-cart").click();
                                </script>
                            ';  
                    }else{
                        $array_keys = array_keys($_SESSION["shopping_cart"]);
                        if(in_array($p_id,$array_keys)) {
                            echo '
                                <span id="already-in-cart"></span>
                                <script>
                                    $("#already-in-cart").click(function() {
                                      iziToast.warning({
                                        title: "Product Already In Cart.",
                                        message: "",
                                        position: "topRight"
                                      });
                                    });
                                    $("#already-in-cart").click();
                                </script>
                            ';  
                        } else {
                            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$Not_Logged_In_Cart_Array);
                            echo '
                                <span id="added-to-cart"></span>
                                <script>
                                    $("#added-to-cart").click(function() {
                                      iziToast.success({
                                        title: "Product Added To Cart Succesfully.",
                                        message: "",
                                        position: "topRight"
                                      });
                                    });
                                    $("#added-to-cart").click();
                                </script>
                            ';  
                        }
                    }                    
                }
            } else {
                //User Probably Changed The Values. Echo Product Error
                echo '
                    <span id="error-values"></span>
                    <script>
                        $("#error-values").click(function() {
                            iziToast.error({
                            title: "Error 402!",
                            message: "Product Details Error.",
                            position: "topRight"
                            });
                        });
                        $("#error-values").click();
                    </script>
                ';
                exit();
            }
        
    }else{
        //User Probably Changed The Values. Echo Product Error
        echo '<script>$("#toastr-11").click();</script>';
        exit();
    }
}

if (isset($_GET["updatewishlist"])) {
    $wishlistPID = strip_tags($_GET["sku-value"]);
    //check if id exists
    $GetProductsDetails = "SELECT * FROM product_details WHERE crc32(product_id) = '$wishlistPID'";
    $ProductsDetailsResult = $con->query($GetProductsDetails);
    if ($ProductsDetailsResult->num_rows > 0) {
        $row = $ProductsDetailsResult->fetch_assoc();
        $p_id = $row["product_id"];
        //id exists, add if not added before or echo "already added"
        $CheckRecords = "SELECT * FROM _allwishlist WHERE _emailaddress = '$_user_email_address' AND crc32(_product_id) = '$wishlistPID'";
        $CheckRecordsResult = mysqli_query($con,$CheckRecords);
        if ($CheckRecordsResult -> num_rows > 0) {
            echo '<script>$("#toastr-18").click();</script>';
        }else{
            $CreateCartRecords = "INSERT INTO _allwishlist (_emailaddress, _product_id, _timestamp) VALUES ('$_user_email_address', '$p_id', '$todayDate')";
            $CreateCartResult = mysqli_query($con,$CreateCartRecords);
            if ($CreateCartResult) {
                echo '<script>$("#toastr-16").click();</script>';
            }else{
                echo '<script>$("#toastr-17").click();</script>';
            }
        }
    }else{
        //User Probably Changed The Values. Echo Product Error
        echo '<script>$("#toastr-11").click();</script>';
        exit();
    }
}

if (isset($_GET["newsletter"])) {
    $email = trim(strip_tags($_GET["newsletter-email"]));

    $CheckIfExist = "SELECT * FROM _users WHERE _email = '$email'";
    $IfExist = $con->query($CheckIfExist);
    if ($IfExist->num_rows > 0) {
        $row = mysqli_fetch_array($IfExist);
        $IsAUser = $row['_newsletter'];
        if ($IsAUser === true) {
            echo '<script>$("#toastr-22").click();</script>';
        }else{
            echo '<script>$("#toastr-22").click();</script>';
            //send mail  
        }
        
    }else{
        
        $CheckIfRandUserExist = "SELECT * FROM _newsletter_subscription WHERE _email = '$email'";
        $IfRandUserExist = $con->query($CheckIfRandUserExist);
        if ($IfRandUserExist->num_rows > 0) {
            $row = mysqli_fetch_array($IfRandUserExist);
            $IsARandUser = $row['_confirmed_email'];
            if ($IsARandUser === true) {
                echo '<script>$("#toastr-22").click();</script>';
            }else{
                echo '<script>$("#toastr-22").click();</script>';
                //send mail
            }    
        }else{
            $InsertRecords = "INSERT INTO _newsletter_subscription (_email, _confirmed_email) VALUES ('$email', false)";
            $InsertResult = mysqli_query($con,$InsertRecords);
            if ($InsertResult) {
                echo '<script>$("#toastr-20").click();</script>';
                //send mail
            }else{
                echo '<script>$("#toastr-21").click();</script>';
            }
        }

    }

}

?>
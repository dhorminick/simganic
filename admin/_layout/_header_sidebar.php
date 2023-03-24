<?php
    if(isset($_POST["sign-out"])){
        session_destroy();
        // Redirect to the login page:
        header('Location: /');  
    }

    if (isset($_SESSION['loggedin'])) {
        $GetHeaderCartValue = "SELECT * FROM _allcarts WHERE _emailaddress = '$_user_email_address' AND _no_products > 0 ";
        $GetHeaderCartValueResult = $con->query($GetHeaderCartValue);
        $HeaderCartCount = mysqli_num_rows($GetHeaderCartValueResult);
    }else{
        $HeaderCartCount = 0;
    }
   
?>
<!-- Start app top navbar -->
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto" method="get" action="search">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
                <div class="search-element">
                    <input class="form-control header-search-box" name="q" type="search" value="<?php if(isset($_GET["q"])){echo strip_tags($_GET["q"]);}else{}?>" placeholder="Search" aria-label="Search" data-width="250" style="color:#563d7c; !important;" required>
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown show-bg">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="assets/img/avatar/avatar.jpg" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">Hi, <?php if (isset($_SESSION['loggedin'])) { echo $_SESSION['lastname'];}else{ echo "User";} ?></div></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!--div class="dropdown-title">Logged in 5 min ago</div-->
                        <a href="my-account" style="width:90%;margin:10px;" class="dropdown-item has-icon caps"><i class="far fa-user"></i> My Account</a>
                        <a href="wishlist" style="width:90%;margin:10px;" class="dropdown-item has-icon caps"><i class="fas fa-heart-circle-check"></i> My Wishlist</a>
                        <div class="dropdown-divider"></div>
                        <?php
                            if (isset($_SESSION['loggedin'])) {
                                echo '
                        <form action="" method="post">
                                <button class="btn btn-primary" style="width:90%;margin:10px;" name="sign-out">SIGN OUT</button>
                        </form>';
                            }
                        ?>
                    </div>
                </li>
                <li class="show-sm">
                    <a href="my-account" class="nav-link nav-link-lg nav-link-user" title data-toggle="tooltip" data-placement="left" data-original-title="My Account" style="margin-right:0px !important;padding-right: 0px !important;">
                    <img alt="image" src="assets/img/avatar/avatar.jpg" class="rounded-circle mr-1">
                    <i class="fa fa-caret-down" style="font-size:13px;"></i>
                    </a>
                </li>
                <a href="cart" class="nav-link nav-link-lg" title data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $HeaderCartCount; ?> Item(s) In Cart"><li><i class="fa fa-cart-plus" style="font-size:25px;"></i> <strong>(<?php echo $HeaderCartCount; ?>)</strong></li></a>
            </ul>
        </nav>

        <!-- Start main left sidebar menu -->
        <div class="main-sidebar sidebar-style-3">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="/">SimGanic</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="/">SG</a>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="/" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>

                    <li class="menu-header">Account</li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Account</span></a>
                        <ul class="dropdown-menu">
                            <?php
                                if (!isset($_SESSION['loggedin'])) {
                                    echo '
                                    <li><a href="sign-up">Create Account</a></li> 
                                    <li><a href="sign-in">Sign In</a></li>
                                    <li><a href="cart">My Cart</a></li> 
                                    <li><a href="wishlist">My Wishlist</a></li>';
                                }else{
                                    echo '
                                    <li><a href="cart">My Cart</a></li> 
                                    <li><a href="wishlist">My Wishlist</a></li>
                                    <li><a href="update-account-password">Update Password</a></li> 
                                    <li><a href="update-account-details">Edit Account Details</a></li>
                                    <li><a href="update-shipping-address">Edit Shipping Address</a></li>';
                                }
                            ?>
                        </ul>
                    </li>

                    <li class="menu-header">Our Products</li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa fa-parachute-box"></i> <span>Products</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/products/category/diary/">Dairy</a></li>
                            <li><a class="nav-link" href="/products/category/spices-and-seasonings/">Spices and Seasonings</a></li>
                            <li><a class="nav-link" href="/products/category/flour/">Flour</a></li>
                            <li><a class="nav-link" href="/products/category/extracts-and-flavours/">Extracts & Flavours</a></li>
                            <li><a class="nav-link" href="/products/category/tea-and-herbs/">Tea and Herbs</a></li>
                            <hr style="margin:5px 25px;border-color:rgba(255,255,255,0.7);">
                            <li><a class="nav-link" href="all-products">All Products</a></li>
                        </ul>
                    </li>

                    <li class="menu-header">Meet Us</li>
                    <li><a class="nav-link" href="about-simganic"><i class="far fa fa-thumbtack"></i> <span>About SimGanic</span></a></li>
                    <li><a class="nav-link" href="contact-us"><i class="far fa fa-id-badge"></i> <span>Contact Us</span></a></li>

                    <li class="menu-header">Help</li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="nav-link has-dropdown"><i class="far fa fa-question"></i> <span>Help</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="faqs#report-product">Report a Product</a></li> 
                            <li><a href="faqs#cancel-order">Cancel an Order</a></li>
                            <li><a href="faqs#return-product">Return a Product</a></li> 
                            <li><a href="faqs">FAQ's</a></li> 
                        </ul>
                    </li>

                    <li class="menu-header">Agreements</li>
                    <li><a class="nav-link" href="terms-and-conditions"><i class="far fa fa-file-contract"></i> <span>Terms and Conditions</span></a></li>
                    <li><a class="nav-link" href="privacy-policy"><i class="far fa fa-file-signature"></i> <span>Privacy Policy</span></a></li>                    
                </ul>
                <?php
                    if (isset($_SESSION['loggedin'])) {
                        echo '
                        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                            <form action="" method="post">
                                <button class="btn btn-primary" style="width:100%;" name="sign-out">SIGN OUT</button>
                            </form>
                        </div>';
                    }
                ?>
            </aside>
        </div>
        <style>
            .nav-link .fa{
                margin-left: 4px !important;
                font-size: 13px;
                font-weight: 900 !important;
            }
        </style>
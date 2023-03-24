<!-- Start app top navbar -->
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="assets/img/avatar/avatar.jpg" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">Hi, <?php if (isset($_SESSION['admin_loggedin'])) { echo $_SESSION['username'];}else{ echo "User";} ?></div></a>
                </li>
            </ul>
        </nav>

        <!-- Start main left sidebar menu -->
        <div class="main-sidebar sidebar-style-3">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="/">Admin Panel</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="/">SG</a>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="/" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>

                    <li class="menu-header">Orders</li>
                    <?php
                        $Header_New_Orders = "SELECT * FROM _allorders WHERE status != 'delivered' OR status != 'cancelled'";
                        $Header_Shipped_Orders = "SELECT * FROM _allorders WHERE status = 'shipped'";
                        $Header_New_Orders_Result = $con->query($Header_New_Orders);
                        $Header_Shipped_Orders_Result = $con->query($Header_Shipped_Orders);
                        $header_new_orders_count = mysqli_num_rows($Header_New_Orders_Result);
                        $header_shipped_orders_count = mysqli_num_rows($Header_Shipped_Orders_Result);
                    ?>
                    <li><a class="nav-link" href="order"><i class="fa fa-shipping-fast"></i> <span>(<?php echo $header_new_orders_count;?>) New Orders</span></a></li>
                    <li><a class="nav-link" href="order?shipped"><i class="fa fa-shipping-fast"></i> <span>(<?php echo $header_shipped_orders_count;?>) Shipped Orders</span></a></li>

                    <li class="menu-header">Products</li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="nav-link has-dropdown"><i class="fa fa-parachute-box"></i> <span>Products</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="upload-product">Upload Product</a></li>
                            <li><a class="nav-link" href="update-product">Update Product</a></li>
                        </ul>
                    </li>

                    <li class="menu-header">Others</li>
                    <?php
                        $HeaderOpenDisputes = "SELECT * FROM _disputes WHERE status = 'open'";
                        $HeaderActiveDisputes = "SELECT * FROM _disputes WHERE status = 'active'";
                        $HeaderOpenDisputesResult = $con->query($HeaderOpenDisputes);
                        $HeaderActiveDisputesResult = $con->query($HeaderActiveDisputes);
                        $headeropendisputecount = mysqli_num_rows($HeaderOpenDisputesResult);
                        $headeractivedisputecount = mysqli_num_rows($HeaderActiveDisputesResult);
                    ?>
                    <li><a class="nav-link" href="disputes?open"><i class="fa fa-file"></i> <span>(<?php echo $headeropendisputecount; ?>) Open Disputes</span></a></li>
                    <li><a class="nav-link" href="disputes?active"><i class="fa fa-file"></i> <span>(<?php echo $headeractivedisputecount; ?>) Active Disputes</span></a></li>
                    <li><a class="nav-link" href="terms-and-conditions"><i class="fa fa-file-contract"></i> <span>Terms and Conditions</span></a></li>
                    <li><a class="nav-link" href="update-currencies"><i class="fa fa-usd"></i> <span>Update Currencies</span></a></li>
                                      
                </ul>
                
            </aside>
        </div>
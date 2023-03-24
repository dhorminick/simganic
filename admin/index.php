<?php
    session_start();
    include '_layout/_dbconnection.php';
    
    if (!isset($_SESSION['admin_loggedin'])) {
        header('Location: sign-in?redirect=/');    
    }

    $myquery = "SELECT * FROM dummy GROUP BY products_id ORDER BY id";
    $query = $con->query($myquery);
    $myquery2 = "SELECT * FROM dummy GROUP BY products_id ORDER BY id";
    $query2 = $con->query($myquery2);
    
    /*$data = array();

    for ($x = 0; $x < mysqli_num_rows($query); $x++) {
      $data[] = mysqli_fetch_assoc($query);
        //echo $data["products_id"].',';
    }

    echo json_encode($data);*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Dashboard - SimGanic Admin</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.min.css">
<link rel="stylesheet" href="assets/css/components.min.css">
<link rel="stylesheet" href="assets/css/mystyle.css">
<script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-data-adapter.min.js"></script>
</head>

<body class="layout-1">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        
        <?php include '_layout/_header_sidebar_admin.php';?>
        
        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Admin Dashboard</h1>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Verified Users</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $TotalUsers = "SELECT * FROM _users WHERE isverified = true";
                                        $TotalUsersResult = $con->query($TotalUsers);
                                        $usercount = mysqli_num_rows($TotalUsersResult);
                                        echo $usercount;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="disputes">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-newspaper"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Open Dispute</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $TotalDisputes = "SELECT * FROM _disputes WHERE status = 'open'";
                                        $TotalDisputesResult = $con->query($TotalDisputes);
                                        $disputecount = mysqli_num_rows($TotalDisputesResult);
                                        echo $disputecount;
                                    ?>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="order">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-archive"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>New Orders</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $TotalOrders = "SELECT * FROM _allorders WHERE status != 'delivered'";
                                        $TotalOrdersResult = $con->query($TotalOrders);
                                        $ordercount = mysqli_num_rows($TotalOrdersResult);
                                        echo $ordercount;
                                    ?>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="order?shipped">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Shipped Delivery</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $ShippedDeliveries = "SELECT * FROM _allorders WHERE status = 'shipped'";
                                        $ShippedDeliveriesResult = $con->query($ShippedDeliveries);
                                        $deliverycount = mysqli_num_rows($ShippedDeliveriesResult);
                                        echo $deliverycount;
                                    ?>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>              
                </div>

                <div class="row row-deck">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Monthly Sales Chart</h4>
                                <!--<div class="card-options">
                                    <button class="btn btn-sm btn-outline-secondary mr-1" id="one_month">1M</button>
                                    <button class="btn btn-sm btn-outline-secondary mr-1" id="six_months">6M</button>
                                    <button class="btn btn-sm btn-outline-secondary mr-1" id="one_year" class="active">1Y</button>
                                    <button class="btn btn-sm btn-outline-secondary mr-1" id="ytd">YTD</button>
                                    <button class="btn btn-sm btn-outline-secondary" id="all">ALL</button>
                                </div>-->
                            </div>
                            <div class="card-body">
                                <div id="monthly-graph"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card gradient-bottom">
                            <div class="card-header">
                                <h4>Top Selling Products</h4>
                                <div class="card-header-action dropdown show-bg">
                                    <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle" aria-expanded="false">Month</a>
                                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(77px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <li class="dropdown-title">Select Period</li>
                                    <li><a href="#" class="dropdown-item">Today</a></li>
                                    <li><a href="#" class="dropdown-item">Week</a></li>
                                    <li><a href="#" class="dropdown-item active">Month</a></li>
                                    <li><a href="#" class="dropdown-item">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" id="top-5-scroll" tabindex="2" style="height: 315px; overflow: hidden; outline: none;">
                            <ul class="list-unstyled list-unstyled-border">
                                <?php
                                    $TopSellers = "SELECT * FROM dummy2 GROUP BY sale_id ORDER BY sum(_value) DESC LIMIT 5";
                                    $TopSellersResult = $con->query($TopSellers);
                                    $rowcount = mysqli_num_rows($TopSellersResult);
                                    while ($row = mysqli_fetch_assoc($TopSellersResult)) {
                                    if ($TopSellersResult -> num_rows > 0 ) { 
                                        $p_id = $row['user'];
                                        $size = $row['size'];
                                    
                                        $sum = "SELECT sum(_value) AS sumTotal FROM dummy2 WHERE user = '$p_id' AND size = '$size'";
                                        $sumResult = $con->query($sum);
                                        foreach ($con->query($sum) as $rows) {
                                            if ($sumResult->num_rows > 0) {
                                                $totalBought = $rows["sumTotal"];

                                                //$total_in_user_currency = $total;
                                            }else{
                                                echo "Error";
                                            } 
                                        }
                                        //$noBought = $row['value'];

                                        $GetProductDetails = "SELECT * FROM product_details WHERE product_id = '$p_id'";
                                        $ProductDetailsResult = $con->query($GetProductDetails);
                                        if ($ProductDetailsResult->num_rows > 0) {
                                            // output data of each row
                                            $prow = $ProductDetailsResult->fetch_assoc();
                                            $p_img = $prow["product_img"];
                                            $p_name = $prow["product_name"];
                                            $p_link = $prow["product_link"];
                                        }
                                ?>
                                <li class="media">
                                    <img class="mr-3 rounded" width="55" src="assets/img/products/<?php echo $p_img;?>" alt="product">
                                    <div class="media-body">
                                        <div class="media-title"><?php echo $p_name; ?> (<?php echo $size; ?>)</div>
                                        <div class="font-weight-600 text-muted text-small"><?php echo $totalBought; ?> Sales</div>
                                    </div>
                                </li>
                                <?php }}?>
                            </ul>
                            </div>
                            <div class="card-footer pt-3 d-flex justify-content-center">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-deck">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Order Invoices</h4>
                                <div class="card-header-action">
                                    <a href="order" class="btn btn-danger show-bg">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                    <tbody><tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                        $AllOrders = "SELECT * FROM _allorders WHERE status != 'delivered' LIMIT 5";
                                        $AllOrdersResult = $con->query($AllOrders);
                                        if ($AllOrdersResult -> num_rows > 0) {
                                            while($row = mysqli_fetch_array($AllOrdersResult)){
                                                $invoice = $row["invoice"];
                                                $name = $row["name"];
                                                //$items = $row["items"];
                                                $date = $row["_date"];
                                                $status = $row["status"];

                                                switch ($status) {
                                                    case 'unpaid':
                                                        $btn_class = "badge-warning";
                                                        break;

                                                    case 'paid':
                                                        $btn_class = "badge-light";
                                                        break;

                                                    case 'shipped':
                                                        $btn_class = "badge-warning";
                                                        break;

                                                    default:
                                                        $btn_class = "badge-primary";
                                                        break;
                                                }
                                    ?>

                                    <tr>
                                        <td><a href="order?order-id=<?php echo crc32($invoice); ?>"><?php echo $invoice; ?></a></td>
                                        <td class="font-weight-600"><?php echo $name; ?></td>
                                        <td><div class="badge <?php echo $btn_class; ?>"><?php echo ucwords($status); ?></div></td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                        <a href="order?order-id=<?php echo crc32($invoice); ?>" class="btn btn-primary">Details <i class="fas fa-arrow-right"></i></a>
                                        </td>
                                    </tr>

                                    <?php }}else{ ?>
                                       <tr><td><h4>No Orders Yet!</h4></td></tr>
                                    <?php } ?>
                                    </tbody></table>
                                    <div style="margin-left:25px;margin-bottom:10px;display:none;">
                                        Showing <strong>1 - 10</strong> of <strong>10</strong> orders <div class="bullet"></div> <a href="#" class="btn btn-danger">View All <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-hero">
                            <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="card-description"><h4><?php echo $disputecount; ?></h4> Customers need help</div>
                            </div>
                            <div class="card-body p-0">
                            <div class="tickets-list">
                            <?php
                                $AllDisputes = "SELECT * FROM _disputes WHERE status = 'open' ORDER BY timestamp DESC LIMIT 5";
                                $AllDisputesResult = $con->query($AllDisputes);
                                if ($AllDisputesResult -> num_rows > 0) {
                                    include '_layout/_time_ago.php';
                                    while($d_row = mysqli_fetch_array($AllDisputesResult)){
                                        $disputeHeader = $d_row["dispute_header"];
                                        $disputeId = $d_row["dispute_id"];
                                        $disputeEmail = $d_row["dispute_email"];
                                        $time = $d_row["timestamp"];
                            ?>    
                                <a href="disputes?dispute-id=<?php echo crc32($disputeId); ?>" class="ticket-item">
                                    <div class="ticket-title">
                                        <h4><?php echo $disputeHeader; ?></h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div><?php echo $disputeEmail; ?></div>
                                        <div class="bullet"></div>
                                        <div class="text-primary"><?php echo TimeAgo($time, date("Y-m-d H:i:s")); ?></div>
                                    </div>
                                </a>
                            <?php }}else{ ?>
                                <a class="ticket-item">
                                No Open Disputes
                                </a>
                            <?php } ?>
                                <a href="disputes" class="ticket-item ticket-more">
                                View All <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                            </div>
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
<script src="assets/modules/apexcharts/apexcharts.min.js"></script>

<!-- Page Specific JS File -->
<script src="js/page/modules-apex.js"></script>
<script type="text/javascript">
    // Basic Bar
    $(document).ready(function() {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                },
            },
            colors: ['#5a5278'],
            grid: {
                yaxis: {
                    lines: {
                        show: true,
                    }
                },
                xaxis: {
                    lines: {
                        show: true,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            plotOptions: {
                bar: {
                    vertical: true, //vertical to realign it
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Net Sales',
                data: [<?php while ($row = mysqli_fetch_array($query)) { echo $row["price"].', '; }?>]
            }],
            yaxis: {
                title: {
                    text: 'Net Sales (Product)'
                }
            },
            xaxis: {
                categories: [<?php while ($row2 = mysqli_fetch_array($query2)) { echo "'".substr($row2["products_id"],0,3)."', "; }?>],
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Product(s)"
                    }
                }
            }
        }

       var chart = new ApexCharts(
            document.querySelector("#monthly-graph"),
            options
        );
        
        chart.render();
    });

</script>

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
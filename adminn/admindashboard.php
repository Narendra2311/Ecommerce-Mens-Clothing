<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    // Redirect to the login page or display an error message
    header('location: ../adminlogin.php');
    exit;
}

require_once '../db.php';

// Retrieve the admin's email from the session
$adminEmail = $_SESSION['admin_email'];

// Fetch the admin's name and image using a SQL query
$sql = "SELECT admin_name, profile_img FROM admin WHERE admin_emailid = '$adminEmail'";
$result = mysqli_query($con, $sql);

if ($result) {
    $adminData = mysqli_fetch_assoc($result);
    $adminName = $adminData['admin_name'];
    $adminImage = $adminData['profile_img'];
}

// Fetch the updated customer count from the database
$sqlGetCount = "SELECT COUNT(c_id) AS total_customers FROM customer";
$resultGetCount = $con->query($sqlGetCount);

if ($resultGetCount && mysqli_num_rows($resultGetCount) > 0) {
    $row = mysqli_fetch_assoc($resultGetCount);
    $totalCustomers = $row['total_customers'];
} else {
    $totalCustomers = 0; // Default to 0 if there's an error or no count in the database
}

// Fetch total sales from the orders table
$sqlTotalSales = "SELECT SUM(order_total) AS total_sales FROM orders";
$resultTotalSales = $con->query($sqlTotalSales);

if ($resultTotalSales && mysqli_num_rows($resultTotalSales) > 0) {
    $rowSales = mysqli_fetch_assoc($resultTotalSales);
    $totalSales = $rowSales['total_sales'];
} else {
    $totalSales = 0; // Default to 0 if there's an error or no sales in the database
}

// Fetch total product manager from the orders table
$sqlTotalmanager = "SELECT COUNT(pm_id) AS total_manager FROM product_manager";
$resultTotalmanager = $con->query($sqlTotalmanager);

if ($resultTotalmanager && mysqli_num_rows($resultTotalmanager) > 0) {
    $rowSales = mysqli_fetch_assoc($resultTotalmanager);
    $totalmanager = $rowSales['total_manager'];
} else {
    $totalSales = 0; // Default to 0 if there's an error or no sales in the database
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- inject:css -->
        <link rel="stylesheet" href="css/style.css">
        <!-- endinject -->
        <link rel="shortcut icon" href="images/logo.jpg" />
    </head>
    <body>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.jpg" style="width: 60px; height: 60px" alt="logo"/>Admin</a>
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-stretch">

                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <div class="nav-profile-img">
                                    <img src="../adminn/images/faces/<?php echo $adminImage; ?>" alt="image">
                                </div>
                                <div class="nav-profile-text">
                                     <p class="mb-1 text-black"><?php echo $adminName; ?></p>
                                </div>
                            </a>
                            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../adminn/signout.php">
                                    <i class="mdi mdi-logout mr-2 text-primary"></i>
                                    Signout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <a href="#" class="nav-link">
                                <div class="nav-profile-image">
                                    <img src="../adminn/images/faces/<?php echo $adminImage; ?>" alt="image">
                                </div>
                                <div class="nav-profile-text d-flex flex-column">
                                    <span class="font-weight-bold mb-2"><?php echo $adminName; ?></span>
                                    <span class="text-secondary text-small">Admin</span>
                                </div>
                                <!--<i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>-->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admindashboard.php">
                                <span class="menu-title">Dashboard</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer.php">
                                <span class="menu-title">Customer</span>
                                <i class="mdi mdi-contacts menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deliveryboy.php">
                                <span class="menu-title">Delivery Boy</span>
                                <i class="mdi mdi-contacts menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="productmanager.php">
                                <span class="menu-title">Product manager</span>
                                <i class="mdi mdi-contacts menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#employee-pages" aria-expanded="false" aria-controls="report-pages">
                                <span class="menu-title">Employee Managment</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                            <div class="collapse" id="employee-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="addemployee.php">Add Employee</a></li>
                                    <li class="nav-item"><a class="nav-link" href="updateemployee.php">Update Employee</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewcategory.php">
                                <span class="menu-title">category</span>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewproducts.php">
                                <span class="menu-title">Products</span>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#report-pages" aria-expanded="false" aria-controls="report-pages">
                                <span class="menu-title">Report</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                            <div class="collapse" id="report-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="orderreport.php">Order Report</a></li>
                                    <li class="nav-item"><a class="nav-link" href="productreport.php">Product Report</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>

                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-home"></i>                 
                                </span>
                                Dashboard
                            </h3>
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span></span>Overview
                                        <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Total Sales
                                            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5">&#8377;<?php echo $totalSales; ?></h2>
                                        <!--<h6 class="card-text">Increased by 60%</h6>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-danger card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Registered Customers
                                            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?php echo $totalCustomers; ?></h2>
                                        <!--<h6 class="card-text">Increased by 60%</h6>-->
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-danger card-img-holder text-white">
                                    <div class="card-body">
                                        <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h4 class="font-weight-normal mb-3">Total Manager
                                            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5"><?php echo $totalmanager; ?></h2>
                                        <!--<h6 class="card-text">Increased by 60%</h6>-->
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- partial -->
                    </div>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
            <!-- container-scroller -->

            <!-- plugins:js -->
            <script src="vendors/js/vendor.bundle.base.js"></script>
            <script src="vendors/js/vendor.bundle.addons.js"></script>
            <!-- endinject -->
            <!-- Plugin js for this page-->
            <!-- End plugin js for this page-->
            <!-- inject:js -->
            <script src="js/off-canvas.js"></script>
            <script src="js/misc.js"></script>
            <!-- endinject -->
            <!-- Custom js for this page-->
            <script src="js/dashboard.js"></script>
            <!-- End custom js for this page-->
    </body>

</html>

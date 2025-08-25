<?php
require_once '../db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['manager_email'])) {
    // Redirect to the login page or display an error message
    header('location: ../productmanagerlogin.php');
    exit;
}

// Retrieve the admin's email from the session
$managerEmail = $_SESSION['manager_email'];

// Fetch the admin's name and image using a SQL query
$sql = "SELECT pm_name, profile_img FROM product_manager WHERE pm_emailid = '$managerEmail'";
$result = mysqli_query($con, $sql);

if ($result) {
    $managerData = mysqli_fetch_assoc($result);
    $managerName = $managerData['pm_name'];
    $managerImage = $managerData['profile_img'];
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Product Manager</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- inject:css -->
        <link rel="stylesheet" href="css/style.css">
        <!-- endinject -->
        <link rel="shortcut icon" href="images/logo.jpg" />
        <style>
            .color-circle {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                margin-right: 5px;
                display: inline-block;
            }
        </style>

    </head>
    <body>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.jpg" style="width: 60px; height: 60px" alt="logo"/>Product Manager</a>
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <div class="nav-profile-img">
                                    <img src="../manager/images/faces/<?php echo $managerImage; ?>" alt="image">
                                </div>
                                <div class="nav-profile-text">
                                     <p class="mb-1 text-black"><?php echo $managerName; ?></p>
                                </div>
                            </a>
                            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../manager/signout.php">
                                    <i class="mdi mdi-logout mr-2 text-primary"></i>
                                    Signout
                                </a>
                            </div>
                        </li>
                        <!--<li class="nav-item d-none d-lg-block full-screen-link">
                          <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                          </a>-->
                        </li>

                        <!--<li class="nav-item nav-logout d-none d-lg-block">
                          <a class="nav-link" href="#">
                            <i class="mdi mdi-power"></i>
                          </a>
                        </li>
                        <li class="nav-item nav-settings d-none d-lg-block">
                          <a class="nav-link" href="#">
                            <i class="mdi mdi-format-line-spacing"></i>
                          </a>
                        </li>-->
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
                                    <img src="../manager/images/faces/<?php echo $managerImage; ?>" alt="image">
                                </div>
                                <div class="nav-profile-text d-flex flex-column">
                                    <span class="font-weight-bold mb-2"><?php echo $managerName; ?></span>
                                    <span class="text-secondary text-small">Product Manager</span>
                                </div>
                                <!--<i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>-->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
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
                            <a class="nav-link" data-toggle="collapse" href="#category-pages" aria-expanded="false" aria-controls="category-pages">
                                <span class="menu-title">Category</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                            <div class="collapse" id="category-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="category.php">Add Category</a></li>
                                    <li class="nav-item"><a class="nav-link" href="viewcategory.php">View category</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#product-pages" aria-expanded="false" aria-controls="product-pages">
                                <span class="menu-title">Product</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                            <div class="collapse" id="product-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="products.php">Add products</a></li>
                                    <li class="nav-item"><a class="nav-link" href="viewproducts.php">View products</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="inventory.php">
                                <span class="menu-title">Inventory</span>
                                <i class="mdi mdi-home menu-icon"></i>
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
                        <!--<li class="nav-item">
                          <a class="nav-link" href="pages/charts/chartjs.html">
                            <span class="menu-title">Charts</span>
                            <i class="mdi mdi-chart-bar menu-icon"></i>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="pages/tables/basic-table.html">
                            <span class="menu-title">Tables</span>
                            <i class="mdi mdi-table-large menu-icon"></i>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                            <span class="menu-title">Sample Pages</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-medical-bag menu-icon"></i>
                          </a>
                          <div class="collapse" id="general-pages">
                            <ul class="nav flex-column sub-menu">
                              <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                              <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                              <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                              <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                              <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                            </ul>
                            </div>
                        </li>-->

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
                                Products
                            </h3>

                        </div>
                        <!-- Customer Details View-->    
                        <div class="col-lg-20  grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Product Details</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>P-ID</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>MRP</th>
                                                    <th>Discount</th>
                                                    <th>Price</th>
                                                    <!--<th>Brand</th>-->
                                                    <th>Size</th>
                                                    <th>Colour</th>
                                                    <th>Quantity</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../db.php';
                                                $sql = "SELECT p.*, c.cat_name, GROUP_CONCAT(DISTINCT s.size_name) AS product_sizes, GROUP_CONCAT(DISTINCT pi.image_filename) AS product_images, GROUP_CONCAT(DISTINCT pi.p_color) AS product_colors
                                                        FROM product p
                                                        INNER JOIN category c ON p.cat_id = c.cat_id
                                                        LEFT JOIN product_sizes ps ON p.p_id = ps.product_id
                                                        LEFT JOIN sizes s ON ps.size_id = s.size_id
                                                        LEFT JOIN product_images pi ON p.p_id = pi.p_id
                                                        GROUP BY p.p_id";
                                                $result = mysqli_query($con, $sql);
                                                if ($result) {
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_object()) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $row->p_id ?></td>
                                                                <td><?php echo $row->p_name ?></td>
                                                                <td><?php echo $row->p_description ?></td>
                                                                <td><?php echo $row->cat_name ?></td>
                                                                <td><?php echo $row->p_mrp ?></td>
                                                                <td><?php echo $row->p_discount ?></td>
                                                                <td><?php echo $row->p_discountprice ?></td>
                                                                <td><?php echo $row->product_sizes ?></td>
                                                                <!-- Assuming you have fetched product data from the database -->
                                                                <td>
                                                                    <?php
                                                                    // Check if there are product colors
                                                                    if (!empty($row->product_colors)) {
                                                                        $colors = explode(',', $row->product_colors);
                                                                        foreach ($colors as $color) {
                                                                            ?>
                                                                            <div class="color-circle" style="background-color: <?php echo $color; ?>"></div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $row->p_quantity ?></td>
                                                                <td>
                                                                    <?php
                                                                    // Check if there are images for the product
                                                                    if (!empty($row->product_images)) {
                                                                        $images = explode(',', $row->product_images);
                                                                        foreach ($images as $image) {
                                                                            $imagePath = 'c://xampp//htdocs//mallt//image//' . $image;
                                                                            $imageData = base64_encode(file_get_contents($imagePath));
                                                                            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                                            $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                                                                            ?>
                                                                            <img src="<?php echo $imageBase64; ?>" alt="Product Image" width="100">
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <a href="editproducts.php?p_id=<?php echo $row->p_id ?>" class="btn btn-outline-primary">Update</a>
                                                                    <a href="deleteproducts.php?p_id=<?php echo $row->p_id ?>" class="btn btn-outline-danger">Delete</a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo 'No Records Found';
                                                    }
                                                } else {
                                                    echo 'Error: ' . mysqli_error($con);
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customer Details View ends-->  
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

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

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
$resultadmin = mysqli_query($con, $sql);

if ($resultadmin) {
    $adminData = mysqli_fetch_assoc($resultadmin);
    $adminName = $adminData['admin_name'];
    $adminImage = $adminData['profile_img'];
}
// Query to retrieve category names for filter dropdown
$sqlGetCategories = "SELECT cat_id, cat_name FROM category";
$resultGetCategories = $con->query($sqlGetCategories);

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
                    <div class="container">
                        <h2>Product Report</h2>
                        <div class="form-group">
                            <label for="categoryFilter">Filter by Category:</label>
                            <select class="form-control" id="categoryFilter">
                                <option value="">All</option>
                                <?php
                                if ($resultGetCategories && mysqli_num_rows($resultGetCategories) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultGetCategories)) {
                                        echo "<option value='" . $row['cat_name'] . "'>" . $row['cat_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div style="overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>MRP</th>
                                        <th>Discount</th>
                                        <th>Discounted Price</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Quantity in Stock</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require '../db.php';
                                    $sql = "SELECT p.*, c.cat_name, GROUP_CONCAT(DISTINCT s.size_name) AS product_sizes,
                                            GROUP_CONCAT(DISTINCT pi.p_color) AS image_colors,
                                            GROUP_CONCAT(DISTINCT pi.image_filename) AS product_images
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
                                                    <td>
                                                        <?php
                                                        // Check if there are product colors
                                                        if (!empty($row->image_colors)) {
                                                            $colors = explode(',', $row->image_colors);
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
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

                    <!-- partial -->
                </div>
            </div>
        </div>
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
<script>
            $(document).ready(function () {
                // Function to filter the table based on the selected category
                function filterTable() {
                    var selectedCategory = $("#categoryFilter").val();

                    // Hide all table rows
                    $("table tbody tr").hide();

                    // Show rows that match the selected category or show all rows if "All" is selected
                    if (selectedCategory === "") {
                        $("table tbody tr").show();
                    } else {
                        $("table tbody tr:has(td:nth-child(4):contains('" + selectedCategory + "'))").show();
                    }
                }

                // Listen for changes in the select element and filter the table accordingly
                $("#categoryFilter").on("change", filterTable);

                // Initially filter the table based on the default selected option
                filterTable();
            });
        </script>
    </body>

</html>

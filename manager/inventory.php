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
$result1 = mysqli_query($con, $sql);

if ($result1) {
    $managerData = mysqli_fetch_assoc($result1);
    $managerName = $managerData['pm_name'];
    $managerImage = $managerData['profile_img'];
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
        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                        <div class="col-lg-20  grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Product Details</h4>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cat-ID</th>
                                                <th>Cat-Name</th>
                                                <th>P-ID</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <!--<th>Brand</th>-->
                                                <th>Quantity</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require '../db.php';
                                           $sql = "SELECT p.*, c.cat_name, GROUP_CONCAT(DISTINCT s.size_name) AS product_sizes, GROUP_CONCAT(DISTINCT pi.image_filename) AS product_images
        FROM product p
        INNER JOIN category c ON p.cat_id = c.cat_id
        LEFT JOIN product_sizes ps ON p.p_id = ps.product_id
        LEFT JOIN sizes s ON ps.size_id = s.size_id
        LEFT JOIN product_images pi ON p.p_id = pi.p_id
        GROUP BY p.p_id";

                                            $result = mysqli_query($con, $sql);
                                            if ($result == $con->query($sql)) {
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_object()) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row->cat_id ?></td>
                                                            <td><?php echo $row->cat_name ?></td>
                                                            <td> <?php echo $row->p_id ?></td>
                                                            <td><?php echo $row->p_name ?></td>
                                                            <td><?php echo $row->p_mrp ?></td>
                                                            <!--<td><?php echo $row->b_name ?></td>-->
                                                            <td id="quantityCell<?php echo $row->p_id ?>"><?php echo $row->p_quantity ?></td>

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
                                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#productModal<?php echo $row->p_id; ?>">Update Quantity</a>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="productModal<?php echo $row->p_id; ?>" tabindex="-1" role="dialog" aria-labelledby="productModalLabel<?php echo $row->p_id; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="productModalLabel<?php echo $row->p_id; ?>">Update Quantity</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p><strong>Product Quantity:</strong></p>
                                                                                <input type="number" id="newQuantity<?php echo $row->p_id; ?>" min="1">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="button" class="btn btn-primary" onclick="updateQuantity(<?php echo $row->p_id; ?>)">Update Quantity</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo'No Records Found';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
        <!-- ... Your existing HTML and JavaScript code ... -->
<script>
   function updateQuantity(productId) {
    var newQuantity = $('#newQuantity' + productId).val();

    // Make an AJAX request to update_quantity.php
    $.post('update_quantity.php', {
        productId: productId,
        newQuantity: newQuantity
    }, function(response) {
        // Handle the response from update_quantity.php
        console.log(response);

        // Close the modal
        $('#productModal' + productId).modal('hide');

        // Optionally, you can update the quantity displayed on the page.
        // For example, you can locate the corresponding table cell and update its content.
        $('#quantityCell' + productId).text(newQuantity);

        // Reload the page after a short delay (e.g., 1 second)
         setTimeout(function() {
            location.reload();
        }, 100); // 100 milliseconds = 0.1 second
    });
}

</script>


    </body>

</html>

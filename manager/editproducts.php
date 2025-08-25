<?php
require '../db.php';
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
$id = $_GET['p_id'];
$sql = "select * from product where p_id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                                <a class="dropdown-item" href="#">
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
                            <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                                <span class="menu-title">Category</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-medical-bag menu-icon"></i>
                            </a>
                            <div class="collapse" id="general-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="category.php"> Add Category</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="viewcategory.php"> View category</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                                <span class="menu-title">Product</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="products.php">Add products</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="viewproducts.php">View products</a></li>
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
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">

                        <!--content-->
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-home"></i>                 
                                </span>
                                Edit Products
                            </h3>

                        </div>          
                        <div class="col-md-8 offset-2 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Product</h4>
                                    <br>
                                    <form class="forms-sample" method="post" action="" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Name</label><br>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="pname" placeholder="Product name" value="<?php echo $row['p_name']; ?>" pattern="^[A-Za-z\s]*$" title="Category name must start with a capital letter and contain only alphabets." required oninput="this.value = this.value.replace(/[^A-Za-z]/g, ''); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Description</label><br>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="pdiscp" value=<?php echo $row['p_description'] ?> placeholder="Product Description"  placeholder="Category name" pattern="^[A-Z][a-zA-Z]*$" title="Category name must start with a capital letter and contain only alphabets." required oninput="this.value = this.value.replace(/[^A-Za-z]/g, ''); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">
                                        </div>
                                        <div class="form-group">
                                            <label for="categorySelect">Select Category</label>
                                            <select class="form-control" id="categorySelect" name="cat_id">
                                                <!-- Populate the select options with categories from your database -->
                                                <?php
                                                $sqlCategories = "SELECT * FROM category";
                                                $resultCategories = mysqli_query($con, $sqlCategories);

                                                while ($category = mysqli_fetch_assoc($resultCategories)) {
                                                    $selected = ($category['cat_id'] == $row['cat_id']) ? 'selected' : '';
                                                    echo "<option value='{$category['cat_id']}' $selected>{$category['cat_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product MRP</label><br>
                                            <input type="tel" class="form-control" id="productmrp" name="pmrp" placeholder="Product MRP" value=<?php echo $row['p_mrp'] ?> maxlength="10" pattern="^[0-9]+$" title="Product MRP must contain only numbers." oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateDiscountedPrice();">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Discount</label><br>
                                            <input type="number" class="form-control" id="productdiscount" name="pdiscount" value="<?php echo $row['p_discount'] ?>"  placeholder="Product Discount" oninput="this.value = Math.min(Math.max(this.value, 1), 100); calculateDiscountedPrice();">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Discounted Price</label><br>
                                            <input type="tel" class="form-control" id="discountedPrice" name="pdiscprice" value="<?php echo $row['p_discountprice'] ?>"  placeholder="Price after Discount" maxlength="10" readonly>
                                        </div>
                                        <script>
                                            function calculateDiscountedPrice() {
                                                const mrp = parseFloat(document.getElementById('productmrp').value);
                                                const discount = parseFloat(document.getElementById('productdiscount').value);
                                                const discountedPrice = Math.max(mrp - (mrp * discount / 100), 1); // Ensure the discounted price is not negative
                                                document.getElementById('discountedPrice').value = discountedPrice.toFixed(2);
                                            }

                                            document.getElementById('productmrp').addEventListener('input', calculateDiscountedPrice);
                                            document.getElementById('productdiscount').addEventListener('input', calculateDiscountedPrice);
                                        </script>
                                        <button type="submit" class="btn btn-gradient-primary mr-2" name="btn">Submit</button>
                                        <button type="reset" class="btn btn-gradient-primary mr-2" name="btn1">Reset</button>
                                    </form>
                                    <?php
                                    require '../db.php';

                                    if (isset($_POST['btn'])) { // Assuming you have a hidden input field for the product ID
                                        $catid = $_POST['cat_id'];
                                        $pname = $_POST['pname'];
                                        $pdiscp = $_POST['pdiscp'];
                                        $pmrp = $_POST['pmrp'];
                                        $pdiscount = $_POST['pdiscount'];
                                        $pdiscprice = $_POST['pdiscprice'];

                                        // Update product details in the 'product' table
                                        $sqlUpdate = "UPDATE product SET p_name=?, p_description=?, p_mrp=?, p_discount=?, p_discountprice=?, cat_id=? WHERE p_id=?";

                                        if ($stmt = $con->prepare($sqlUpdate)) {
                                            $stmt->bind_param("ssdiiii", $pname, $pdiscp, $pmrp, $pdiscount, $pdiscprice, $catid,$product_id);
                                            if ($stmt->execute()) {
                                                echo "<script>alert('Product updated')</script>";
                                            }
                                        } else {
                                            echo "Error updating product: " . mysqli_error($con);
                                        }
                                    } else {
                                        echo "Error preparing update statement: " . mysqli_error($con);
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <!--content ends-->
                    </div>
                </div>

                <!-- main-panel ends -->
            </div>
        </div>

        <!-- page-body-wrapper ends -->
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

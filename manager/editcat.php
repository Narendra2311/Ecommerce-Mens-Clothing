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

$id = $_GET['cat_id'];
// Fetch the existing category information for editing
$sql1 = "SELECT * FROM category WHERE cat_id = $id";
$result = mysqli_query($con, $sql1);
$row = mysqli_fetch_assoc($result);

$updateSuccess = false;

if (isset($_POST['btn'])) {
    // Get the updated category name and description from the form
    $catname = $_POST['catname'];
    $catdesc = $_POST['catdescription'];

    // Check if a new image file has been uploaded
    if ($_FILES['catimage']['name'] !== '') {
        $filename = $_FILES['catimage']['name'];
        $filetmp = $_FILES['catimage']['tmp_name'];

        // Move the uploaded image
        move_uploaded_file($filetmp, "C://xampp//htdocs//mallt//image//" . $filename);

        // Update the category name, description, and image in the database
        $sql2 = "UPDATE category SET cat_name = ?, cat_description = ?, cat_image = ? WHERE cat_id = ?";
        if ($stmt = $con->prepare($sql2)) {
            $stmt->bind_param("sssi", $catname, $catdesc, $filename, $id);
            if ($stmt->execute()) {
                $updateSuccess = true;
            } else {
                // Error message
                // ...
            }
        }
    } else {
        // Update the category name and description in the database (without changing the image)
        $sql2 = "UPDATE category SET cat_name = ?, cat_description = ? WHERE cat_id = ?";
        if ($stmt = $con->prepare($sql2)) {
            $stmt->bind_param("ssi", $catname, $catdesc, $id);
            if ($stmt->execute()) {
                $updateSuccess = true;
            } else {
                // Error message
                // ...
            }
        }
    }
}
?>      

<!-- ... Rest of your HTML code ... -->

<?php if ($updateSuccess): ?>
    <!-- Show success modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Category updated successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#successModal').modal('show');
        });
    </script>
<?php endif; ?>



<!DOCTYPE html>
<html lang="en">

    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
    $(document).ready(function () {
<?php if ($updateSuccess): ?>
            $('#successModal').modal('show');
<?php endif; ?>
    });
        </script>
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
                        <!--<li class="nav-item d-none d-lg-block full-screen-link">
                          <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                          </a>
                        </li>-->

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

                        <!--content-->
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-home"></i>                 
                                </span>
                                Update Category
                            </h3>

                        </div>          
                        <div class="col-md-6 offset-2 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Category</h4>
                                    <br>
                                    <form class="forms-sample" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Category Name</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="catname" value="<?php echo $row['cat_name'] ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputDescription">Category Description</label>
                                            <textarea class="form-control" id="exampleInputDescription" name="catdescription"><?php echo $row['cat_description'] ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputImage">Category Image</label>
                                            <input type="file" class="form-control-file" id="exampleInputImage" name="catimage">
                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary mr-2" name="btn">Update</button>
                                        <a href="viewcategory.php" class="btn btn-outline-primary">Cancel</a>
                                    </form>


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
        <?php
        if (isset($_POST['btn'])) {
            $catname = $_POST['cat_name'];
            $sql3 = "update category set cat_name='$catname'";
            $result = mysqli_query($con, $sql3);
            if ($stmt = $con->prepare($sql3)) {
                $stmt->bind_param("s", $catname);
                $stmt->execute();
                echo "<script>alert('category updated succesfully')</script>";
            }
            ?>
        <div>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    } else {
        ?>

        <?php if ($updateSuccess): ?>
            <!-- Show success modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Category updated successfully.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
}
?>
</body>

</html>

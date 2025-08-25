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
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>

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
                                Add Products
                            </h3>

                        </div>          
                        <div class="col-md-8 offset-2 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add Products</h4>
                                    <br>
                                    <?php
                                    require '../db.php';
                                    if (isset($_POST['btn'])) {
                                        $pname = $_POST['pname'];
                                        $pdiscp = $_POST['pdiscp'];
                                        $catid = $_POST['catid'];
                                        $pmrp = $_POST['pmrp'];
                                        $pdiscount = $_POST['pdiscount'];
                                        $pdiscprice = $_POST['pdiscprice'];
                                        $brandid = $_POST['bid'];
                                        $selectedSizes = $_POST['psize']; // Get the selected sizes as an array
                                        $pqnt = $_POST['pqnt'];
                                        // Insert product details into the 'product' table
                                        $sql2 = "INSERT INTO product (p_name, p_description, cat_id, p_mrp, p_discount, p_discountprice, b_id, p_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                        if ($stmt = $con->prepare($sql2)) {
                                            $stmt->bind_param("sssiiiss", $pname, $pdiscp, $catid, $pmrp, $pdiscount, $pdiscprice, $brandid, $pqnt);
                                            if ($stmt->execute()) {
                                                // Get the last inserted product ID
                                                $lastProductID = $con->insert_id;

                                                // Insert selected sizes into the 'product_sizes' table
                                                $sqlInsertSizes = "INSERT INTO product_sizes (product_id, size_id) VALUES (?, ?)";
                                                foreach ($selectedSizes as $sizeID) {
                                                    if ($stmtSizes = $con->prepare($sqlInsertSizes)) {
                                                        $stmtSizes->bind_param("ii", $lastProductID, $sizeID);
                                                        $stmtSizes->execute();
                                                    } else {
                                                        echo "Error preparing statement for size $sizeID insertion.<br>";
                                                    }
                                                }
                                                // Assuming you have already retrieved the total number of image-color pairs
                                                $numPairs = $_POST['numPairs'];
                                                for ($i = 1; $i <= $numPairs; $i++) {
                                                    $fileFieldName = "pimg" . $i; // Construct the file input field name
                                                    $colorFieldName = "pcolor" . $i; // Construct the color input field name

                                                    if ($_FILES[$fileFieldName]['error'] === UPLOAD_ERR_OK) {
                                                        $filename = $_FILES[$fileFieldName]['name'];
                                                        $filetmp = $_FILES[$fileFieldName]['tmp_name'];

                                                        // Move the uploaded image to a directory
                                                        $uploadPath = "C://xampp//htdocs//mallt//image//" . $filename;
                                                        move_uploaded_file($filetmp, $uploadPath);

                                                        // Get the color associated with this image
                                                        $color = $_POST[$colorFieldName];

                                                        // Insert the image and color into the database
                                                        $sqlInsertImage = "INSERT INTO product_images (p_id, image_filename, p_color) VALUES (?, ?, ?)";
                                                        if ($stmtImage = $con->prepare($sqlInsertImage)) {
                                                            $stmtImage->bind_param("iss", $lastProductID, $filename, $color);
                                                            if ($stmtImage->execute()) {
                                                                // Image and color inserted successfully
                                                            } else {
                                                                echo "Error inserting image and color: " . mysqli_error($con);
                                                            }
                                                        } else {
                                                            echo "Error preparing statement for image insertion: " . mysqli_error($con);
                                                        }
                                                    }
                                                }

                                                echo "<script>alert('Product added')</script>";
                                            } else {
                                                echo "Error: " . mysqli_error($con);
                                            }
                                        } else {
                                            echo "Error preparing statement: " . mysqli_error($con);
                                        }
                                    }
                                    ?>

                                    <!-- Rest of your HTML code remains unchanged -->

                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Name</label><br>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="pname" placeholder="Product name" pattern="^[A-Za-z\s]*$" title="Product name must contain only alphabets and spaces." required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, ''); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Description</label><br>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="pdiscp" placeholder="Product Description" title="Product description must contain only alphabets and spaces." required oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Category</label><br>
                                            <select name="catid" class="form-control">
                                                <?php
                                                require '../db.php';
                                                $sql3 = "select * from category";
                                                $result2 = mysqli_query($con, $sql3);
                                                if ($result2 == $con->query($sql3)) {
                                                    if ($result2->num_rows > 0) {
                                                        while ($row = $result2->fetch_object()) {
                                                            ?>
                                                            <option value="<?php echo $row->cat_id ?>"><?php echo $row->cat_name ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo'No Records Found';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product MRP</label><br>
                                            <input type="tel" class="form-control" id="productmrp" name="pmrp" placeholder="Product MRP" maxlength="10" pattern="^[0-9]+$" title="Product MRP must contain only numbers." oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateDiscountedPrice();">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Discount</label><br>
                                            <input type="number" class="form-control" id="productdiscount" name="pdiscount" placeholder="Product Discount" oninput="this.value = Math.min(Math.max(this.value, 1), 100); calculateDiscountedPrice();">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Discounted Price</label><br>
                                            <input type="tel" class="form-control" id="discountedPrice" name="pdiscprice" placeholder="Price after Discount" maxlength="10" readonly>
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
                                        <!-- ... Other HTML code ... -->

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Brand</label><br>
                                            <select name="bid" class="form-control">
                                                <?php
                                                require '../db.php';
                                                $sql = "select * from brand";
                                                $result = mysqli_query($con, $sql);
                                                if ($result == $con->query($sql)) {
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_object()) {
                                                            ?>
                                                            <option value="<?php echo $row->b_id ?>"><?php echo $row->b_name ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo'No Records Found';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputUsername1"><b>Product Size</b></label><br>
                                            <input type="checkbox"  id="1" name="psize[]" value="1">
                                            <label for="size1">S</label>
                                            <input type="checkbox" id="2" name="psize[]" value="2">
                                            <label for="size2">M</label>
                                            <input type="checkbox" id="3" name="psize[]" value="3">
                                            <label for="size3">L</label>
                                            <input type="checkbox" id="4" name="psize[]" value="4">
                                            <label for="size4">XL</label>
                                            <input type="checkbox" id="5" name="psize[]" value="5">
                                            <label for="size5">XXL</label><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Product Quantity</label><br>
                                            <input type="tel" class="form-control" id="exampleInputUsername1" name="pqnt" placeholder="Product Quantity" maxlength="10">
                                        </div>
                                        <!-- Add a single input field for the total number of image-color pairs -->
                                        <div class="form-group">
                                            <label for="numPairs">Number of Image-Color Pairs:</label><br>
                                            <input type="number" class="form-control" id="numPairs" name="numPairs" min="1" max="5" required>
                                        </div>

                                        <!-- Add a container to dynamically create pairs of file input and color input fields -->
                                        <div id="imageAndColorPairsContainer"></div>

                                        <button type="submit" class="btn btn-gradient-primary mr-2" name="btn">Submit</button>
                                        <button type="reset" class="btn btn-gradient-primary mr-2" name="btn1">Reset</button>
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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const numPairsInput = document.getElementById("numPairs");
                const imageAndColorPairsContainer = document.getElementById("imageAndColorPairsContainer");

                numPairsInput.addEventListener("input", createImageAndColorPairs);

                function createImageAndColorPairs() {
                    const numPairs = parseInt(numPairsInput.value);

                    // Clear previous input fields
                    imageAndColorPairsContainer.innerHTML = "";

                    if (numPairs >= 1 && numPairs <= 5) {
                        for (let i = 1; i <= numPairs; i++) {
                            const imageInput = document.createElement("input");
                            imageInput.type = "file";
                            imageInput.className = "form-control";
                            imageInput.name = "pimg" + i;
                            imageInput.required = true;

                            const colorInput = document.createElement("input");
                            colorInput.type = "text";
                            colorInput.className = "form-control";
                            colorInput.name = "pcolor" + i;
                            colorInput.placeholder = "Enter Color " + i;
                            colorInput.required = true;

                            const br = document.createElement("br");

                            // Append both image and color inputs to the container
                            imageAndColorPairsContainer.appendChild(imageInput);
                            imageAndColorPairsContainer.appendChild(colorInput);
                            imageAndColorPairsContainer.appendChild(br);
                        }
                    } else {
                        alert("Please enter a number between 1 and 5 for the total number of image-color pairs.");
                    }
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const colorPicker = document.getElementById("color-picker");
                const colorField = document.getElementById("color-field"); // Add an input field to store the selected color

                colorPicker.addEventListener("input", function () {
                    const selectedColor = colorPicker.value;
                    console.log("Selected Color: " + selectedColor); // Check if the color is being captured
                    colorField.value = selectedColor; // Set the value of the input field to the selected color
                    console.log("Hidden Field Value: " + colorField.value); // Check if the hidden field is being set correctly
                });
            });

        </script>
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
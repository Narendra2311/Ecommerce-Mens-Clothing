<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    // Redirect to the login page or display an error message
    header('location: ../adminlogin.php');
    exit;
}

require_once '../db.php';
$query = "SELECT orders.order_id, orders.bag_total, orders.bag_discount, orders.delivery_charges, orders.order_total, orders.customer_id, 
          orders.order_date, order_address.street, order_address.city, order_address.zip_code, order_address.state, order_address.country,
          customer.c_name
          FROM orders
          LEFT JOIN order_address ON orders.order_id = order_address.order_id
          LEFT JOIN customer ON orders.customer_id = customer.c_id";
$result = mysqli_query($con, $query);

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

// Initialize the order status filter
$orderStatus = $_POST['orderStatusFilter'] ?? '';

// Initialize the date range filter
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';

// Query to retrieve order data including formatted date
$sqlGetOrders = "SELECT orders.order_id, orders.customer_id, orders.order_date, orders.bag_total, orders.bag_discount, orders.delivery_charges, orders.order_total, order_address.street, order_address.city, order_address.zip_code, order_address.state, order_address.country
                FROM orders
                LEFT JOIN order_address ON orders.order_id = order_address.order_id";

// Add the order status filter if it's selected
if (!empty($orderStatus)) {
    $sqlGetOrders .= " AND order_status = '$orderStatus'";
}

// Add the date range filter if both start and end dates are provided
if (!empty($startDate) && !empty($endDate)) {
    // Convert the selected start and end dates to the "yyyy-mm-dd" format
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));

    $sqlGetOrders .= " AND formatted_date BETWEEN '$startDate' AND '$endDate'";
}

$resultGetOrders = $con->query($sqlGetOrders);
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
                        <h2>Order Report</h2><br><br>
                        <div class="d-flex align-items-center mb-3">
<!--                            <div class="form-group flex-grow-0 mr-3">
                                <label for="orderStatusFilter">Filter by Order Status:</label>
                                <select class="form-control" id="orderStatusFilter">
                                    <option value="">All</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivered">Delivered</option>
                                     Add other order status options as needed 
                                </select>
                            </div>-->
                            <div class="form-group d-flex align-items-center">
                                <label for="startDate" class="mr-2">Start Date:</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="form-group d-flex align-items-center ml-3">
                                <label for="endDate" class="mr-2">End Date:</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                        </div>
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Bag Total</th>
                                <th>Bag Discount</th>
                                <th>Delivery Charges</th>
                                <th>Order Total</th>
                                <th>Order Date</th>
                                <th>Street</th>
                                <th>City</th>
                                <th>Zip Code</th>
                                <th>State</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                         <tbody>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['order_id'] . "</td>";
                                    echo "<td>" . $row['c_name'] . "</td>";
                                    echo "<td>" . $row['bag_total'] . "</td>";
                                    echo "<td>" . $row['bag_discount'] . "</td>";
                                    echo "<td>" . $row['delivery_charges'] . "</td>";
                                    echo "<td>" . $row['order_total'] . "</td>";
                                    echo "<td>" . $row['order_date'] . "</td>";
                                    echo "<td>" . $row['street'] . "</td>";
                                    echo "<td>" . $row['city'] . "</td>";
                                    echo "<td>" . $row['zip_code'] . "</td>";
                                    echo "<td>" . $row['state'] . "</td>";
                                    echo "<td>" . $row['country'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='12'>No orders found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
            // Function to filter the table based on the selected order status and date range
            function filterTable() {
                var selectedStatus = $("#orderStatusFilter").val();
                var startDateStr = $("#startDate").val();
                var endDateStr = $("#endDate").val();

                // Convert the date strings to Date objects
                var startDate = new Date(startDateStr);
                var endDate = new Date(endDateStr);

                // Hide all table rows
                $("table tbody tr").hide();

                // Construct the filter selector based on selected status and date range
                var filterSelector = "table tbody tr";

                if (selectedStatus !== "") {
                    filterSelector += ":has(td:nth-child(4):contains('" + selectedStatus + "'))";
                }

                // Iterate through each row to check the date
                $("table tbody tr").each(function () {
                    var orderDateStr = $(this).find("td:nth-child(5)").text();
                    var orderDate = new Date(orderDateStr);

                    if (
                            (startDateStr === "" || orderDate >= startDate) &&
                            (endDateStr === "" || orderDate <= endDate)
                            ) {
                        $(this).show();
                    }
                });
            }

            // Listen for changes in the select element, start date, and end date
            $("#orderStatusFilter, #startDate, #endDate").on("change", filterTable);

            // Initially filter the table based on the default selected options
            filterTable();
        });
    </script>

    </body>

</html>

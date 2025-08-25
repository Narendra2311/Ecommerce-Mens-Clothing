<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    // Redirect to the login page or display an error message
    header('location: ../adminlogin.php');
    exit;
}

require_once '../db.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mallt/vendors/phpmailer/autoload.php'; // Adjust the path based on your project structure

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form values
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $contactNo = $_POST['contactNo'];
    $salary = $_POST['salary'];
    // You may want to handle file uploads for profile photo and verification document here
    $profilePhoto = $_POST['profilephoto']; // Replace with actual file path
    $verificationDoc = $_POST['verifydoc'];// Replace with actual file path
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert into 'product_manager' table
    $sql = "INSERT INTO product_manager (pm_name, pm_emailid, pm_phonenumber, pm_salary, profile_img, pm_password, verificationdoc_img) 
            VALUES ('$fullName', '$email', '$contactNo', '$salary', '$profilePhoto', '$password', '$verificationDoc')";
    
    $resultpm = mysqli_query($con, $sql);

    if ($resultpm) {
        // Insert successful, retrieve the generated pm_id
        $pmId = mysqli_insert_id($con);

        // Insert into 'product_manager_addresses' table
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $zipCode = $_POST['zipCode'];
        $country = $_POST['country'];

        $sqlAddress = "INSERT INTO product_manager_addresses (pm_id, address, state, city, zip_code, country) 
                       VALUES ('$pmId', '$address', '$state', '$city', '$zipCode', '$country')";
        
        $resultAddress = mysqli_query($con, $sqlAddress);

        if ($resultAddress) {
    // Address insertion successful

    // Send email to the provided email address
    $to = $email;
    $subject = "Welcome to Your Company";
    $message = "Dear $fullName,\n\n";
    $message .= "Your account has been successfully created.\n";
    $message .= "Password: " . $_POST['password'] . "\n";
    $message .= "Thank you for joining!\n";

    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'narendrachoudhary1499@gmail.com'; // Replace with your Gmail email address
        $mail->Password = '157NARU9978728285'; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls'; // Use 'tls' for TLS, 'ssl' for SSL
        $mail->Port = 587; // Use 587 for TLS, 465 for SSL

        // Recipients
        $mail->setFrom('narendrachoudhary1499@gmail.com', 'Your Name'); // Replace with your Gmail email and name
        $mail->addAddress($to, $fullName);

        // Content
        $mail->isHTML(false); // Set to true if you're sending HTML content
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();
        echo "Employee added successfully. An email has been sent to the provided address.";
    } catch (Exception $e) {
        echo "Employee added successfully. However, there was an issue sending the welcome email. Error: {$mail->ErrorInfo}";
    }
}  else {
            // Address insertion failed
            echo "Error adding employee address: " . mysqli_error($con);
        }
    } else {
        // Insert failed
        echo "Error adding employee: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);

    // Prevent the form from being resubmitted on page reload
    exit;
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
        <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script>
            // JavaScript function to validate the form
            function validateName() {
                var fullName = document.getElementById('fullName').value;
                var regex = /^[a-zA-Z\s]+$/;
                if (!regex.test(fullName)) {
                    alert('Please enter a valid name (only characters).');
                    document.getElementById('fullName').value = '';
                }
            }

            function validateEmail() {
                var email = document.getElementById('email').value;
                var regex = /^\S+@\S+\.\S+$/;
                if (!regex.test(email)) {
                    alert('Please enter a valid email address.');
                    document.getElementById('email').value = '';
                }
            }

            function validateContactNo() {
                var contactNo = document.getElementById('contactNo').value;
                var regex = /^[0-9]{1,10}$/;
                if (!regex.test(contactNo)) {
                    alert('Please enter a valid contact number.');
                    document.getElementById('contactNo').value = '';
                }
            }

            function validateSalary() {
                var salary = document.getElementById('salary').value;
                var regex = /^\d{1,6}$/;
                if (!regex.test(salary)) {
                    alert('Please enter a valid salary (maximum 6 digits).');
                    document.getElementById('salary').value = '';
                }
            }

            // You can add similar functions for other fields

            function validateForm() {
                // Call individual field validation functions
                validateName();
                validateEmail();
                validateContactNo();
                validateSalary();

                // Add additional validations as needed

                // If any validation fails, prevent form submission
                return false;
            }

            // Function to populate city dropdown based on selected state
            function populateCityDropdown() {
                var stateDropdown = document.getElementById('state');
                var cityDropdown = document.getElementById('city');

                // Clear existing options
                cityDropdown.innerHTML = '';

                // Define city options based on the selected state
                var cities = [];
                if (stateDropdown.value === 'Delhi') {
                    cities = ['New Delhi', 'Old Delhi', 'North Delhi'];
                } else if (stateDropdown.value === 'Gujarat') {
                    cities = ['Ahmedabad', 'Surat', 'Vadodara'];
                } else if (stateDropdown.value === 'Rajasthan') {
                    cities = ['Jaipur', 'Jodhpur', 'Udaipur'];
                }

                // Populate city dropdown with options
                cities.forEach(function (city) {
                    var option = document.createElement('option');
                    option.value = city;
                    option.text = city;
                    cityDropdown.add(option);
                });
            }
        </script>
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
                                    <i class="mdi mdi-account-plus"></i>                 
                                </span>
                                Add Employee
                            </h3>

                        </div>
                        <div class="col-15 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                   <form class="form-sample" method="post" action="addemployee.php">
                                        <h3 class="card-description">
                                            PERSONAL INFO
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Full Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="fullName" name="fullName" oninput="validateName()" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Email-ID</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="email" name="email" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Contact No.</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="contactNo" name="contactNo" oninput="validateContactNo()"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Salary</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="salary" name="salary" oninput="validateSalary()" maxlength="6" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Profile Photo</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control file-upload-info" id="profilephoto" name="profilephoto" placeholder="Upload Image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Verification Document</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control file-upload-info" id="verifydoc" name="verifydoc" placeholder="Upload Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" name="password" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="card-description">
                                            ADDRESS
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="address"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">State</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="state" name="state" onchange="populateCityDropdown()">
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Gujarat">Gujarat</option>
                                                            <option value="Rajasthan">Rajasthan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Zip code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="zipCode" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">City</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="city" id="city"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Country</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="country">
                                                            <option>INDIA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <center><input type="submit" class="btn btn-gradient-success btn-rounded btn-fw" id="addemployee" value="Add Employee"></center>
                                    </form>
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
            <!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="successModalLabel">Employee added successfully.</h5>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to show success modal and refresh the page after 2 seconds
    function showSuccessModalAndRefresh() {
        $('#successModal').modal('show');
        setTimeout(function () {
            $('#successModal').modal('hide');
            location.reload(); // Refresh the page
        }, 2000); // 2 seconds
    }
</script>

    </body>
</html>

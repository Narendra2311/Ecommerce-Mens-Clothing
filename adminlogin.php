<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="login.css">
        <style>
            
            body {
                background-image: url('uploads/background.jpg'); /* Set the background image URL */
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            /* Style for the error message modal */
            .error-modal {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.8);
                padding: 20px;
                border-radius: 10px;
                color: #fff;
                z-index: 999;
                text-align: center;
            }

            /* Style for the close button in the modal */
            .close-button {
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
                color: #fff;
            }
        </style>
        <script>
            $(document).ready(function () {
                $(".val").keypress(function (e) {
                    var N = e.which;
                    if (N < 48 || N > 57)
                        e.preventDefault();
                });
            });

            // Function to show the error message modal
            function showErrorModal() {
                const errorModal = document.getElementById('errorModal');
                errorModal.style.display = 'block';
            }

            // Function to close the error message modal
            function closeErrorModal() {
                const errorModal = document.getElementById('errorModal');
                errorModal.style.display = 'none';
            }
        </script>
    </head>
    <body>

        <div class="container" id="container">

            <div class="form-container sign-in-container">
                <form method="post" >
                    <h1>Sign in</h1>
                    <input type="email" name="email" placeholder="Email" required="" />
                    <input type="password" name="pswd" placeholder="Password" required="" />
                    <!--<a href="#">Forgot your password?</a>-->
                    <button name="log">Sign In</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error message modal -->
        <div class="error-modal" id="errorModal">
            <span class="close-button" onclick="closeErrorModal()">&times;</span>
            <p>Data is not valid, please check again.</p>
        </div>
        <?php
//Insert into database

        if (isset($_POST['sign'])) {
            $uname = $_POST['name'];
            $mno = $_POST['mobno'];
            $email = $_POST['uemail'];
            $address = $_POST['uadd'];
            $passw = $_POST['password'];

            $sql = "insert into delivery_boy (db_name,db_phonenumber,db_emailid,db_address,db_password) values ('$uname', '$mno', '$email', '$address','$passw')";

            if ($con->query($sql) === TRUE) {
                // echo "New record created successfully";
//            echo '<script>alert("Registered suscefully ")</script>'; 
                header('location:adminthankyou.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif (isset($_POST['log'])) {
            if (empty($_POST['email']) || empty($_POST['pswd'])) {
                echo "pleas fill all details";
            } else {
                $query = "select * from admin where admin_emailid='" . $_POST['email'] . "' and admin_password='" . $_POST['pswd'] . "' ";
                $result = mysqli_query($con, $query);
                if (mysqli_fetch_assoc($result)) {
                    // Start a session
                    session_start();

                    // Store the admin email ID in a session variable
                    $_SESSION['admin_email'] = $_POST['email'];

                    header('location: adminn/admindashboard.php');
                } else {
                    echo "<script>showErrorModal();</script>";
                }
            }
        }
        $con->close();
        ?>
        <script src="login.js"></script>
    </body>
</html>
<?php
ob_start();
session_start();
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['log'])) {
        $email = $_POST['email'];
        $password = $_POST['pswd'];

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM customer WHERE c_emailid = ? AND c_password = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['c_id'] = $row['c_id'];
            $_SESSION['c_name'] = $row['c_name'];
            $_SESSION['c_email'] = $row['c_emailid'];
            $_SESSION['c_phone'] = $row['c_phonenumber'];

            $customerName = $_SESSION['c_name'];

            // Redirect to the homepage using a relative path
            header("Location: homepage/homepage.php");
            exit();
        }
    }
}
ob_end_flush();
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
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
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
            function validateInput(event) {
                // Get the entered value and remove any non-numeric characters
                const input = event.target.value.replace(/[^\d]/g, '');

                // Update the input field with the cleaned value
                event.target.value = input;
            }
            function validateName(event) {
                const input = event.target.value.replace(/[^A-Za-z ]/g, '');
                event.target.value = input;
            }
        </script>
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
            <div class="form-container sign-up-container">
                <form method="post">
                    <h1>Create Account</h1>
                    <input type="text" name="name" placeholder="Name" required="" oninput="validateName(event)" pattern="[A-Za-z ]+" title="Please enter only characters">
                    <input type="email" name="uemail" placeholder="Email" required="" />
                    <input type="tel" name="mobno" placeholder="Mobile Number" oninput="javascript: validateInput(event);" maxlength="10" required>
                    <input type="password" name="password" placeholder="Password" required />
                    <button name="sign">Sign Up</button>
                </form>
            </div>
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
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp">Sign Up</button>
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
        if (isset($_POST['sign'])) {
            $uname = $_POST['name'];
            $mno = $_POST['mobno'];
            $email = $_POST['uemail'];
            $passw = $_POST['password'];

            $sql = "insert into customer (c_name,c_phonenumber,c_emailid,c_password) values ('$uname', '$mno', '$email', '$passw')";

            if ($con->query($sql) === TRUE) {
                header('location:customerthankyou.php');
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } elseif (isset($_POST['log'])) {
            if (empty($_POST['email']) || empty($_POST['pswd'])) {
                echo "pleas fill all details";
            } else {
                $query = "select * from customer where c_emailid='" . $_POST['email'] . "' and c_password='" . $_POST['pswd'] . "' ";
                $result = mysqli_query($con, $query);
                if (mysqli_fetch_assoc($result)) {
                    $_SESSION['user'] = $_POST['emailid'];
                    header('location:homepage.php');
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

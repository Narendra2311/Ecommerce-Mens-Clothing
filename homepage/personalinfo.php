<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Information</title>
    <link rel="stylesheet" type="text/css" href="css/product.css">
    <!-- Add other CSS and JavaScript links as needed -->
     <style>
        /* Style for the section */
        section {
            max-width: 1400px; 
            margin: 0 auto; 
            padding: 80px; 
        }

        /* Style for the form container */
        .form-container {
            background-color: #f2f2f2; 
            border: 1px solid #ccc; 
            border-radius: 10px; 
            padding: 20px; 
        }

        /* Style for form labels and inputs */
        label {
            display: block;
            margin-bottom: 10px;
        }
        /* Style for radio button labels */
        label.radio-label {
            display: inline-block;
            margin-right: 10px;
        }

        /* Style for the update button */
        button[type="submit"] {
            background-color: #333; /* Blue background color */
            color: #fff; /* White text color */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit1"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
        <div class="container">
            <h1>Personal Information</h1>
            <?php
            // Check if a session is not already started before starting it
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Include your database connection or functions to connect to the database
            include('../db.php'); // Replace with your database connection code

            // Check if the user is logged in
            if (!isset($_SESSION['c_id'])) {
                // Redirect to the login page or display a message
                header('Location: customerlogin.php');
                exit();
            }

            // Retrieve the user's personal information
            $customerId = $_SESSION['c_id'];
            $query = "SELECT * FROM customer WHERE c_id = $customerId";
            $result = mysqli_query($con, $query);

            // Check if user data is found
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            ?>
            <form method="post" action="update_personalinfo.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['c_name']; ?>" required style="width: 100%;padding: 10px;margin-bottom: 20px;border: 1px solid #ccc;border-radius: 5px;"><br><br>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['c_emailid']; ?>" required style="width: 100%;padding: 10px;margin-bottom: 20px;border: 1px solid #ccc;border-radius: 5px;"><br><br>

               <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $row['c_phonenumber']; ?>" required style="width: 100%;padding: 10px;margin-bottom: 20px;border: 1px solid #ccc;border-radius: 5px;"><br><br>

                <button type="submit1">Update</button>
            </form>
            <?php
            } else {
                // No user data found
                echo "User data not found.";
            }
            ?>
        </div>
</body>
</html>

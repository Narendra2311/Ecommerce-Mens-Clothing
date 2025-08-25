<?php
session_start();
// Check if the user is not logged in
if (!isset($_SESSION['c_name'])) {
    // Redirect to the login page
    header("Location: /mallt/customerlogin.php");
    exit; // Make sure to exit after the redirect
}
require '../db.php';
$customerId = $_SESSION['c_id'];

// Fetch customer addresses
$query = "SELECT * FROM customer_addresses WHERE customer_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

// Function to add a new address
function addNewAddress($customerId, $address, $country, $state, $city, $zipCode) {
    global $con;

    $query = "INSERT INTO customer_addresses (customer_id, address, country, state, city, zip_code) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("isssss", $customerId, $address, $country, $state, $city, $zipCode);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country = 'INDIA'; // You can set a default country
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zipCode = $_POST['zipCode'];
    $fullAddress = $_POST['fullAddress'];

    if (addNewAddress($customerId, $fullAddress, $country, $state, $city, $zipCode)) {
        // Address added successfully, redirect to a different URL
        header("Location: /mallt/homepage/addresselection.php");
        exit;
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>responsive ecommerce website design</title>
        <link rel="stylesheet" type="text/css" href="css/product.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        --><link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>

            /* Style for the additional section */
            .additional-section {
                padding: 20px;
                background-color: #f5f5f5; /* Set your desired background color */
                text-align: center;
            }

            /* Style for the logo and text in the additional section */
            .additional-item {
                display: inline-block;
                margin: 10px;
            }
        </style>
        <style>
            .address-section {
                border: 2px solid #000; /* Black border */
                border-radius: 15px; /* Rounded corners */
                padding: 20px;
                background-color: #fff; /* White background */
                margin-top: 90px; /* Adjust the margin-top to create space between header and address section */
                max-width: 900px; /* Set the maximum width as needed */
                margin-left: auto;
                margin-right: auto;
            }

            .address-item {
                margin-bottom: 10px;
                padding: 10px;
                border: 1px solid #ccc; /* Border for each address item */
                border-radius: 8px; /* Rounded corners for each address item */
            }

            /* Style for radio buttons */
            .address-item input[type="radio"] {
                margin-right: 10px; /* Adjust margin as needed */
            }

            /* Style for radio button labels */
            .address-item label {
                cursor: pointer;
                font-weight: bold; /* Add this line to make the text bold */
            }
            /* Style for Add New Address button */
            .add-new-address-button,
            .proceed-to-pay-button {
                width: 49%; /* Set the width to 50% */
                box-sizing: border-box; /* Include padding and border in the width calculation */
                padding: 10px;
                margin-top: 10px;
                border: 2px solid; /* Remove specific color to use the default color */
                border-radius: 15px; /* Rounded corners */
                cursor: pointer;
                transition: background-color 0.3s, color 0.3s; /* Add smooth transition */
            }

            .add-new-address-button {
                border-color: #000; /* Set border color for Add New Address button */
                background-color: #fff; /* White background */
                color: #000; /* Black text color */
            }

            .add-new-address-button:hover {
                background-color: #000; /* Change to black on hover */
                color: #fff; /* Change text to white on hover */
            }

            .proceed-to-pay-button {
                border-color: #D27D2D; /* Set border color for Proceed to Pay button */
                background-color: #D27D2D; /* Chocolate background */
                color: #fff; /* White text color */
            }

            .proceed-to-pay-button:hover {
                background-color: #fff; /* Change to white on hover */
                color: #D27D2D; /* Change text to chocolate on hover */
            }

            .address-form {
                border: 2px solid #000; /* Black border */
                border-radius: 15px; /* Rounded corners */
                padding: 20px;
                background-color: #fff; /* White background */
                margin-top: 90px; /* Adjust the margin-top to create space between header and address section */
                max-width: 900px; /* Set the maximum width as needed */
                margin-left: auto;
                margin-right: auto;
            }

            .address-form label {
                display: block;
                margin-bottom: 8px;
            }

            .address-form select,
            .address-form input,
            .address-form textarea {
                width: 100%;
                padding: 8px;
                margin-bottom: 16px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .address-form button {
                background-color: #D27D2D;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }

            .address-form button:hover {
                background-color: #000;
            }
        </style>
    </head>
    <body>
        <!----header--->
        <?php
        include 'header.php';
        ?>

        <!-- Address Selection Section -->
        <section class="address-section">
            <h2>Your Addresses</h2>

            <?php
            while ($row = $result->fetch_assoc()) {
                $addressId = $row['address_id'];
                $address = $row['address'];
                $cityy = $row['city'];
                $zipcodee = $row['zip_code'];
                $statee = $row['state'];
                $countryy = $row['country'];

                echo '<div class="address-item">';
                echo '<input type="radio" name="address" value="' . $addressId . '">';
                echo '<label for="address_' . $addressId . '">' . $address . ', ' . $cityy . ', ' . $zipcodee . ', ' . $statee . ', ' . $countryy . '</label>';
                echo '</div>';
            }

            $stmt->close();
            ?>

            <!-- Add New Address Button -->
            <button class="add-new-address-button" id="addNewAddress" onclick="toggleAddressForm()">Add New Address</button>

            <!-- Proceed to Pay Button -->
            <button class="proceed-to-pay-button" onclick="proceedToPay()">Proceed to Pay</button>
        </section>


        <!-- Address Form (Initially hidden) -->
        <section class="address-form" style="display: none;">
            <h2>Add New Address</h2>
            <!-- Display success or error messages -->
            <?php if (!empty($successMessage)): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <!-- Other fields (Country, Street, Zip Code, Full Address) can be added here as needed -->
                <label for="country">Country:</label>
                <select id="country" name="country" disabled>
                    <option value="INDIA">INDIA</option>
                </select><br>

                <label for="state">State:</label>
                <select id="state" name="state" required>
                    <option value="">Select State</option>
                </select><br>

                <label for="city">City:</label>
                <select id="city" name="city" required>
                    <option value="">Select City</option>
                </select><br>

                <label for="zip">Zip Code:</label>
                <input type="text" id="zipCode" name="zipCode" pattern="\d*" maxlength="6" required><br>

                <label for="fullAddress">Full Address:</label>
                <textarea id="fullAddress" name="fullAddress" rows="3" required></textarea><br>

                <button type="submit" class="add-new-address-button" >Save Address</button>
                <button type="button" class="proceed-to-pay-button" id="goBack">Go Back</button>

            </form>
        </section>

        <!-- Additional Section -->
        <section class="additional-section">
            <!-- Secured Payment -->
            <div class="additional-item">
                <i class="fas fa-lock fa-3x"></i>
                <p>Secured Payment</p>
            </div>

            <!-- Assured Quality -->
            <div class="additional-item">
                <i class="fas fa-check-circle fa-3x"></i>
                <p>Assured Quality</p>
            </div>

            <!-- Easy Return -->
            <div class="additional-item">
                <i class="fas fa-undo fa-3x"></i>
                <p>Easy Return</p>
            </div>

            <!-- Easy Exchange -->
            <div class="additional-item">
                <i class="fas fa-exchange-alt fa-3x"></i>
                <p>Easy Exchange</p>
            </div>
        </section>

        <!-- Include footer here -->
        <?php
        include 'footer.php';
        ?>
        <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="js/script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <!-- Add this script to handle form toggle and dynamic field updates -->
        <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const addressSection = document.querySelector(".address-section");
                    const addressForm = document.querySelector(".address-form");

                    // Show address form on "Add New Address" button click
                    document.getElementById("addNewAddress").addEventListener("click", function () {
                        addressSection.style.display = "none";
                        addressForm.style.display = "block";

                        // Populate state dropdown with initial values
                        updateStateDropdown();

                        // Add event listener to state dropdown for dynamic city updates
                        document.querySelector('#state').addEventListener('change', updateCityDropdown);
                    });

                    // Show address section on "Go Back" button click
                    document.getElementById("goBack").addEventListener("click", function () {
                        addressSection.style.display = "block";
                        addressForm.style.display = "none";
                    });

                    function updateStateDropdown() {
                        const stateDropdown = document.querySelector('#state');
                        stateDropdown.innerHTML = '<option value="">Select State</option>';
                        const states = ['Rajasthan', 'Gujarat', 'Delhi', 'Punjab', 'Haryana'];
                        states.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state;
                            option.text = state;
                            stateDropdown.appendChild(option);
                        });
                    }

                    function updateCityDropdown() {
                        const state = document.querySelector('#state').value;
                        const cityDropdown = document.querySelector('#city');
                        const cityOptions = {
                            'Rajasthan': ['Jaipur', 'Jodhpur', 'Udaipur'],
                            'Gujarat': ['Ahmedabad', 'Surat', 'Vadodara'],
                            'Delhi': ['New Delhi'],
                            'Punjab': ['Chandigarh', 'Amritsar', 'Ludhiana'],
                            'Haryana': ['Chandigarh', 'Faridabad', 'Gurgaon']
                        };

                        cityDropdown.innerHTML = '<option value="">Select City</option>';
                        if (state && cityOptions[state]) {
                            cityOptions[state].forEach(city => {
                                const option = document.createElement('option');
                                option.value = city;
                                option.text = city;
                                cityDropdown.appendChild(option);
                            });
                        }
                    }
                });
        </script>
        <script>
            function proceedToPay() {
                // Get the selected address ID
                const selectedAddressId = document.querySelector('input[name="address"]:checked');

                if (selectedAddressId) {
                    // Redirect to the next page with the selected address ID
                    window.location.href = '/mallt/homepage/order_confirmation.php?address_id=' + selectedAddressId.value;
                } else {
                    alert('Please select an address before proceeding to pay.');
                }
            }
        </script>
    </body>
</html>
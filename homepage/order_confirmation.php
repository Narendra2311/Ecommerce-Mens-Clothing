<?php
session_start();
require '../db.php';
// Check if the user is not logged in
if (!isset($_SESSION['c_name'])) {
    // Redirect to the login page
    header("Location: /mallt/customerlogin.php");
    exit; // Make sure to exit after the redirect
}
?>
<!----header--->
<?php
include 'header.php';
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
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <style>
            .product-card {
                display: flex; /* Use flexbox to arrange the elements in a row */
                align-items: center; /* Vertically center-align the elements */
                border: 1px solid #ccc; /* Add a 1px light gray border */
                border-radius: 5px; /* Add rounded edges */
                padding: 10px; /* Add padding to create space between content and border */
            }

            .product-card img {
                height: 150px;
                width: 130px;
                margin-right: 30px; /* Add spacing between the image and text */
            }

            .product-details {
                flex: 1; /* Allow the product details to take up remaining space */
            }

            /* Style for the price */
            .product-price {
                margin-top: 10px; /* Add some spacing between product details and price */
            }

            /* Style for the right column card */
            .order-total-card {
                border: 1px solid gray;
                border-radius: 5px;
                padding: 10px;
            }

            /* Style for the two-column layout */
            .total-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }

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
            /* Style for the "Remove" link */
            .remove-button {
                display: inline-block;
                padding: 8px 16px;
                background-color: chocolate; /* Red background color */
                color: #fff; /* White text color */
                text-decoration: none; /* Remove underlines */
                border: none;
                border-radius: 5px; /* Rounded corners */
                cursor: pointer;
                transition: background-color 0.3s ease; /* Smooth background color transition */
            }

            /* Hover effect */
            .remove-button:hover {
                background-color: #D27D2D; /* Darker red on hover */
            }

            /* Optional: Add margin or spacing around the link */
            .remove-button + .product-price {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <section>
            <center><b><h1>Order Confirmation</h1></b></center>
            <div class="container">
                <div class="row">
                    <!-- Left Column for Product Cards -->
                    <div class="col-md-7">
                        <?php
                        // Retrieve the customer ID from the session
                        $customer_id = $_SESSION['c_id'];

                        // Modify your SQL query to fetch products in the cart for the specific customer
                        $sql = "SELECT p.*, c.cat_name, GROUP_CONCAT(DISTINCT s.size_name) AS product_sizes, pi.image_filename AS product_image, GROUP_CONCAT(DISTINCT pi.p_color) AS product_colors,cart.size as cart_size,cart.color as cart_color,cart.quantity as cart_quantity
                                FROM product p
                                INNER JOIN category c ON p.cat_id = c.cat_id
                                LEFT JOIN product_sizes ps ON p.p_id = ps.product_id
                                LEFT JOIN sizes s ON ps.size_id = s.size_id
                                LEFT JOIN product_images pi ON p.p_id = pi.p_id
                                INNER JOIN cart cart ON p.p_id = cart.product_id
                                WHERE cart.customer_id = $customer_id AND cart.color = pi.p_color
                                GROUP BY p.p_id";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_object()) {
                                    ?>
                                    <!-- Product Card with dynamic image -->
                                    <div class="product-card">
                                        <img id="product-image" src="../image/<?php echo $row->product_image; ?>" alt="Product Image">
                                        <div class="product-details">
                                            <h2><?php echo $row->p_name ?></h2>
                                            <div class="size-selection" style="color:gray">
                                                <strong>Size:</strong>
                                                <span><?php echo $row->cart_size ?></span>
                                            </div>
                                            <div class="color-selection"style="color:gray">
                                                <strong>color:</strong>
                                                <span><?php echo $row->cart_color ?></span>
                                            </div>
                                            <div class="size-selection" style="color:gray">
                                                <strong>Quantity:</strong>
                                                <span><?php echo $row->cart_quantity ?></span>
                                            </div>
                                        </div>
                                        <!-- Product Price Div -->
                                        <div class="product-price">
                                            <p style="margin: 0;"><span style="text-decoration: line-through; color: red;">&#8377;<?php echo $row->p_mrp; ?></span> (<?php echo $row->p_discount; ?>%)</p>
                                            <b><p>&#8377;<?php echo $row->p_discountprice; ?></p></b>
                                        </div>

                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<center>No Products are added in cart</center><br>';
                                echo '<center><a href="homepage.php" style="height:40px;width:180px" class="remove-button">Continue shoping</a></center>';
                            }
                        } else {
                            echo 'Error: ' . mysqli_error($con);
                        }
                        ?>
                    </div>
                    <!-- Right Column for Order Total -->
                    <div class="col-md-5">
                        <?php
// Check if there are products in the cart
                        $sqlCartCheck = "SELECT COUNT(*) as cart_count FROM cart WHERE customer_id = $customer_id";
                        $resultCartCheck = mysqli_query($con, $sqlCartCheck);

                        if ($resultCartCheck) {
                            $cartCount = mysqli_fetch_assoc($resultCartCheck)['cart_count'];

                            if ($cartCount > 0) {
                                // Calculate Bag Total, Bag Discount, and Total dynamically
                                $sqlBagTotal = "SELECT SUM(p_mrp * cart.quantity) as bag_total
                        FROM product p
                        INNER JOIN cart ON p.p_id = cart.product_id
                        WHERE cart.customer_id = $customer_id";
                                $resultBagTotal = mysqli_query($con, $sqlBagTotal);
                                $bagTotal = mysqli_fetch_assoc($resultBagTotal)['bag_total'];

                                $sqlBagDiscount = "SELECT SUM((p_mrp - p_discountprice) * cart.quantity) as bag_discount
                           FROM product p
                           INNER JOIN cart ON p.p_id = cart.product_id
                           WHERE cart.customer_id = $customer_id";
                                $resultBagDiscount = mysqli_query($con, $sqlBagDiscount);
                                $bagDiscount = mysqli_fetch_assoc($resultBagDiscount)['bag_discount'];

                                $deliveryCharges = 100;

                                $total = ($bagTotal - $bagDiscount) + $deliveryCharges;
                                ?>
                                <!-- Order Total Card -->
                                <form method="post" action="">
                                    <div class="order-total-card">
                                        <b><h2>Order Details</h2></b>
                                        <!-- Two-column layout for order details -->
                                        <div class="total-row">
                                            <span>Bag Total</span>
                                            <span>&#8377;<?php echo number_format($bagTotal, 2); ?></span>
                                        </div>
                                        <div class="total-row">
                                            <span>Bag Discount (<?php echo number_format(($bagDiscount / $bagTotal) * 100, 2); ?>%)</span>
                                            <span>-&#8377;<?php echo number_format($bagDiscount, 2); ?></span>
                                        </div>
                                        <div class="total-row">
                                            <span>Delivery Charges</span>
                                            <span>&#8377;<?php echo number_format($deliveryCharges, 2); ?></span>
                                        </div>
                                        <!-- Total Price -->
                                        <div class="total-row">
                                            <strong>Order Total</strong>
                                            <strong>&#8377;<?php echo number_format($total, 2); ?></strong>
                                        </div>
                                        <button type="submit" class="remove-button" style="width:330px" name="checkout" id="checkout">Checkout with Razorpay</button>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        ?><br><br>
                        <!-- Delivery Address Column -->
                        <div class="order-total-card">
                            <b><h2>Delivery Address</h2></b>

                            <?php
                            // Step 1: Get the address ID from the URL parameter
                            $addressId = isset($_GET['address_id']) ? intval($_GET['address_id']) : 0;

                            // Step 2: Fetch address details from the database using the address ID
                            $sqlDeliveryAddress = "SELECT * FROM customer_addresses WHERE address_id = ? AND customer_id = ?";
                            $stmtDeliveryAddress = $con->prepare($sqlDeliveryAddress);
                            $stmtDeliveryAddress->bind_param("ii", $addressId, $customer_id);
                            $stmtDeliveryAddress->execute();
                            $resultDeliveryAddress = $stmtDeliveryAddress->get_result();

                            // Step 3: Display the fetched address details
                            if ($resultDeliveryAddress && $resultDeliveryAddress->num_rows > 0) {
                                $deliveryAddress = $resultDeliveryAddress->fetch_assoc();
                                ?>
                                <div class="total-row"style="text-align: center;">
                                    <span style="font-weight: bold;">Street :</span>
                                    <span><?php echo $deliveryAddress['address']; ?></span>
                                </div>
                                <div class="total-row"style="text-align: center;">
                                    <span style="font-weight: bold;">City,Zip-Code :</span>
                                    <span><?php echo $deliveryAddress['city'] . ', ' . $deliveryAddress['zip_code']; ?></span>
                                </div>
                                <div class="total-row"style="text-align: center;">
                                    <span style="font-weight: bold;">State,Country :</span>
                                    <span><?php echo $deliveryAddress['state'] . ', ' . $deliveryAddress['country']; ?></span>
                                </div>
                                <?php
                            } else {
                                echo '<div class="total-row">No matching delivery address found</div>';
                            }

// Close the statement
                            $stmtDeliveryAddress->close();
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <?php
// Check if the Checkout button is clicked
    if (isset($_POST['checkout'])) {
        // Retrieve customer ID from the session
        $customer_id = $_SESSION['c_id'];

        // Insert order details into the 'orders' table
        $insertOrderSql = "INSERT INTO orders (bag_total, bag_discount, delivery_charges, order_total, customer_id)
                       VALUES (?, ?, ?, ?, ?)";

        $stmtInsertOrder = $con->prepare($insertOrderSql);
        $stmtInsertOrder->bind_param("ddddd", $bagTotal, $bagDiscount, $deliveryCharges, $total, $customer_id);

        // Execute the order insertion
        $stmtInsertOrder->execute();

        // Get the generated order ID
        $orderId = $stmtInsertOrder->insert_id;

        // Close the statement
        $stmtInsertOrder->close();

        // Loop through each product in the cart and insert order details into 'order_details' table
        $sql = "SELECT p.*, cart.size as cart_size, cart.color as cart_color, cart.quantity as cart_quantity
            FROM product p
            INNER JOIN cart ON p.p_id = cart.product_id
            WHERE cart.customer_id = $customer_id";
        $result = mysqli_query($con, $sql);

        while ($row = $result->fetch_object()) {
            $productId = $row->p_id;
            $size = $row->cart_size;
            $color = $row->cart_color;
            $quantity = $row->cart_quantity;

            // Insert product details into 'order_details' table
            $insertOrderDetailsSql = "INSERT INTO order_details (order_id, product_id, size, color, quantity)
                                  VALUES (?, ?, ?, ?, ?)";
            $stmtInsertOrderDetails = $con->prepare($insertOrderDetailsSql);
            $stmtInsertOrderDetails->bind_param("iisss", $orderId, $productId, $size, $color, $quantity);
            $stmtInsertOrderDetails->execute();
            $stmtInsertOrderDetails->close();
        }

        $sqlDeliveryAddress = "SELECT * FROM customer_addresses WHERE address_id = ? AND customer_id = ?";
        $stmtDeliveryAddress = $con->prepare($sqlDeliveryAddress);
        $stmtDeliveryAddress->bind_param("ii", $addressId, $customer_id);
        $stmtDeliveryAddress->execute();
        $resultDeliveryAddress = $stmtDeliveryAddress->get_result();

        if ($resultDeliveryAddress && $resultDeliveryAddress->num_rows > 0) {
            $deliveryAddress = $resultDeliveryAddress->fetch_assoc();

            // Insert delivery address into 'order_address' table
            $insertOrderAddressSql = "INSERT INTO order_address (order_id, street, city, zip_code, state, country)
                              VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsertOrderAddress = $con->prepare($insertOrderAddressSql);
            $stmtInsertOrderAddress->bind_param("isssss", $orderId, $deliveryAddress['address'], $deliveryAddress['city'], $deliveryAddress['zip_code'], $deliveryAddress['state'], $deliveryAddress['country']);
            $stmtInsertOrderAddress->execute();
            $stmtInsertOrderAddress->close();
        }
    }
    ?>

    <!-- Include footer here -->
    <?php
    include 'footer.php';
    ?>
    <?php
// You can fetch the total amount and customer details from your form submission
    $total; // You can adjust this as needed
    $email = $_SESSION['c_email'];
    $contactno = $_SESSION['c_phone'];
    ?>
    <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        document.getElementById('checkout').onclick = function (event) {
            event.preventDefault(); // Prevent the form submission

            // Razorpay configuration
            var options = {
                key: 'rzp_test_z0XHR75PZM8kfE', // Replace with your actual API Key
                amount: <?php echo $total * 100; ?>, // Amount in paise
                name: 'Mall-T',
                description: 'Order Payment',
                handler: function (response) {
                    // Handle the success response, usually, you'll submit the form here
                    alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                    document.getElementById('checkout-form').submit(); // Assuming your form has the id 'checkout-form'
                },
                prefill: {
                    name: 'Customer Name',
                    email: '<?php echo $email; ?>',
                    contact: '<?php echo $contactno; ?>',
                },
                theme: {
                    color: '#D27D2D'
                }
            };

            // Initialize Razorpay
            var razorpay = new Razorpay(options);
            razorpay.open();
        }
    </script>
</body>
</html> 
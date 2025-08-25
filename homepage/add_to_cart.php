<?php
session_start();

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
            <div class="container">
                <div class="row">
                    <!-- Left Column for Product Cards -->
                    <div class="col-md-7">
                        <?php
                        require '../db.php';
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
                                            <a href="remove_product.php?product_id=<?php echo $row->p_id; ?>"style="background-color: #ff4c4c;" class="remove-button">Remove</a>
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
                                    <a href="addresselection.php" class="remove-button" style="width:300px; display: block; text-align: center; margin: 10px auto;">Proceed To Shipping</a>
                                </div>
                                <?php
                            }
                        }
                        ?>
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

    <!-- Include footer here -->
    <?php
    include 'footer.php';
    ?>
    <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</body>
</html>
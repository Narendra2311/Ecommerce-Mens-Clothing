<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve the customer ID from the session
    $customer_id = $_SESSION['c_id'];

    // Connect to the database (replace with your database connection code)
    require '../db.php';

    // Perform the DELETE operation to remove the product from the cart
    $deleteQuery = "DELETE FROM cart WHERE customer_id = $customer_id AND product_id = $product_id";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Redirect back to the cart page after successful removal
        header('Location: add_to_cart.php');
        exit();
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
} else {
    // Handle the case where product_id is not set in the URL
    echo 'Product ID not specified.';
}
?>

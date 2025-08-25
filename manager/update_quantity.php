<?php
require_once '../db.php'; // Include your database connection script
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $productId = $_POST['productId'];
    $newQuantity = intval($_POST['newQuantity']); // Convert to an integer

    if ($productId && $newQuantity >= 0) {
        // Get the existing quantity from the database
        $sqlGetExistingQuantity = "SELECT p_quantity FROM product WHERE p_id = $productId";
        $result = $con->query($sqlGetExistingQuantity);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existingQuantity = $row['p_quantity'];

            // Calculate the new total quantity
            $totalQuantity = $existingQuantity + $newQuantity;

            // Update the quantity in the database with the new total quantity
            $sqlUpdateQuantity = "UPDATE product SET p_quantity = $totalQuantity WHERE p_id = $productId";

            if ($con->query($sqlUpdateQuantity)) {
                // Quantity updated successfully
                echo 'Quantity updated successfully. New quantity: ' . $totalQuantity;
            } else {
                // Error updating quantity
                echo 'Error updating quantity: ' . $con->error;
            }
        } else {
            // Product not found or error fetching existing quantity
            echo 'Product not found or error fetching existing quantity.';
        }
    } else {
        // Invalid input data
        echo 'Invalid input data.';
    }
} else {
    // Invalid request method
    echo 'Invalid request method.';
}
?>

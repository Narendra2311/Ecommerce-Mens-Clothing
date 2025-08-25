<?php
session_start(); // Start the session
require_once '../db.php';

if (isset($_POST['product_id'], $_POST['quantity'], $_POST['size'], $_POST['color'])) {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];
    $size = $_POST["size"];
    $color = $_POST["color"];
    
    // Retrieve customer ID from the session (you need to set it in your login code)
    $customer_id = $_SESSION["c_id"]; // Replace with your actual session variable name

    // Check if the same combination already exists in the cart
    $checkQuery = "SELECT * FROM cart WHERE customer_id = ? AND product_id = ?";
    $checkStmt = $con->prepare($checkQuery);
    $checkStmt->bind_param("ii", $customer_id, $product_id);

    $checkStmt->execute();
    $existingRecord = $checkStmt->get_result()->fetch_assoc();

    if ($existingRecord !== null) {
        echo 'Product already in cart'; // Plain text message
    } else {
        // Insert data into the 'cart' table
        $sql = "INSERT INTO cart (customer_id, product_id, size, color, quantity)
                VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("iissi", $customer_id, $product_id, $size, $color, $quantity);
            if ($stmt->execute()) {
                echo 'Product added to cart'; // Plain text message
            } else {
                echo 'Error: Product not inserted'; // Plain text message
            }
        } else {
            echo 'Error preparing statement'; // Plain text message
        }
    }
    $con->close();
    die(); // Terminate the script
} else {
    echo 'Invalid request'; // Plain text message
    die(); // Terminate the script
}
?>

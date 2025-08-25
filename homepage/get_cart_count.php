<?php
session_start();
require 'db.php';

if (isset($_SESSION['c_id'])) {
    $customer_id = $_SESSION['c_id'];
    $query = "SELECT SUM(quantity) AS cart_count FROM cart WHERE customer_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo $row['cart_count'];
} else {
    echo "0";
}
?>

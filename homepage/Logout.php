<?php
session_start();
session_destroy();
// Clear the cart count session variable
unset($_SESSION['cart_count']);
header("Location: homepage.php"); // Redirect the user to the homepage after logout
exit();
?>
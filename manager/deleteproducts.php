<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
require_once '../db.php';

if (isset($_GET['p_id'])) {
    $productId = $_GET['p_id'];

    // Delete related records in product_sizes table
    $deleteSizesQuery = "DELETE FROM product_sizes WHERE product_id = $productId";
    if (mysqli_query($con, $deleteSizesQuery)) {
        // Related records deleted successfully, now delete the product
        $deleteProductQuery = "DELETE FROM product WHERE p_id = $productId";
        if (mysqli_query($con, $deleteProductQuery)) {
            // Product deleted successfully
            header("Location: viewproducts.php");
            exit();
        } else {
            // Handle the product deletion error
            echo "Error deleting product: " . mysqli_error($con);
        }
    } else {
        // Handle the related records deletion error
        echo "Error deleting related records: " . mysqli_error($con);
    }
}
?>

    </body>
</html>
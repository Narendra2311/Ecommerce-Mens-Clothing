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
        //$query = "select * from deliveryboy";
        //$result = mysqli_query($conn, $query);
        if (isset($_GET['cat_id'])) {
            $id = $_GET['cat_id'];

            // Delete records from the product_sizes table where the product no longer exists
            $sqlDeleteProductSizes = "DELETE FROM product_sizes WHERE product_id IN (SELECT p_id FROM product WHERE cat_id = $id)";
            $resultDeleteProductSizes = mysqli_query($con, $sqlDeleteProductSizes);

            // Delete all products associated with the category
            $sqlDeleteProducts = "DELETE FROM product WHERE cat_id = $id";
            $resultDeleteProducts = mysqli_query($con, $sqlDeleteProducts);

            // Delete the category after deleting products and updating product_sizes
            $sqlDeleteCategory = "DELETE FROM category WHERE cat_id = $id";
            $resultDeleteCategory = mysqli_query($con, $sqlDeleteCategory);

            if ($resultDeleteCategory) {
                header('location:../manager/viewcategory.php');
            } else {
                echo "Error deleting category: " . mysqli_error($con);
            }
        }
        ?>
         </body>
</html>
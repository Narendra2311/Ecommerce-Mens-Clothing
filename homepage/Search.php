<?php include 'header.php' ?>
<?php
require '../db.php';

// Check if the search query is provided in the URL
if (isset($_GET['search_query'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search_query']);

    // Query to search for products with matching names or descriptions
    $sql = "SELECT p.*, pi.image_filename, c.cat_name
            FROM product p
            LEFT JOIN (
                SELECT p_id, MIN(image_filename) AS image_filename
                FROM product_images
                GROUP BY p_id
            ) pi ON p.p_id = pi.p_id
            LEFT JOIN category c ON p.cat_id = c.cat_id
            WHERE p.p_name LIKE '%$searchQuery%' OR p.p_description LIKE '%$searchQuery%'";

    $result = mysqli_query($con, $sql);
} else {
    // If no search query is provided, you can handle it as needed (e.g., show all products)
    // You may consider displaying a message or all products in this case.
}
// Check if the user is not logged in
if (!isset($_SESSION['c_name'])) {
    // Redirect to the login page
    header("Location: /mallt/customerlogin.php");
    exit; // Make sure to exit after the redirect
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>responsive ecommerce website design</title>
        <link rel="stylesheet" type="text/css" href="css/joggers.css">
        <!-- Latest compiled Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Boxicons CSS -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
    /* Your existing CSS styles here */

    .search-results {
        padding: 80px 0;
    }

    .search-results .container {
        text-align: center;
    }

    .search-results .wsk-cp-product {
        /* Adjust styles as needed for the centered layout */
    }
    /* Style for the "No products found" message */
    .col-md-12 {
        font-size: 180px;
        color: black;
        margin-top: 200px;
    }
</style>
    </head>
    <body>
        <!-- CTA Section -->
        <section class="cta">
            <div class="cta-text">
                <h6>SUMMER ON SALE</h6>
                <h4>20% OFF <br> NEW ARRIVAL</h4>
            </div>
        </section>
        <!-- Centered Search Results Section -->
        <section class="search-results">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    if (isset($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col-md-3">
                                <div class="wsk-cp-product">
                                    <div class="wsk-cp-img">
                                        <?php
                                        // Assuming the "image" folder is in the same directory as this PHP file
                                        $image = $row['image_filename'];
                                        $imagePath = 'c://xampp//htdocs//mallt//image//' . $image;

                                        // Read image data and encode it as base64
                                        $imageData = base64_encode(file_get_contents($imagePath));
                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                                        ?>
                                        <img src="<?php echo $imageBase64; ?>" alt="Product Image" width="200" height="200">
                                    </div>
                                    <div class="wsk-cp-text">
                                        <div class="category">
                                            <span><?php echo $row['cat_name']; ?></span>
                                        </div>
                                        <div class="title-product">
                                            <h3><?php echo $row['p_name']; ?></h3>
                                        </div>
                                        <div class="description-prod">
                                            <p><?php echo $row['p_description']; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="wcf-left">
                                                <span class="price"><b>&#8377;<?php echo $row['p_discountprice']; ?></b></span>
                                                <br>
                                                <span class="price small-price">&#8377; <?php echo $row['p_mrp']; ?></span>
                                            </div>
                                        </div>
                                        <form action="productdescription.php" method="get">
                                            <!-- Add a hidden input to store the product ID -->
                                            <input type="hidden" name="product_id" value="<?php echo $row['p_id']; ?>">
                                            <button type="submit" class="btn btn-default btn-sm" style="height: 40px; width: 90px; background-color: #D6AD60">View</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Handle the case where no search results are found or no search query is provided.
                        // You can display a message or all products in this case.
                        echo '<div class="col-md-12">';
                        echo '<p>No products matched your search result.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- Scroll Top Button -->
        <a href="#" class="top"><i class='bx bx-up-arrow-alt'></i></a>
        <!-- Scroll Reveal JavaScript -->
        <script src="https://unpkg.com/scrollreveal"></script>
        <!-- Custom JavaScript -->
        <script src="js/script.js"></script>
    </body>
</html>
<?php include 'footer.php'; ?>
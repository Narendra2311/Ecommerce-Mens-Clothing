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
<?php
require_once '../db.php';
$query = "select * from category ";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            /* css/category.css */
            .view-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #c8815f !important; /* Light blue background color */
                color: #ffffff !important; /* White text color */
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background-color 0.3s ease-in-out;
            }

            .view-button:hover {
                background-color: #ba7250 !important; /* Lighter background color on hover */
            }

        </style>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>responsive ecommerce website design</title>
        <link rel="stylesheet" type="text/css" href="css/category.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



        <link rel="stylesheet"
              href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    </head>
    <body>
        

        <!----home--->


        <!----featured--->
        <section class="featured" id="featured">
            <div class="center-text">
                <h2>Featured Categories</h2>
            </div>
            <div class="featured-content">

                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <div class="col-md-3">

                        <div class="wrapper">
                            <div class="product-img">
                                <?php
                                // Assuming the "image" folder is in the same directory as this PHP file
                                $image = $row['cat_image'];
                                $imagePath = 'c://xampp//htdocs//mallt//image//' . $image;

                                // Read image data and encode it as base64
                                $imageData = base64_encode(file_get_contents($imagePath));
                                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                                ?>
                                <img src="<?php echo $imageBase64; ?>" alt="Product Image" height="320" width="200">
                            </div>
                            <div class="product-info">
                                <div class="product-text">
                                    <br><br>
                                    <h1><?php echo $row['cat_name']; ?></h1>
                                    <p><?php echo $row['cat_description']; ?></p>
                                </div>
                                <div class="product-price-btn">
                                    <br>
                                    <center>
                                    <a href="products.php?cat_id=<?php echo $row['cat_id']; ?>" class="view-button">View</a>
                                </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>


            </div>
        </section>
        <!----footer--->
        <?php
                include 'footer.php';
        ?>

        <!----scroll top--->
        <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>


        <script src="https://unpkg.com/scrollreveal"></script>

        <!----custom js link--->
        <script src="js/script.js"></script>

    </body>
</html>
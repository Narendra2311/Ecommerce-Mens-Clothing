<?php
require '../db.php';
if (!isset($_GET['cat_id'])) {
    exit("The 'cat_id' parameter is missing in the URL.");
}
$id = $_GET['cat_id'];
$sql = "SELECT p.*, pi.image_filename, c.cat_name
        FROM product p
        LEFT JOIN (
            SELECT p_id, MIN(image_filename) AS image_filename
            FROM product_images
            GROUP BY p_id
        ) pi ON p.p_id = pi.p_id
        LEFT JOIN category c ON p.cat_id = c.cat_id
        WHERE p.cat_id = $id";
$result = mysqli_query($con, $sql);
?>
<!-- Rest of your HTML code remains the same -->

<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['c_name'])) {
    // Redirect to the login page
    header("Location: /mallt/customerlogin.php");
    exit; // Make sure to exit after the redirect
}
?>
<!-- Header -->
        <?php
        include 'header.php';
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
            .shell{
                padding:80px 0;
            }
            .wsk-cp-product{
                background:#fff;
                padding:10px;
                border-radius:6px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                position:relative;
                margin:10px auto;
            }
            .wsk-cp-img{
                position:absolute;
                top:5px;
                left:50%;
                transform:translate(-50%);
                -webkit-transform:translate(-50%);
                -ms-transform:translate(-50%);
                -moz-transform:translate(-50%);
                -o-transform:translate(-50%);
                -khtml-transform:translate(-50%);
                width: 100%;
                height: 100%;
                padding: 15px;
                transition: all 0.2s ease-in-out;
            }
            .wsk-cp-img img{
                width:100%;
                transition: all 0.2s ease-in-out;
                border-radius:6px;
                height: 240px;
            }
            .wsk-cp-product:hover .wsk-cp-img{
                top:-40px;
            }
            .wsk-cp-product:hover .wsk-cp-img img{
                box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
            }
            .wsk-cp-text{
                padding-top:150%;
            }
            .wsk-cp-text .category{
                text-align:center;
                font-size:12px;
                font-weight:bold;
                padding:5px;
                margin-bottom:5px;
                position:relative;
                transition: all 0.2s ease-in-out;
            }
            .wsk-cp-text .category > *{
                position:absolute;
                top:50%;
                left:50%;
                transform: translate(-50%,-50%);
                -webkit-transform: translate(-50%,-50%);
                -moz-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                -o-transform: translate(-50%,-50%);
                -khtml-transform: translate(-50%,-50%);

            }
            .wsk-cp-text .category > span{
                padding: 12px 30px;
                border: 1px solid #313131;
                background:#212121;
                color:#fff;
                box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
                border-radius:27px;
                transition: all 0.05s ease-in-out;

            }
            .wsk-cp-product:hover .wsk-cp-text .category > span{
                border-color:#ddd;
                box-shadow: none;
                padding: 11px 28px;
            }
            .wsk-cp-product:hover .wsk-cp-text .category{
                margin-top: 0px;
            }
            .wsk-cp-text .title-product{
                text-align:center;
                margin: 7px 0;
            }
            .wsk-cp-text .title-product h3{
                font-size:20px;
                font-weight:bold;
                margin:15px auto;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width:100%;
            }
            .wsk-cp-text .description-prod p{
                margin: 5px 0;
            }
            /* Truncate */
            .wsk-cp-text .description-prod {
                text-align:center;
                width: 100%;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                margin-bottom:5px;
            }
            .card-footer{
                margin-top: 10px;
                padding: 25px 0 5px;
                border-top: 1px solid #ddd;
            }
            .card-footer:after, .card-footer:before{
                content:'';
                display:table;
            }
            .card-footer:after{
                clear:both;
            }

            .card-footer .wcf-left{
                float:left;
            }

            .card-footer .wcf-right{
                float:right;
            }
            .price{
                font-size:18px;
                font-weight:bold;
            }
            .red{
                color:#F44336;
                font-size:22px;
                display:inline-block;
                margin: 0 5px;
            }
            @media screen and (max-width: 991px) {
                .wsk-cp-product{
                    margin:40px auto;
                }
                .wsk-cp-product .wsk-cp-img{
                    top:-40px;
                }
                .wsk-cp-product .wsk-cp-img img{
                    box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
                }
                .wsk-cp-product .wsk-cp-text .category > span{
                    border-color:#ddd;
                    box-shadow: none;
                    padding: 11px 28px;
                }
                .wsk-cp-product .wsk-cp-text .category{
                    margin-top: 0px;
                }
                a.buy-btn{
                    border-color: #FF9800;
                    background: #FF9800;
                    color: #fff;
                }
            }

            .small-price {
                font-size: 12px; /* Adjust the font size to make it smaller */
                text-decoration: line-through; /* Add a line-through to create a dash effect */
                color: red;
            }
        </style>
    </head>
    <body>
        <!-- New Products Section -->
        <section class="new" id="new">
            <div class="shell">
                <div class="row">
                    <?php
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
                                    <div class="title-product" >
                                        <h3><?php echo $row['p_name']; ?></h3>
                                    </div>
                                    <div class="description-prod" style=" margin-bottom:3px;">
                                        <p><?php echo $row['p_description']; ?></p>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="wcf-left" >
                                            <span class="price"><b>&#8377;<?php echo $row['p_discountprice']; ?></b></span>
                                            <br>
                                            <span class="price small-price" style="text-align:left;">&#8377; <?php echo $row['p_mrp']; ?></span>
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
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <?php
    include 'footer.php';
    ?>
    <!-- Scroll Top Button -->
    <a href="#" class="top"><i class='bx bx-up-arrow-alt'></i></a>
    <!-- Scroll Reveal JavaScript -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Custom JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>
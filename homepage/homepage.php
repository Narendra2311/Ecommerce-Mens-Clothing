<?php
include 'header.php';
require_once '../db.php';
$query = "select * from category LIMIT 2";
$result = mysqli_query($con, $query);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>responsive ecommerce website design</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <!-- Inside the header section -->
        <style>
            /* ... Your existing styles ... */

            /* Animation styles using Animate.css */
            .animate__fadeInUp {
                animation: fadeInUp 1s ease;
            }

            .animate__fadeInLeft {
                animation: fadeInLeft 1s ease;
            }

            .animate__zoomIn {
                animation: zoomIn 1s ease;
            }

            .product-img img {
                border-radius: 7px 0 0 7px;
                transition: transform 0.3s ease;
            }

            .product-img img:hover {
                transform: scale(1.1);
            }
            .item img {
                width: 100vw;
                height: 600px; /* Allow the height to adjust based on the image's aspect ratio */
            }
            /*            .slider {
                            margin-top: 60px;
                        }*/
            .animate__fadeInDown {
                animation: fadeInDown 1s ease;
            }

            /* Caption styling */
            .caption {
                position: absolute;
                top: 50%; /* Vertically center the caption */
                left: 10%; /* Adjust the horizontal position as needed */
                transform: translateY(-50%);
                padding: 10px;
                font-family: 'serif'; /* Font family */
                font-weight: bold; /* Text boldness */
                display: inline-block; /* Display captions in a line */
                line-height: 1; /* Adjust the line-height for spacing */
            }

            /* Additional styles for individual captions */
            .caption-1 {
                font-size: 30px;
            }
            .caption-2 {
                font-size: 52px;
            }
            .caption-3 {
                font-size: 84px;
            }
            .sidebar {
                height: 100%;
                width: 250px;
                position: fixed;
                top: 0;
                right: -250px;
                background-color: #f4f4f4;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
                z-index: 1;
            }

            .sidebar a {
                padding: 15px 25px;
                text-decoration: none;
                font-size: 18px;
                color: #000;
                display: block;
                transition: 0.3s;
            }

            .sidebar a:hover {
                background-color: #ddd;
            }

            .closebtn {
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 30px;
                cursor: pointer;
            }

        </style>
        <!-- category card css-->
        <style>

            .wrapper {
                height: 320px;
                width: 455px;
                margin: 20px auto;
                border-radius: 7px 7px 7px 7px;
                /* VIA CSS MATIC https://goo.gl/cIbnS */
                -webkit-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
                -moz-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
                box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
            }

            .product-img {
                float: left;

            }

            .product-img img {
                border-radius: 7px 0 0 7px;
            }

            .product-info {
                float: left;
                height: 320px;
                width: 227px;
                border-radius: 0 7px 10px 7px;
                background-color: #ffffff;
            }

            .product-text {
                height: 200px;
                width: 227px;
            }

            .product-text h1 {
                margin: 0 0 0 38px;
                padding-top: 52px;
                font-size: 24px;
                color: #474747;
            }

            .product-text h1,
            .product-price-btn p {
                font-family: 'Bentham', serif;
            }

            .product-text h2 {
                margin: 0 0 47px 38px;
                font-size: 8px;
                font-family: 'Raleway', sans-serif;
                font-weight: 400;
                text-transform: uppercase;
                color: #d2d2d2;
                letter-spacing: 0.2em;
            }

            .product-text p {
                height: 90px;
                margin: 0 0 0 38px;
                font-family: 'Playfair Display', serif;
                color: #8d8d8d;
                line-height: 1.7em;
                font-size: 10px;
                font-weight: lighter;
                overflow: hidden;
            }

            .product-price-btn {
                height: 100px;
                width: 210px;
                margin-top: 17px;
                position: relative;
            }



            span {
                display: inline-block;
                height: 50px;
                font-family: 'Suranna', serif;
                font-size: 34px;
            }

            .product-price-btn button {
                float: right;
                display: inline-block;
                height: 25px;
                width: 116px;
                margin: 0 40px 0 16px;
                box-sizing: border-box;
                border: transparent;
                border-radius: 60px;
                font-family: 'Raleway', sans-serif;
                font-size: 14px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                color: #ffffff;
                background-color: #D6AD60;
                cursor: pointer;
                outline: none;
            }

            .product-price-btn button:hover {
                background-color: #B68D40;
            }

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
        <style>
        #loadingOverlay {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8); /* Transparent white background */
            z-index: 9999;
            transition: opacity 0.5s;
        }

        #loadingSpinner {
            border: 6px solid #f3f3f3; /* Light gray border */
            border-top: 6px solid #3498db; /* Blue border for spinner */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    </head>
    <body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
 <div id="loadingOverlay">
        <div id="loadingSpinner"></div>
    </div>
        <!----home--->

        <div class="owl-carousel owl-theme slider">
            <!-- Slide 1 -->
            <div class="item">
                <img src="sliderimg/img1.jpg" alt="Slide 1">
                <div class="caption">
                    <div class="caption-animate caption-1 wow animate__fadeInDown" style="color: #C0C0C0;" data-wow-duration="1s" data-wow-delay="0.5s">EXPERIENCE THE ULTIMATE SNUGGLE,</div>
                    <div class="caption-animate caption-2 wow animate__fadeInDown" style="color: #C0C0C0;" data-wow-duration="1s" data-wow-delay="1s">WRAP YOURSELF IN OUR PREMIUM SWEATSHIRTS</div>
                    <div class="caption-animate caption-3 wow animate__fadeInDown" style="color: #C0C0C0;" data-wow-duration="1s" data-wow-delay="1.5s"></div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="item">
                <img src="sliderimg/img2.jpg" alt="Slide 2">
                <div class="caption">
                    <div class="caption-animate caption-1 wow animate__fadeInDown" style="color: #000000;" data-wow-duration="1s" data-wow-delay="0.5s">CLASSIC ELEGANCE,</div>
                    <div class="caption-animate caption-2 wow animate__fadeInDown" style="color: #000000;" data-wow-duration="1s" data-wow-delay="1s">TIMELESS STYLE: </div>
                    <div class="caption-animate caption-3 wow animate__fadeInDown" style="color: #000000;" data-wow-duration="1s" data-wow-delay="1.5s">DISCOVER OUR EXCLUSIVE SHIRT COLLECTION</div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="item">
                <img src="sliderimg/img3.jpg" alt="Slide 3">
                <div class="caption">
                    <div class="caption-animate caption-1 wow animate__fadeInDown" style="color: #ee6d08" data-wow-duration="1s" data-wow-delay="0.5s">UNLEASH COMFORT,</div>
                    <div class="caption-animate caption-2 wow animate__fadeInDown" style="color: #ee6d08" data-wow-duration="1s" data-wow-delay="1s">EMBRACE FASHION</div>
                    <div class="caption-animate caption-3 wow animate__fadeInDown" style="color: #ee6d08" data-wow-duration="1s" data-wow-delay="1.5s">INTRODUCING OUR LATEST T-SHIRT</div>
                </div>
            </div>

            <!-- Add more slides as needed -->
        </div>

        <!----featured--->
        <section class="featured" id="featured">
            <div class="center-text">
                <h2>Featured Categories</h2>
            </div>
            <div>
                <a href="category.php" style=" text-decoration: none;color: black"><h4 style="text-align: right;">See all</h4></a>
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

        <!----cta--->
        <section class="cta">
            <div class="cta-text">
                <h6>SUMMER ON SALE</h6>
                <h4>20% OFF <br> NEW ARRIVAL</h4>
                <a href="#" class="btn">Shop Now</a>
            </div>
        </section>

        <!----contact--->
        <section class="contact" id="contact">
            <div class="main-contact">
                <h3>Classix</h3>
                <h5>Let's Connect With Us</h5>
                <div class="icons">
                    <a href=""><i class='bx bxl-facebook-square' ></i></a>
                    <a href="https://www.instagram.com/divya_15.5/?igshid=MzNlNGNkZWQ4Mg=="><i class='bx bxl-instagram-alt' ></i></a>
                    <a href="#"><i class='bx bxl-twitter' ></i></a>
                </div>
            </div>

            <div class="main-contact">
                <h3>Explore</h3>
                <li><a href="#home">Home</a></li>
                <li><a href="#featured">Featured</a></li>
                <li><a href="#new">New</a></li>
                <li><a href="#contact">Contact</a></li>
            </div>

            <div class="main-contact">
                <h3>Our Services</h3>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Free Shipping</a></li>
                <li><a href="#">Gift Cards</a></li>
            </div>


        </section>

        <script src="js/script.js"></script>
        <!----scroll top--->
        <a href="#" class="top" id="scrollToTop" hidden><i class='bx bx-up-arrow-alt'></i></a>

        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Owl Carousel JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        <!----custom js link--->


        <script>
            $(document).ready(function () {
                var owl = $(".owl-carousel");

                owl.owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true
                });

                owl.on('changed.owl.carousel', function (event) {
                    // Add animate__animated class to caption elements when the slide changes
                    owl.find(".caption .caption-animate").addClass("animate__animated");
                });
                $(window).scroll(function () {
                    // Check the scroll position
                    if ($(this).scrollTop() > 100) { // Adjust 100 to your preferred scroll position
                        $('#scrollToTop').removeAttr('hidden'); // Show the button
                    } else {
                        $('#scrollToTop').attr('hidden', true); // Hide the button
                    }
                });

                // Scroll to the top when the button is clicked
                $('#scrollToTop').click(function () {
                    $('html, body').animate({scrollTop: 0}, 'fast');
                    return false;
                });
            });
        </script>
        <script>
    // Hide loading overlay when the page is fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        var loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.style.opacity = 0; // Set opacity to 0 to fade out
        setTimeout(function () {
            loadingOverlay.style.display = 'none'; // Hide the overlay
        }, 500); // Adjust the duration based on your animation
    });
</script>

    </body>
</html>
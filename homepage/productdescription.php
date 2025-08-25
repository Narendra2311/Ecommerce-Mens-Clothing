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

// Check if 'product_id' is provided in the URL
if (!isset($_GET['product_id'])) {
    // Redirect to a 404 page or show an error message
    header("Location: 404.php"); // You can create a 404.php file
    exit();
}

// Sanitize the 'product_id' from the URL to prevent SQL injection
$product_id = mysqli_real_escape_string($con, $_GET['product_id']);

// Query to retrieve the product based on 'product_id'
$query = "SELECT p.*, pi.image_filename
        FROM product p
        LEFT JOIN product_images pi ON p.p_id = pi.p_id
        WHERE p.p_id = $product_id";
$result = mysqli_query($con, $query);

$size_query = "SELECT sizes.size_name
          FROM sizes
          INNER JOIN product_sizes ON sizes.size_id = product_sizes.size_id
          WHERE product_sizes.product_id = '$product_id'";

$size_result = mysqli_query($con, $size_query);

// Check if there are available sizes for the product
if (mysqli_num_rows($size_result) == 0) {
    // No sizes available for this product, you can handle this case accordingly
    $available_sizes = array(); // Empty array
} else {
    // Retrieve available sizes and store them in an array
    $available_sizes = array();
    while ($row = mysqli_fetch_assoc($size_result)) {
        $available_sizes[] = $row['size_name'];
    }
}
// Query to retrieve available colors and their associated images based on 'p_id'
$colorAndImageQuery = "SELECT pi.p_color, pi.image_filename
    FROM product_images pi
    WHERE pi.p_id = $product_id";
$colorAndImageResult = mysqli_query($con, $colorAndImageQuery);

// Initialize arrays to store colors and associated images
$available_colors = array();
$associated_images = array();

// Check if there are available colors and images
if (mysqli_num_rows($colorAndImageResult) > 0) {
    while ($row = mysqli_fetch_assoc($colorAndImageResult)) {
        $available_colors[] = $row['p_color']; // Store the colors in the array
        $associated_images[] = $row['image_filename']; // Store the associated images in the array
    }
}

// Check if the product exists
if (mysqli_num_rows($result) == 0) {
    // Product not found, you can redirect to a 404 page or show an error message
    header("Location: 404.php");
    exit();
}

// Fetch the product details
$product = mysqli_fetch_assoc($result);
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>responsive ecommerce website design</title>
        <link rel="stylesheet" type="text/css" href="css/product.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        --><link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
        <!-- Add the following styles to the head of your HTML document -->
        <style>
            /* Style for the modal container */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            /* Style for the modal content */
            .modal-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fefefe;
                padding: 20px;
                border: 1px solid #888;
                text-align: center;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            }

            /* Style for the close button */
            .close {
                position: absolute;
                top: 10px;
                right: 10px;
                color: #aaa;
                font-size: 20px;
                font-weight: bold;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
            }
        </style>

        <style>
            #imageContainer {
                width: 400px; /* Set the desired width of the viewer */
                height: 400px; /* Set the desired height of the viewer */
                overflow: hidden;
                position: relative;
            }

            #imageContainer img {
                width: 100%;
                height: 100%;
                position: absolute;
                animation: rotate360 20s infinite linear;
            }

            @keyframes rotate360 {
                from {
                    transform: rotateY(0deg);
                }
                to {
                    transform: rotateY(360deg);
                }
            }
            .size-selection {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
            }

            .size-radio {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background-color: white; /* Background color of the circular button */
                border-radius: 50%; /* Make it circular */
                cursor: pointer;
                transition: background-color 0.3s;
                border: 1px solid black;
            }
            /* Add a class to highlight the selected size */
            .size-radio.selected {
                background-color: chocolate;
                color: #fff;
            }

            .size-radio input[type="radio"] {
                display: none; /* Hide the actual radio button */
            }

            .size-radio input[type="radio"]:checked + label {
                background-color: #007bff; /* Change background color for the selected size */
                color: #fff; /* Change text color for the selected size */
            }

        </style>
        <style>
            .quantity-input {
                display: flex;
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 20px; /* Adjust this value to control the roundness */
                padding: 5px;
                width: 150px; /* Adjust the width as needed */
            }

            .minus-btn,
            .plus-btn {
                background: none;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                outline: none;
                font-weight: bold;
                font-size: 18px;
            }

            #quantity {
                border: none;
                width: 50px;
                text-align: center;
                font-size: 16px;
                outline: none;
                padding: 5px;
            }
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            .btn-cart {
                border-radius: 20px; /* Adjust the border radius to control rounded corners */
                padding: 10px 20px; /* Adjust padding to control button size */
                background-color: #007bff; /* Button background color */
                color: #fff; /* Text color */
                border: none; /* Remove border */
                cursor: pointer;
                font-size: 16px; /* Adjust the font size */
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.3s;
            }

            .btn-cart i {
                margin-right: 8px; /* Adjust the spacing between the icon and text */
            }

            .btn-cart:hover {
                background-color: #0056b3; /* Change background color on hover */
            }


        </style>
        <style>
            .small-img-group {
                display: flex;
                justify-content: space-between;
            }

            .small-img-col {
                flex: 1;
                margin-right: 10px; /* Adjust spacing between images as needed */
                cursor: pointer;
            }

            .small-img-col:last-child {
                margin-right: 0; /* Remove margin for the last image */
            }

            .small-img-col img {
                width: 100%;
                border: 1px solid transparent; /* Add a border to all images */
            }

            .small-img-col img.selected {
                border-color: red; /* Change border color for the selected image */
            }


            .product select {
                display: block;
                padding: 5px 10px;
            }

            .product input {
                width: 50px;
                height: 40px;
                padding-left: 10px;
                font-size: 16px;
                margin-right: 10px;
            }

            #canvas3D {
                width: 100%;
                height: 400px;
            }
        </style>
        <style>
            .red-price {
                font-size: 12px !important;
                color: red !important;
                text-decoration: line-through;
            }
        </style>
        <script>
            function validateQuantity() {
                var quantity = document.getElementById("quantity").value;

                if (quantity < 0) {
                    alert("Quantity cannot be negative.");
                    return false;
                }

                return true;
            }
        </script>
        <style>
            /* Style for color selection */
            .color-selection {
                display: flex;
                align-items: center;
                gap: 20px; /* Add space between images */
            }

            /* Style for color option label */
            .color-radio {
                text-align: center;
            }

            /* Define CSS for the radio button's label */
            .color-radio input[type="radio"] {
                opacity: 0;
                position: absolute;
                width: 0;
                height: 0; /* Hide the actual radio button */
            }

            /* Define CSS for the radio button's label */
            .color-radio label {
                display: inline-block;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
                transition: border-color 0.3s; /* Add a smooth transition for the border color */
            }

            /* Style for selected color option label */
            .color-selection .color-radio input[type="radio"]:checked + label {
                border-color: blue !important; /* Change the border color for the selected image to blue */
            }

            /* Add a blue border to the selected image as well */
            .color-selection .color-radio input[type="radio"]:checked + label img {
                border: 2px solid blue !important;
            }

            /* Style for color option label image */
            .color-radio label img {
                width: 100%;
                height: 100%;
                border-radius: 50%; /* Make the image circular */
                object-fit: cover; /* Ensure the image covers the entire button */
                cursor: pointer;
            }

            /* Style for color option label text */
            .color-radio span {
                display: block;
                margin-top: 5px; /* Add space between image and text */
            }

            /* Style for selected color option label */
            .color-radio.selected img {
                border-color: chocolate; /* Change the border color for the selected image */
            }
        </style>
    </head>
    <body>
        <!-- Modal HTML structure with inline CSS -->
        <div id="myModal" class="modal">
            <div class="modal-content" style="width: 50%;"> <!-- Adjust the width as needed -->
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="modal-message"></div>
            </div>
        </div>

       
        <!--Product -->
        <section class="container product my-5 pt-5">
            <div class="product-info">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="product-images">
                            <!-- Thumbnail images -->
                            <div class="wsk-cp-img">
                                <?php
                                // Display the main product image
                                $mainImage = $product['image_filename'];
                                    $mainImagePath = 'C:/xampp/htdocs/mallt/image/' . $mainImage;

                                if (file_exists($mainImagePath)) {
                                    $mainImageData = base64_encode(file_get_contents($mainImagePath));
                                    $mainImageType = pathinfo($mainImagePath, PATHINFO_EXTENSION);
                                    $mainImageBase64 = 'data:image/' . $mainImageType . ';base64,' . $mainImageData;
                                } else {
                                    $mainImageBase64 = 'C:\xampp\htdocs\mallt\image\img.jpg'; // Provide a path to a placeholder image
                                }
                                ?>
                                <img src="<?php echo $mainImageBase64; ?>" alt="Product Image"  style="width: 100%; height: 600px;">
                            </div><br>
                            <!-- Thumbnail Images -->
                            <div class="col-md-8">
                                <div class="small-img-group">
                                    <?php
                                    // Loop through and display all product images
                                    $productId = $product['p_id'];
                                    $imageQuery = "SELECT image_filename FROM product_images WHERE p_id = '$productId'";
                                    $imageResult = mysqli_query($con, $imageQuery);

                                    while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                                        $imageFile = $imageRow['image_filename'];
                                        $imageFilePath = 'C:/xampp/htdocs/mallt/image/' . $imageFile;

                                        if (file_exists($imageFilePath)) {
                                            $imageData = base64_encode(file_get_contents($imageFilePath));
                                            $imageType = pathinfo($imageFilePath, PATHINFO_EXTENSION);
                                            $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                                        } else {
                                            $imageBase64 = 'C:\xampp\htdocs\mallt\image\img.jpg'; // Provide a path to a placeholder image
                                        }
                                        ?>
                                        <div class="small-img-col">
                                            <img src="<?php echo $imageBase64; ?>" alt="Thumbnail Image" width="100%" onclick="changeImage(this)">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <script>
                                // JavaScript function to change the main product image when a thumbnail is clicked
                                function changeImage(imageElement) {
                                    var mainImageElement = document.querySelector('.wsk-cp-img img');
                                    mainImageElement.src = imageElement.src;
                                }
                            </script>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="product-details">
                            <h3><?php echo $product['p_name']; ?></h3>
                            <h2>&#8377;<?php echo $product['p_discountprice']; ?>
                                <span class="red-price">&#8377;<?php echo $product['p_mrp']; ?></span></h2>
                            <label>Select Size:</label>
                            <div class="size-selection">
                                <?php
                                // Populate the circular selection with available sizes
                                foreach ($available_sizes as $size) {
                                    echo '<label class="size-radio">';
                                    echo "<input type='radio' name='size' value='$size' data-size='$size'>$size";
                                    echo '</label>';
                                }
                                ?>
                            </div>
                            <script>
                                // Function to handle the click event for radio buttons
                                function handleSizeSelection(radio) {
                                    // Remove the "selected" class from all radio buttons
                                    var sizeRadios = document.querySelectorAll('.size-radio');
                                    sizeRadios.forEach(function (sizeRadio) {
                                        sizeRadio.classList.remove('selected');
                                    });

                                    // Add the "selected" class to the clicked radio button
                                    radio.parentNode.classList.add('selected');

                                    // Update the hidden input's value with the selected size
                                    var selectedSize = radio.getAttribute('data-size');
                                    document.getElementById("selected-size").value = selectedSize;
                                }

                                // Add event listeners to radio buttons
                                var sizeRadios = document.querySelectorAll('.size-radio input[type="radio"]');
                                sizeRadios.forEach(function (radio) {
                                    radio.addEventListener('click', function () {
                                        handleSizeSelection(this);
                                    });
                                });
                            </script>
                            <br>
                            <label>Select Color:</label>
                            <div class="color-selection">
                                <?php
                                // Loop through and display color options with associated images
                                for ($i = 0; $i < count($available_colors); $i++) {
                                    $color = $available_colors[$i];
                                    $imageFilename = $associated_images[$i]; // Retrieve the associated image filename
                                    // Construct the image path
                                    $imagePath = 'C:/xampp/htdocs/mallt/image/' . $imageFilename;

                                    // Check if the image file exists
                                    if (file_exists($imagePath)) {
                                        $imageData = base64_encode(file_get_contents($imagePath));
                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
                                    } else {
                                        // Provide a placeholder image or handle missing images as needed
                                        $imageBase64 = 'C:\xampp\htdocs\mallt\image\placeholder.jpg';
                                    }
                                    // Output the color option with spacing and radio button inside the label
                                    echo '<div class="color-radio">';
                                    echo "<label data-image='$imageBase64'>";
                                    echo "<input type='radio' name='color' value='$color' style='display: none;'>"; // Hide the radio button
                                    echo "<img src='$imageBase64' alt='Associated Image' style='width: 40px; height: 40px;'>";
                                    echo "<span>$color</span>"; // Display color text
                                    echo '</label>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <script>
                                // JavaScript function to update the hidden field when a color is selected
                                function updateSelectedColor() {
                                    var selectedColor = document.querySelector('.color-radio input[type="radio"]:checked');
                                    if (selectedColor) {
                                        document.getElementById('selected-color').value = selectedColor.value;
                                    } else {
                                        document.getElementById('selected-color').value = '';
                                    }
                                }

                                // Add an event listener to update the hidden field whenever a color is selected
                                var colorRadios = document.querySelectorAll('.color-radio input[type="radio"]');
                                colorRadios.forEach(function (radio) {
                                    radio.addEventListener('change', updateSelectedColor);
                                });
                            </script>
                            <script>
                                // Function to handle image selection and update the main image
                                function handleImageSelection(label) {
                                    // Remove the "selected" class from all color options
                                    var colorLabels = document.querySelectorAll('.color-radio label');
                                    colorLabels.forEach(function (colorLabel) {
                                        colorLabel.classList.remove('selected');
                                    });

                                    // Add the "selected" class to the clicked color option
                                    label.classList.add('selected');

                                    // Get the selected image from the data attribute
                                    var selectedImage = label.getAttribute('data-image');

                                    // Update the main image with the selected image
                                    var mainImage = document.querySelector('.wsk-cp-img img');
                                    mainImage.src = selectedImage;
                                }

                                // Add event listeners to color labels
                                var colorLabels = document.querySelectorAll('.color-radio label');
                                colorLabels.forEach(function (label) {
                                    label.addEventListener('click', function () {
                                        handleImageSelection(this);
                                    });
                                });
                            </script>
                            <br>

                            <form method="post">
                                <label>Select Quantity:</label>
                                <div class="quantity-input">
                                    <button class="minus-btn" id="minus" type="button">-</button>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>Qty
                                    <button class="plus-btn" id="plus" type="button">+</button>
                                </div><br>
                                <!-- Add the hidden input fields for size, color, and quantity here -->
                                <input type="hidden" id="selected-size" name="size" value="">
                                <input type="hidden" id="selected-color" name="color" value="">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <?php
                                // Check if the product already exists in the cart for the current user
                                $checkQuery = "SELECT * FROM cart WHERE customer_id = ? AND product_id = ?";
                                $checkStmt = $con->prepare($checkQuery);
                                $checkStmt->bind_param("ii", $customer_id, $product_id); // Adjust the "ii" to match the number of placeholders

                                $checkStmt->execute();
                                $existingRecord = $checkStmt->get_result()->fetch_assoc();

                                // Disable the "Add to Cart" button if the product is already in the cart
                                $disableAddToCart = ($existingRecord !== null);
                                ?>
                                <button class="btn-cart" id="add-to-cart-button" type="button" onclick="addToCart()" <?php if ($disableAddToCart) echo 'disabled'; ?>>
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>

                            </form>
                            <h4 class="mt-5 mb-3">Product Description</h4>
                            <p><?php echo $product['p_description']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Product end -->
        <!----contact--->
        <?php
        include 'footer.php';
        ?>
        <!----scroll top--->
        <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>
        <script src="https://unpkg.com/scrollreveal"></script>
        <!----custom js link--->
        <script src="js/script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script>
                                    document.getElementById("quantity").addEventListener("input", function () {
                                        // Remove leading zeros
                                        this.value = this.value.replace(/^0+/, '');

                                        // Ensure the value is not negative
                                        if (parseInt(this.value) < 1 || isNaN(this.value)) {
                                            this.value = "1";
                                        }

                                        // Ensure the value doesn't exceed 999
                                        if (parseInt(this.value) > 999) {
                                            this.value = "999";
                                        }
                                    });

                                    document.getElementById("plus").addEventListener("click", function () {
                                        var quantityInput = document.getElementById("quantity");
                                        var currentValue = parseInt(quantityInput.value);
                                        // Ensure the value doesn't exceed 999
                                        if (currentValue > 999) {
                                            currentValue = 999;
                                        }

                                        // Update the input value
                                        quantityInput.value = currentValue;
                                    });
        </script>
        <script>
            // Get the input element and plus/minus buttons
            var quantityInput = document.getElementById('quantity');
            var minusButton = document.getElementById('minus');
            var plusButton = document.getElementById('plus');

            // Add click event listeners to the buttons
            minusButton.addEventListener('click', function () {
                // Decrease the input value by 1, but ensure it doesn't go below the minimum value (1)
                if (quantityInput.value > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }
            });

            plusButton.addEventListener('click', function () {
                // Increase the input value by 1
                quantityInput.value = parseInt(quantityInput.value) + 1;
            });
        </script>
        <script>
            // Get the input element and plus/minus buttons
            var quantityInput = document.getElementById('quantity');
            var minusButton = document.getElementById('minus');
            var plusButton = document.getElementById('plus');

            // Function to update the quantity field when the plus or minus buttons are clicked
            function updateQuantity(change) {
                var currentValue = parseInt(quantityInput.value);
                var newValue = currentValue + change;

                // Ensure the value is not negative and doesn't exceed 999
                if (newValue >= 1 && newValue <= 999) {
                    quantityInput.value = newValue;
                }
            }

            // Add click event listeners to the plus and minus buttons
            minusButton.addEventListener('click', function () {
                updateQuantity(-0); // Decrease quantity by 1
            });

            plusButton.addEventListener('click', function () {
                updateQuantity(0); // Increase quantity by 1
            });
        </script>
        <!-- JavaScript for showing/hiding modal and handling the "Add to Cart" button -->
        <script>
            function addToCart() {
                var product_id = <?php echo $product_id; ?>;
                var quantity = document.getElementById("quantity").value;
                var size = document.getElementById("selected-size").value;
                var color = document.getElementById("selected-color").value;

                // Send an AJAX request to insert_cart.php
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "insert_cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Extract the plain text message from the HTML response
                            var responseText = xhr.responseText;
                            var plainTextMessage = extractPlainText(responseText);

                            if (plainTextMessage) {
                                // Set the plain text message as the content of the modal dialog
                                var modalContent = document.getElementById("modal-message");
                                modalContent.textContent = plainTextMessage;

                                showModal(); // Show the modal dialog
                                if (plainTextMessage === 'Product added to cart') {
                                    // Product added successfully, you can update other UI elements as needed
                                    document.getElementById("add-to-cart-button").disabled = true; // Disable the button
                                }
                            } else {
                                showModal("Error: Unable to retrieve response.");
                            }
                        } else {
                            showModal("Error: Unable to communicate with the server.");
                        }
                    }
                };

                var data = "product_id=" + product_id + "&quantity=" + quantity + "&size=" + size + "&color=" + color;
                xhr.send(data);
            }

        // Function to show the modal dialog
            function showModal() {
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
            }
            function closeModal() {
                var modal = document.getElementById("myModal");
                modal.style.display = "none";
            }

        // Function to extract plain text from an HTML string
            function extractPlainText(htmlString) {
                var div = document.createElement("div");
                div.innerHTML = htmlString;
                return div.textContent || div.innerText || "";
            }
        </script>
    </body>
</html>

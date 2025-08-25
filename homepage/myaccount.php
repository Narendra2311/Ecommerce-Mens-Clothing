  <?php include('header.php'); // Include your header file here ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>
    <link rel="stylesheet" type="text/css" href="css/product.css">
    <!-- Add other CSS and JavaScript links as needed -->
    <style>
        /* Style for the section */
        section {
            max-width: 1400px; /* Adjust the max-width as needed */
            margin: 0 auto; /* Center the section horizontally */
            padding: 80px; /* Add padding for spacing */
        }

        /* Style for the columns */
        .column {
            background-color: #f2f2f2; /* Grey background color */
            border: 1px solid #ccc; /* Grey border */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Add padding for spacing */
        }

        /* Style for the rows */
        .row-divider {
            border-top: 1px solid #ccc; /* Grey border between rows */
            margin-top: 20px; /* Add margin for spacing */
            padding-top: 20px; /* Add padding for spacing */
        }

        /* Style for anchor tags in the first column */
        .column .col-md-12 a {
            text-decoration: none; /* Remove underline */
            color: black;
            cursor: pointer; /* Add cursor pointer for clickable links */
        }
    </style>
</head>
<body>
  
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="column">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="font-weight:bold">MY ACCOUNT</p>
                                <a href="javascript:void(0);" onclick="loadContent('myorders.php')">My Orders</a>
                            </div>
                            <div class="row-divider"></div>
                            <div class="col-md-12">
                                <p style="font-weight:bold">PROFILE</p>
                                <a href="javascript:void(0);" onclick="loadContent('personalinfo.php')">Personal Information</a><br>
                                <a href="javascript:void(0);" onclick="loadContent('addresses.php')">Addresses</a><br>
                                <a href="javascript:void(0);" onclick="loadContent('payment.php')">Payment</a><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="column" id="content">
                        <!-- Content for the second column goes here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('footer.php'); // Include your footer file here ?>
     <a href="#" class="top"><i class='bx bx-up-arrow-alt' ></i></a>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // JavaScript function to load content into the right column
        function loadContent(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById('content').innerHTML = this.responseText;
                }
            };
            xhttp.open('GET', page, true);
            xhttp.send();
        }

        // Load 'myorders.php' when the page initially loads
        window.onload = function() {
            loadContent('myorders.php');
        };
    </script>
</body>
</html>
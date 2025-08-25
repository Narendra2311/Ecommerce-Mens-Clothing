<?php
// Check if a session is not already started before starting it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <title>responsive ecommerce website design</title>-->
        <link rel="stylesheet" type="text/css" href="css/header.css">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <style>
            /* Style for the search box */
            .search-box {
                display: flex;
                align-items: center; /* Vertically center the search box within the header */
                margin-right: 10px; /* Add some spacing between the search box and user icon */
            }

            .search-input {
                border: none;
                padding: 5px 10px;
                font-size: 14px;
                border-radius: 20px 0 0 20px;
            }

            .search-button {
                border: none;
                background-color: #333;
                color: #fff;
                padding: 5px 10px; /* Adjust padding to align with the input */
                border-radius: 0 20px 20px 0;
                cursor: pointer;
            }

            /* Style for the user dropdown */
            .user-dropdown {
                position: relative;
                display: inline-block;
                margin-right: 10px; /* Add some spacing between the user icon and cart icon */
            }

            .user-icon {
                text-decoration: none;
                cursor: pointer;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #ffffff;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
                min-width: 160px;
                padding: 10px;
            }

            .dropdown-content a {
                display: block;
                padding: 8px 12px;
                text-decoration: none;
                color: #333;
                transition: background-color 0.3s;
            }

            .dropdown-content a:hover {
                background-color: #f2f2f2;
            }
        </style>
        <script>
            // JavaScript to toggle the user dropdown
            document.addEventListener("DOMContentLoaded", function () {
                var userLink = document.getElementById("userLink");
                var userDropdown = document.getElementById("userDropdown");

                // Function to close the dropdown when clicking outside
                function closeDropdown() {
                    userDropdown.style.display = "none"; // Hide the dropdown
                }

                userLink.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the default link behavior
                    userDropdown.style.display = "block"; // Display the dropdown
                    event.stopPropagation(); // Prevent the click event from propagating to the document
                });

                // Add a click event listener to the document
                document.addEventListener("click", function () {
                    closeDropdown();
                });

                // Prevent clicks within the dropdown from closing it
                userDropdown.addEventListener("click", function (event) {
                    event.stopPropagation(); // Prevent the click event from propagating to the document
                });
            });
        </script>

    </head>
    <body>
        <header>
            <a href="homepage.php" class="logo" style="text-decoration: none;">Classix</a>
            <ul class="navlist">
                <li><a href="homepage.php" style="text-decoration: none">Home</a></li>
                <li><a href="category.php" style="text-decoration: none">Categories</a></li>
                <li><a href="#contact" style="text-decoration: none">Contact</a></li>
            </ul>
            <!-- Rest of your header content goes here -->
            <div class="header-icons" style="display: flex; align-items: center;">
                <!-- Improved search box -->
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" placeholder="Search products" name="search_query" class="search-input">
                        <button type="submit" class="search-button">
                            <i class='bx bx-search'></i>
                        </button>
                    </form>
                </div>
                <div class="user-dropdown">
                    <a href="#" id="userLink" class="user-icon">
                        <i class="bx bxs-user"></i>
                    </a>
                    <div class="dropdown-content" id="userDropdown">
                        <?php
                        if (isset($_SESSION['c_name']) && isset($_SESSION['c_id'])) {
                            echo "<p style='font-size: 13px; font-weight:bold; color: #333; margin: 0; padding: 8px 0;'>" . $_SESSION['c_name'] . "</p>";
                            echo "<a href='myaccount.php' style='text-decoration: none; color: #333; display: block; padding: 8px 12px;'>My Account</a>";
                            echo "<a href='logout.php' style='text-decoration: none; color: #333; display: block; padding: 8px 12px;'>Log out</a>";
                        } else {
                            echo "<a href='../customerlogin.php' style='text-decoration: none; color: #333; display: block; padding: 8px 12px;'>Login</a>";
                        }
                        ?>
                    </div>
                </div>
                <a style="text-decoration:none" href="add_to_cart.php">
                    <i class='bx bx-shopping-bag'></i>
                </a>
            </div>

        </header>
    </body>
</html>
<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <style>
        body {
            background-image: url('uploads/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Stop page from scrolling */
        }

        .container {
            width: 600px;
            background: rgba(255, 255, 255, 0.9); /* Adjust the alpha value for less transparency */
            border-radius: 20px;
            margin: 100px auto;
            padding: 20px;
            text-align: center;
        }

        .classix {
            font-size: 48px;
            font-weight: bold;
            animation: fadeIn 5s;
        }

        .role-selection {
            margin-top: 20px;
        }

        .role-box {
            display: inline-block;
            margin: 10px;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
        }

        .role-icon img {
            width: 100px;
            height: 100px;
        }

        .role-label {
            font-weight: bold;
            margin-top: 10px;
        }

        .proceed-button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container" id="login-container">
        <div class="classix" id="classix">CLASSIX</div>
        <p style="font-size: 18px;font-weight: bold;">Please select your role:</p>
        <div class="role-selection">
            <div class="role-box" onclick="proceed('Admin')">
                <div class="role-icon"><img src="uploads/boss.png" alt="Admin"></div>
                <div class="role-label">Admin</div><br>
                <button class="proceed-button">Proceed</button>
            </div>
            <div class="role-box" onclick="proceed('ProductManager')">
                <div class="role-icon"><img src="uploads/manager.png" alt="Product Manager"></div>
                <div class="role-label">Product Manager</div><br>
                <button class="proceed-button">Proceed</button>
            </div>
            <div class="role-box" onclick="proceed('DeliveryBoy')">
                <div class="role-icon"><img src="uploads/delivery-boy.png" alt="Delivery Boy"></div>
                <div class="role-label">Delivery Boy</div><br>
                <button class="proceed-button">Proceed</button>
            </div>
        </div>
    </div>

    <script>
        // Function to show the "CLASSIX" animation
        function showClassix() {
            const classix = document.getElementById('classix');
            classix.style.display = 'block';
            setTimein(() => classix.style.display = 'none', 2000);
        }

        // Function to proceed to the selected role page
        function proceed(role) {
            switch (role) {
                case 'Admin':
                    window.location.href = 'adminlogin.php';
                    break;
                case 'ProductManager':
                    window.location.href = 'productmanagerlogin.php';
                    break;
                case 'DeliveryBoy':
                    window.location.href = 'deliveryboylogin.php';
                    break;
                default:
                    alert('Invalid role selection.');
            }
        }

        // Show the "CLASSIX" animation when the page loads
        window.onload = showClassix;
    </script>
</body>

</html>

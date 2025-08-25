<?php
session_start();
require '../db.php';
// Check if the user is not logged in
if (!isset($_SESSION['c_name'])) {
    // Redirect to the login page
    header("Location: /mallt/customerlogin.php");
    exit; // Make sure to exit after the redirect
}
?>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    </head>
    <body>
        <form>
    <input type="button" id="razorpayButton" value="Pay Online" class="checkout-btn">
    
       <?php
// You can fetch the total amount and customer details from your form submission
    $total; // You can adjust this as needed
    $firstName = $_SESSION['c_name'];
    $customerid = $_SESSION['c_id'];

// Replace 'YOUR_RAZORPAY_API_KEY' with your actual Razorpay API key
    $razorpayApiKey = 'rzp_test_z0XHR75PZM8kfE';
    ?>

    <script>
                document.getElementById("razorpayButton").addEventListener("click", function (){
            var totalAmount = <?php echo $total; ?>;
            var firstName = "<?php echo $firstName; ?>";
            var C_id = "<?php echo $customerid; ?>";
            var razorpayApiKey = "<?php echo $razorpayApiKey; ?>";

            var rzp = new Razorpay({
                key: razorpayApiKey,
                amount: totalAmount * 100,
                currency: "INR",
                name: "Mallt",
                description: "Apparel Payment",
                prefill: {
                    "name": firstName,
                    "email": C_id
                },
                handler: (response) => {
                    console.log(response);
                    alert("Payment successful! Payment ID: " + response.razorpay_payment_id);
                    window.location.href = "homepage.php";
                }
            });

            rzp.open();
        });

    </script>
        </form>
</body>
</html> 

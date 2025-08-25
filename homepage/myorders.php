<?php
// Check if a session is not already started before starting it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include your database connection or functions to connect to the database
include('../db.php'); // Replace with your database connection code

// Check if the user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to the login page or display a message
    header('Location: customerlogin.php');
    exit();
}

// Retrieve the customer's orders
$customerId = $_SESSION['c_id'];
$query = "SELECT o.order_id, o.order_date, o.product_id, p.p_name, o.total_bill
          FROM orders o
          JOIN product p ON o.product_id = p.p_id
          WHERE o.customer_id = $customerId";

$result = mysqli_query($con, $query);

// Check if there are any orders
if (mysqli_num_rows($result) > 0) {
    // Orders found, display them in a table
    ?>
<style>
    /* Style for the table */
table {
    width: 100%;
    border-collapse: collapse; /* Collapse borders for a seamless look */
    border: 2px solid #ccc; /* Add a border around the table */
}
</style>

            <div class="container">
                <h1>My Orders</h1><br><br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Total Bill</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['order_id']}</td>";
                            echo "<td>{$row['order_date']}</td>";
                            echo "<td>{$row['product_id']}</td>";
                            echo "<td>{$row['p_name']}</td>";
                            echo "<td>{$row['total_bill']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    <?php
} else {
    // No orders found for the customer
    echo "You have no orders.";
}
?>

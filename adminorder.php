<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Assuming you have a database connection
require_once 'connection.php';

// Retrieve all orders with product and user information
$query = "SELECT o.ORDER_ID, o.ORDER_QUANTITY, p.PRODUCT_ID, p.PRODUCT_NAME, u.USER_ID, u.USER_NAME
          FROM orders o
          INNER JOIN product p ON o.PRODUCT_ID = p.PRODUCT_ID
          INNER JOIN user u ON o.USER_ID = u.USER_ID";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Admin Orders</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Quantity</th>
            <th>Product Name</th>
            <th>User Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['ORDER_ID'] . '</td>';
            echo '<td>' . $row['ORDER_QUANTITY'] . '</td>';
            echo '<td>' . $row['PRODUCT_NAME'] . '</td>';
            echo '<td>' . $row['USER_NAME'] . '</td>';

            // Add Edit and Delete buttons with appropriate links or actions
            echo '<td>';
            echo '<a href="edit_order.php?id=' . $row['ORDER_ID'] . '" class="btn btn-primary">Edit</a>';
            echo ' ';
            echo '<button onclick="confirmUpdate(' . $row['ORDER_ID'] . ')" class="btn btn-success">Order Delivered</button>';
            echo ' ';
            echo '<button onclick ="confirmDelete(' . $row['ORDER_ID'] . ')" class = "btn btn-danger"> Delete Order</button>';
            echo '</td>';

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // JavaScript function to display a confirmation dialog before deleting an order
    function confirmUpdate(orderId) {
        if (confirm("Are you sure you want to confirm this order?")) {
            // Redirect to delete_order.php with the order ID
            window.location.href = "update_order.php?id=" + orderId;
        }
    }

    function confirmDelete(orderId){
        if(confirm("Are you sure you want to delete this order?")){
            window.location.href ="delete_order.php?id=" + orderId;
        }
    }
</script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

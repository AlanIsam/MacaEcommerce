<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to the login page or any other page
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection
require_once 'connection.php';

// Retrieve the user ID from the session
$userId = $_SESSION['userID'];

// Retrieve the cart items for the current user
$cartItemsQuery = "SELECT * FROM cart WHERE USER_ID = '$userId'";
$cartItemsResult = mysqli_query($conn, $cartItemsQuery);

// Check if the cart is empty
if (mysqli_num_rows($cartItemsResult) === 0) {
    // Redirect to the cart page or any other page
    header("Location: cart.php");
    exit();
}

// Get the current date
$orderDate = date('Y-m-d');

// Calculate the total price
$totalPrice = 0;

// Insert the order into the order table
$insertOrderQuery = "INSERT INTO `order` (ORDER_DATE, USER_ID) VALUES ('$orderDate', '$userId')";
mysqli_query($conn, $insertOrderQuery);

// Retrieve the order ID of the inserted order
$orderId = mysqli_insert_id($conn);

// Loop through the cart items and insert them into the order table
while ($row = mysqli_fetch_assoc($cartItemsResult)) {
    $productId = $row['PRODUCT_ID'];
    $quantity = $row['CART_QUANTITY'];

    // Retrieve the product price
    $productQuery = "SELECT PRODUCT_PRICE FROM product WHERE PRODUCT_ID = '$productId'";
    $productResult = mysqli_query($conn, $productQuery);
    $productRow = mysqli_fetch_assoc($productResult);
    $price = $productRow['PRODUCT_PRICE'];

    // Calculate the order price for the current item
    $orderPrice = $price * $quantity;

    // Insert the order item into the order table
    $insertOrderItemQuery = "INSERT INTO order (ORDER_ID, PRODUCT_ID, USER_ID, ORDER_QUANTITY, ORDER_PRICE) VALUES ('$orderId', '$productId', '$userId', '$quantity', '$orderPrice')";
    mysqli_query($conn, $insertOrderItemQuery);

    // Calculate the total price
    $totalPrice += $orderPrice;
}

// Clear the cart for the user
$clearCartQuery = "DELETE FROM cart WHERE USER_ID = '$userId'";
mysqli_query($conn, $clearCartQuery);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Checkout</h1>
    <p>Your order has been placed successfully.</p>
    <p>Total Price: <?php echo $totalPrice; ?></p>
    <a href="index.php" class="btn btn-primary">Return to Home</a>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

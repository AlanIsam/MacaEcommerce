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

// Retrieve the payment option from the URL query parameter
if (!isset($_GET['payment']) || ($_GET['payment'] !== 'credit' && $_GET['payment'] !== 'cash')) {
    // Redirect to the cart page or any other page
    header("Location: cart.php");
    exit();
}

$paymentOption = $_GET['payment'];

// Retrieve the cart items for the current user
$cartItemsQuery = "SELECT * FROM cart WHERE USER_ID = '$userId'";
$cartItemsResult = mysqli_query($conn, $cartItemsQuery);

// Check if the cart is empty
if (mysqli_num_rows($cartItemsResult) === 0) {
    // Redirect to the cart page or any other page
    header("Location: cart.php");
    exit();
}

// Insert the cart items into the order table
while ($row = mysqli_fetch_assoc($cartItemsResult)) {
    $cartId = $row['CART_ID'];
    $quantity = $row['CART_QUANTITY'];
    $productId = $row['PRODUCT_ID'];

    // Insert the order item into the order table
    $insertOrderQuery = "INSERT INTO `order` (ORDER_QUANTITY, PRODUCT_ID, USER_ID) VALUES ('$quantity', '$productId', '$userId')";
    mysqli_query($conn, $insertOrderQuery);

    // Delete the cart item
    $deleteCartItemQuery = "DELETE FROM cart WHERE CART_ID = '$cartId'";
    mysqli_query($conn, $deleteCartItemQuery);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Payment Confirmation</h1>
    <p>Your payment has been confirmed. The items from your cart have been added to your order.</p>
    <a href="index.php" class="btn btn-primary">Return to Home</a>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

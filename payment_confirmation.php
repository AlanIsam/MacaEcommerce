<?php
session_start();


if (!isset($_SESSION['userID'])) {

    header("Location: login.php");
    exit();
}

require_once 'connection.php';


$userId = $_SESSION['userID'];


if (!isset($_GET['payment']) || ($_GET['payment'] !== 'credit' && $_GET['payment'] !== 'cash')) {

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

    // Insert the order item into the order table with the payment type
    $insertOrderQuery = "INSERT INTO `orders` (ORDER_QUANTITY, PRODUCT_ID, USER_ID, PAYMENT_TYPE) VALUES ('$quantity', '$productId', '$userId', '$paymentOption')";
    mysqli_query($conn, $insertOrderQuery);

    // Update the product quantity in the product table
    $updateProductQuery = "UPDATE product SET PRODUCT_QUANTITY = PRODUCT_QUANTITY - '$quantity' WHERE PRODUCT_ID = '$productId'";
    mysqli_query($conn, $updateProductQuery);

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
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

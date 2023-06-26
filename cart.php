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
$cartId = mysqli_insert_id($conn);

// Store the cart ID in the session
$_SESSION['cartID'] = $cartId;

// Check if the form is submitted for adding an item to the cart
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantities = $_POST['quantity'];

    // Insert the items into the cart table
    foreach ($quantities as $quantity) {
        $insertQuery = "INSERT INTO cart (CART_QUANTITY, PRODUCT_ID, USER_ID) VALUES ('$quantity', '$productId', '$userId')";
        mysqli_query($conn, $insertQuery);
        $cartId = mysqli_insert_id($conn);
    }

    $_SESSION['cartID'] = $cartId;
    // Redirect back to the product page or any other page

    header("Location: product.php?id=$productId");
    exit();
}

// Check if the form is submitted for deleting a cart item
if (isset($_POST['delete_cart_item'])) {
    $cartItemId = $_POST['cart_item_id'];

    // Delete the item from the cart table
    $deleteQuery = "DELETE FROM cart WHERE CART_ID = '$cartItemId' AND USER_ID = '$userId'";
    mysqli_query($conn, $deleteQuery);

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}

// Fetch the cart items and their corresponding product details from the database for the current user
$query = "SELECT cart.CART_ID, product.PRODUCT_NAME, product.PRODUCT_PRICE, cart.CART_QUANTITY 
          FROM cart 
          INNER JOIN product ON cart.PRODUCT_ID = product.PRODUCT_ID 
          WHERE cart.USER_ID = '$userId'";
$result = mysqli_query($conn, $query);

$totalPrice = 0; // Variable to store the total price

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Cart</h1>
    <?php
    // Check if there are cart items for the user
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table class="table">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Loop through the cart items and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['PRODUCT_NAME'] . '</td>';
                echo '<td>' . $row['CART_QUANTITY'] . '</td>';
                echo '<td>' . 'RM ' . $row['PRODUCT_PRICE'] . '</td>';
                echo '<td>
                          <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this item from your cart?\')">
                            <input type="hidden" name="cart_item_id" value="' . $row['CART_ID'] . '">
                            <button type="submit" name="delete_cart_item" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                      </td>';
                echo '</tr>';


                // Calculate the total price for each item
                $itemTotal = $row['CART_QUANTITY'] * $row['PRODUCT_PRICE'];
                $totalPrice += $itemTotal;
            }
            ?>
            </tbody>
        </table>
        <h4><b>Total Price: <?php echo ' RM' . $totalPrice; ?></b></h4>

        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Credit Card</h5>
                        <p class="card-text">Pay with your credit card.</p>
                        <a href="userdetails.php?payment=credit" class="btn btn-primary">Pay with Credit Card</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cash</h5>
                        <p class="card-text">Pay with cash upon delivery.</p>
                        <a href="userdetails.php?payment=cash" class="btn btn-primary">Pay with Cash</a>
                    </div>
                </div>
            </div>
        </div>
        <?php

    } else {
        // No cart items found for the user
        echo '<p>Your cart is empty.</p>';
    }

    mysqli_close($conn);
    ?>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-l43LyGQmEEU9NwqNK9VIRvLeK79Zp5hZBGS+WQ2iKZkMm3BvYJcwZ86R1YRLJw8K" crossorigin="anonymous"></script>
</body>
</html>

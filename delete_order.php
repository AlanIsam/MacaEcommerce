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

// Check if the order ID is provided in the URL
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Retrieve the order details
    $query = "SELECT o.ORDER_ID, o.ORDER_QUANTITY, p.PRODUCT_PRICE
              FROM orders o
              INNER JOIN product p ON o.PRODUCT_ID = p.PRODUCT_ID
              WHERE o.ORDER_ID = '$orderId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Copy order details to sales table
    $salesId = $row['ORDER_ID'];
    $salesQuantity = $row['ORDER_QUANTITY'];
    $salesPrice = $row['PRODUCT_PRICE'];

    $insertQuery = "INSERT INTO sale (SALES_ID, SALES_QUANTITY, SALES_PRICES)
                    VALUES ('$salesId', '$salesQuantity', '$salesPrice')";
    mysqli_query($conn, $insertQuery);

    // Delete the order from the database
    $deleteQuery = "DELETE FROM orders WHERE ORDER_ID = '$orderId'";
    mysqli_query($conn, $deleteQuery);

    // Redirect to the adminorder.php page
    header('Location: adminorder.php');
    exit();
} else {
    // Redirect to the adminorder.php page if the order ID is not provided
    header('Location: adminorder.php');
    exit();
}
?>

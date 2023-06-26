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

    // Retrieve the order data from the database
    $query = "SELECT * FROM orders WHERE ORDER_ID = '$orderId'";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);

    // Check if the order exists
    if ($order) {
        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Get the updated order quantity from the form
            $orderQuantity = $_POST['order_quantity'];

            // Update the order quantity in the database
            $updateQuery = "UPDATE orders SET ORDER_QUANTITY = '$orderQuantity' WHERE ORDER_ID = '$orderId'";
            mysqli_query($conn, $updateQuery);
            // Display an alert box after successful update
            header('Location: adminorder.php');
        }
    } else {
        // Display an error message if the order doesn't exist
        echo 'Order not found.';
    }
} else {
    // Redirect to the adminorder.php page if the order ID is not provided
    header('Location: adminorder.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Edit Order</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="order_quantity" class="form-label">Order Quantity</label>
            <input type="text" class="form-control" id="order_quantity" name="order_quantity"
                   value="<?php echo $order['ORDER_QUANTITY']; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary" onclick="Alert()">Update</button>

    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script> function Alert() {
        alert("You have successfully updated the order!");
    }</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>


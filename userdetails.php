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

// Check if the payment option is specified in the URL query parameter
if (!isset($_GET['payment']) || ($_GET['payment'] !== 'credit' && $_GET['payment'] !== 'cash')) {
    // Redirect to the checkout page or any other page
    header("Location: checkout.php");
    exit();
}

$paymentOption = $_GET['payment'];

// Handle the form submission for updating user details
if (isset($_POST['submit'])) {
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update the user details in the database
    $updateQuery = "UPDATE user SET USER_PHONENUM = '$phoneNumber', USER_ADDRESS = '$address' WHERE USER_ID = '$userId'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the payment confirmation page or any other page
    header("Location: payment_confirmation.php?payment=$paymentOption");
    exit();
}

// Retrieve the user details from the database
$userQuery = "SELECT USER_PHONENUM, USER_ADDRESS FROM user WHERE USER_ID = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>User Details</h1>
    <form method="post">
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $userData['USER_PHONENUM']; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="4"><?php echo $userData['USER_ADDRESS']; ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


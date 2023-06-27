<?php
session_start();


if (!isset($_SESSION['userID'])) {

    header("Location: login.php");
    exit();
}


require_once 'connection.php';


$userId = $_SESSION['userID'];
$cartId = mysqli_insert_id($conn);


$_SESSION['cartID'] = $cartId;

if (!isset($_GET['payment']) || ($_GET['payment'] !== 'credit' && $_GET['payment'] !== 'cash')) {

    header("Location: checkout.php");
    exit();
}

$paymentOption = $_GET['payment'];


if (isset($_POST['submit'])) {
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];


    if (!is_numeric($phoneNumber)) {
        $error = "Phone number should be an integer.";
    } else {

        $updateQuery = "UPDATE user SET USER_PHONENUM = '$phoneNumber', USER_ADDRESS = '$address' WHERE USER_ID = '$userId'";
        mysqli_query($conn, $updateQuery);


        header("Location: payment_confirmation.php?payment=$paymentOption");
        exit();
    }
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
            <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]+" value="<?php echo $userData['USER_PHONENUM']; ?>" required>
            <div class="invalid-feedback">Please enter a valid integer for the phone number.</div>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="4"><?php echo $userData['USER_ADDRESS']; ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php } ?>
</div>
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


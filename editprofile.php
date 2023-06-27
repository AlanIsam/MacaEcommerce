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

$userID = $_SESSION['userID'];

// Retrieve the user details from the database
$userQuery = "SELECT USER_NAME, USER_PASSWORD, USER_PHONENUM, USER_ADDRESS, USER_EMAIL FROM user WHERE USER_ID = '$userID'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

// Handle form submission for updating user details
if (isset($_POST['submit'])) {
    $userName = $_POST['user_name'];
    $userPassword = $_POST['user_password'];
    $userPhoneNum = $_POST['user_phonenum'];
    $userAddress = $_POST['user_address'];
    $userEmail = $_POST['user_email'];

    // Update the user details in the database
    $updateQuery = "UPDATE user SET USER_NAME = '$userName', USER_PASSWORD = '$userPassword', USER_PHONENUM = '$userPhoneNum', USER_ADDRESS = '$userAddress', USER_EMAIL = '$userEmail' WHERE USER_ID = '$userID'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the profile page or any other page
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Edit Profile</h1>
    <form method="post">
        <div class="mb-3">
            <label for="user_name" class="form-label">Username</label>
            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $userData['USER_NAME']; ?>">
        </div>
        <div class="mb-3">
            <label for="user_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="user_password" name="user_password" value="<?php echo $userData['USER_PASSWORD']; ?>">
        </div>
        <div class="mb-3">
            <label for="user_phonenum" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="user_phonenum" name="user_phonenum" value="<?php echo $userData['USER_PHONENUM']; ?>">
        </div>
        <div class="mb-3">
            <label for="user_address" class="form-label">Address</label>
            <input type="text" class="form-control" id="user_address" name="user_address" value="<?php echo $userData['USER_ADDRESS']; ?>">
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo $userData['USER_EMAIL']; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();


if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'admin') {

    header("Location: login.php");
    exit();
}


require_once 'connection.php';


if (!isset($_GET['id'])) {

    header("Location: useradmin.php");
    exit();
}

$userId = $_GET['id'];


$userQuery = "SELECT USER_NAME, USER_TYPE, USER_PHONENUM, USER_ADDRESS, USER_EMAIL FROM user WHERE USER_ID = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);


if (isset($_POST['submit'])) {
    $userName = $_POST['user_name'];
    $userType = $_POST['user_type'];
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];


    $updateQuery = "UPDATE user SET USER_NAME = '$userName', USER_TYPE = '$userType', USER_PHONENUM = '$phoneNumber', USER_ADDRESS = '$address', USER_EMAIL = '$email' WHERE USER_ID = '$userId'";
    mysqli_query($conn, $updateQuery);

    header("Location: useradmin.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Edit User</h1>
    <form method="post">
        <div class="mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $userData['USER_NAME']; ?>">
        </div>
        <div class="mb-3">
            <label for="user_type" class="form-label">User Type</label>
            <select class="form-control" id="user_type" name="user_type">
                <option value="user" <?php if ($userData['USER_TYPE'] === 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($userData['USER_TYPE'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $userData['USER_PHONENUM']; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="4"><?php echo $userData['USER_ADDRESS']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['USER_EMAIL']; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

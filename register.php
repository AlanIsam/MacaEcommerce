<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'connection.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $userType = 'user';

    if ($password !== $confirmPassword) {
        $errorMsg = "Passwords do not match.";
    } else {
        // Check if the email already exists in the database
        $checkQuery = "SELECT * FROM user WHERE USER_EMAIL = '$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $errorMsg = "Email already exists.";
        } else {
            // Insert the new user into the database
            $insertQuery = "INSERT INTO user (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_TYPE) VALUES ('$username', '$email', '$password','$userType')";
            if (mysqli_query($conn, $insertQuery)) {
                $_SESSION['userName'] = $username;
                header("Location: login.php");
                exit;
            } else {
                $errorMsg = "Error: " . mysqli_error($conn);
            }
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .registration-box {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="registration-box">
        <h2>Registration</h2>
        <?php if (!empty($errorMsg)) { ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php } ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'connection.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE USER_EMAIL = '$email' AND USER_PASSWORD = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userType = $row['USER_TYPE'];
        $userName = $row['USER_NAME'];

        // Set session variables
        $_SESSION['userType'] = $userType;
        $_SESSION['userName'] = $userName;

        if ($userType == 'user') {
            // Redirect to index.php for regular user
            header('Location: index.php');
            exit();
        } elseif ($userType == 'admin') {
            // Redirect to dashboard.php for admin user
            header('Location: dashboard.php');
            exit();
        }
    } else {
        // Invalid credentials
        echo "Invalid email or password.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .login-box {
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
    <div class="login-box">
        <h2 align="center">Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <a href = "register.php">don't have an account yet? Register now!</a> <br>
            <br><button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
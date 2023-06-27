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

// Handle form submission for sending a message
if (isset($_POST['submit'])) {
    $message = $_POST['message'];

    // Get the current date and time
    $timeSent = date('Y-m-d H:i:s');

    // Insert the message into the database
    $insertQuery = "INSERT INTO messages (MESSAGE, TIME_SENT, USER_ID) VALUES ('$message', '$timeSent', '$userID')";
    mysqli_query($conn, $insertQuery);

    // Redirect to the messages page or any other page
    header("Location: message.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Send Message</h1>
    <form method="post">
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Send</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>

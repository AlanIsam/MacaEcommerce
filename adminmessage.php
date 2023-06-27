<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'admin') {
    // Redirect to the login page or any other page
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection
require_once 'connection.php';

// Retrieve all messages from the database
$messagesQuery = "SELECT messages.MESSAGE_ID, messages.MESSAGE, messages.TIME_SENT, user.USER_NAME FROM messages JOIN user ON messages.USER_ID = user.USER_ID";
$messagesResult = mysqli_query($conn, $messagesQuery);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Admin Messages</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Message ID</th>
            <th>Message</th>
            <th>Time Sent</th>
            <th>Username</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($messageData = mysqli_fetch_assoc($messagesResult)): ?>
            <tr>
                <td><?php echo $messageData['MESSAGE_ID']; ?></td>
                <td><?php echo $messageData['MESSAGE']; ?></td>
                <td><?php echo $messageData['TIME_SENT']; ?></td>
                <td><?php echo $messageData['USER_NAME']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

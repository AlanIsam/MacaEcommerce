<?php
session_start();


if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'admin') {

    header("Location: login.php");
    exit();
}


require_once 'connection.php';

// Retrieve non-admin users from the database
$userQuery = "SELECT USER_ID, USER_NAME, USER_TYPE FROM user WHERE USER_TYPE != 'admin'";
$userResult = mysqli_query($conn, $userQuery);

// Handle user deletion
if (isset($_POST['delete'])) {
    $userId = $_POST['user_id'];

    // Delete the user from the database
    $deleteQuery = "DELETE FROM user WHERE USER_ID = '$userId'";
    mysqli_query($conn, $deleteQuery);

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
    <title>User Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>User Administration</h1>
    <table class="table">
        <thead>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>User Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($userResult)) { ?>
            <tr>
                <td><?php echo $row['USER_ID']; ?></td>
                <td><?php echo $row['USER_NAME']; ?></td>
                <td><?php echo $row['USER_TYPE']; ?></td>
                <td>
                    <a href="edituser.php?id=<?php echo $row['USER_ID']; ?>" class="btn btn-primary">Edit</a>
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?php echo $row['USER_ID']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

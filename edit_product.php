<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'admin') {
    // Redirect to the login page or any other page
    header("Location: login.php");
    exit();
}

require_once 'connection.php';

if (!isset($_GET['id'])) {
    header("Location: adminproduct.php");
    exit();
}

$productId = $_GET['id'];


$productQuery = "SELECT PRODUCT_NAME, PRODUCT_QUANTITY, PRODUCT_PRICE, PRODUCT_TYPE FROM product WHERE PRODUCT_ID = '$productId'";
$productResult = mysqli_query($conn, $productQuery);
$productData = mysqli_fetch_assoc($productResult);

// Handle form submission for updating product details
if (isset($_POST['submit'])) {
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productPrice = $_POST['product_price'];
    $productType = $_POST['product_type'];

    $updateQuery = "UPDATE product SET PRODUCT_NAME = '$productName', PRODUCT_QUANTITY = '$productQuantity', PRODUCT_PRICE = '$productPrice', PRODUCT_TYPE = '$productType' WHERE PRODUCT_ID = '$productId'";
    mysqli_query($conn, $updateQuery);
    header("Location: adminproduct.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1>Edit Product</h1>
    <form method="post">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $productData['PRODUCT_NAME']; ?>">
        </div>
        <div class="mb-3">
            <label for="product_quantity" class="form-label">Product Quantity</label>
            <input type="number" class="form-control" id="product_quantity" name="product_quantity" value="<?php echo $productData['PRODUCT_QUANTITY']; ?>">
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" value="<?php echo $productData['PRODUCT_PRICE']; ?>">
        </div>
        <div class="mb-3">
            <label for="product_type" class="form-label">Product Type</label>
            <input type="text" class="form-control" id="product_type" name="product_type" value="<?php echo $productData['PRODUCT_TYPE']; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

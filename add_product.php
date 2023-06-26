<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

require_once 'connection.php';

$message = '';

if (isset($_POST['add_product'])) {
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productType = $_POST['product_type'];
    $productPrice = $_POST['product_price'];

    $image = $_FILES['product_image']['name'];
    $image_size = $_FILES['product_image']['size'];
    $image_tmp_name = $_FILES['product_image']['tmp_name'];
    $image_folder = 'img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `product` WHERE PRODUCT_NAME = ?");
    $select_products->bind_param('s', $productName);
    $select_products->execute();
    $select_products->store_result();

    if ($select_products->num_rows > 0) {
        $message = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `product` (PRODUCT_NAME, PRODUCT_QUANTITY, PRODUCT_TYPE, PRODUCT_PRICE, PRODUCT_IMAGE) VALUES (?,?,?,?,?)");
            $insert_product->bind_param('sssss', $productName, $productQuantity, $productType, $productPrice, $image);
            $insert_product->execute();

            $message = 'New product added!';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Add Product</h1>
    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php } ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="product_quantity" class="form-label">Product Quantity</label>
            <input type="number" class="form-control" id="product_quantity" name="product_quantity" required>
        </div>
        <div class="mb-3">
            <label for="product_type" class="form-label">Product Type</label>
            <input type="text" class="form-control" id="product_type" name="product_type" required>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required>
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="product_image" name="product_image" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

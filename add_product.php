<?php
// Assuming you have a database connection
require_once 'connection.php';

$msg = "";

// If the form is submitted...
if (isset($_POST['add_product'])) {
    // Retrieve product parameters from the form
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productPrice = $_POST['product_price'];
    $productType = $_POST['product_type'];
    $imageFilename = $_FILES['product_image']['name'];
    $imageTempname = $_FILES['product_image']['tmp_name'];
    $imageFolder = "./img/" . $imageFilename;

    // Move the uploaded image to the "img" directory
    if (move_uploaded_file($imageTempname, $imageFolder)) {
        // Insert product details into the database
        $insertQuery = "INSERT INTO product (PRODUCT_NAME, PRODUCT_QUANTITY, PRODUCT_PRICE, PRODUCT_TYPE, PRODUCT_IMAGE)
                        VALUES ('$productName', '$productQuantity', '$productPrice', '$productType', '$imageFilename')";

        if (mysqli_query($conn, $insertQuery)) {
            // Redirect to adminproduct.php after successful addition
            header("Location: adminproduct.php");
            exit();
        } else {
            $msg = "Failed to add the product. Please try again.";
        }
    } else {
        $msg = "Failed to upload image. Please try again.";
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
    <?php if (!empty($msg)) { ?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
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
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required>
        </div>
        <div class="mb-3">
            <label for="product_type" class="form-label">Product Type</label>
            <input type="text" class="form-control" id="product_type" name="product_type" required>
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

<?php
// Assuming you have a database connection
require_once 'connection.php';

// Retrieve all products from the product table
$productsQuery = "SELECT * FROM product";
$productsResult = mysqli_query($conn, $productsQuery);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Product Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Admin Product Overview</h1>
    <a href="add_product.php" class="btn btn-primary mb-3">Upload new Product</a>
    <table class="table">
        <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Quantity</th>
            <th>Product Price</th>
            <th>Product Type</th>
            <th>Product Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($productsResult)) { ?>
            <tr>
                <td><?php echo $row['PRODUCT_ID']; ?></td>
                <td><?php echo $row['PRODUCT_NAME']; ?></td>
                <td><?php echo $row['PRODUCT_QUANTITY']; ?></td>
                <td><?php echo'RM ' .$row['PRODUCT_PRICE']; ?></td>
                <td><?php echo $row['PRODUCT_TYPE']; ?></td>
                <td>
                    <?php if ($row['PRODUCT_IMAGE']) {
                        $uniqueID = $row['PRODUCT_IMAGE'];
                        $imagePath = 'img/' . $uniqueID;
                        if (file_exists($imagePath)) { ?>
                            <img src="<?php echo $imagePath; ?>" alt="Product Image" width="100">
                        <?php } else { ?>
                            No Image Available
                        <?php }
                    } else { ?>
                        No Image Available
                    <?php } ?>
                </td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['PRODUCT_ID']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_product.php?id=<?php echo $row['PRODUCT_ID']; ?>" class="btn btn-danger" onclick="return confirmDelete()">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this product?");
    }
</script>
</body>
</html>


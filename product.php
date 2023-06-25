<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BestCrochet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-height: 300px;
            object-fit: contain;
        }
        .product-details-box {
            border: 1px solid #ccc;
            padding: 20px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <?php
    // Retrieve the PRODUCT_ID from the query parameter
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Fetch the product details from the database using the PRODUCT_ID
        require_once 'connection.php';
        $query = "SELECT * FROM product WHERE PRODUCT_ID = '$productId'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Product found, retrieve the details
            $row = mysqli_fetch_assoc($result);
            $productName = $row['PRODUCT_NAME'];
            $productQuantity = $row['PRODUCT_QUANTITY'];
            $productPrice = $row['PRODUCT_PRICE'];
            $productType = $row['PRODUCT_TYPE'];
            $productImage = $row['PRODUCT_IMAGE'];
            ?>
            <div class="row mt-5">
                <div class="col-md-6">
                    <?php if ($productImage) { ?>
                        <img class="product-image img-fluid" src="img/<?php echo $productImage; ?>" alt="Product Image">
                    <?php } else { ?>
                        <p>No Image Available</p>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <div class="product-details-box">
                        <h2><?php echo $productName; ?></h2>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Quantity:</span>
                                <input type="number" class="form-control" name="quantity[]" style="max-width: 100px" min="1" value="1">
                            </div>
                            <p class="mb-3">Price: RM <?php echo $productPrice; ?></p>
                            <p class="mb-3">Type: <?php echo $productType; ?></p>
                            <button type="submit" name="add_to_cart" class="btn btn-primary" onclick="showAlert()">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // Product not found
            echo '<p>Product not found.</p>';
        }

        mysqli_close($conn);
    } else {
        // Redirect back to index.php if no PRODUCT_ID is provided
        header('Location: index.php');
        exit();
    }
    ?>
</div>

<script>
    function showAlert() {
        alert('Product added to cart successfully!');
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

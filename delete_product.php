<?php
// Assuming you have a database connection
require_once 'connection.php';

// Check if the product ID is provided as a query parameter
if (!isset($_GET['id'])) {
    // Redirect to the adminproduct.php page or any other page
    header("Location: adminproduct.php");
    exit();
}

$productId = $_GET['id'];

// Delete the product from the product table
$deleteProductQuery = "DELETE FROM product WHERE PRODUCT_ID = '$productId'";
mysqli_query($conn, $deleteProductQuery);

mysqli_close($conn);

// Redirect to the adminproduct.php page or any other page
header("Location: adminproduct.php");
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <script>
        function confirmDelete() {
            var result = confirm("Are you sure you want to delete this product?");
            if (result) {
                window.location = "delete_product.php?id=<?php echo $productId; ?>";
            } else {
                // Redirect to the adminproduct.php page or any other page
                window.location = "adminproduct.php";
            }
        }
    </script>
</head>
<body>
<h1>Delete Product</h1>
<button onclick="confirmDelete()">Delete</button>
</body>
</html>

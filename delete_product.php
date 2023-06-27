<?php
require_once 'connection.php';

if (!isset($_GET['id'])) {
    header("Location: adminproduct.php");
    exit();
}

$productId = $_GET['id'];


$deleteProductQuery = "DELETE FROM product WHERE PRODUCT_ID = '$productId'";
mysqli_query($conn, $deleteProductQuery);

mysqli_close($conn);

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

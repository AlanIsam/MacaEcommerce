<?php
// Assuming you have a database connection
require_once 'connection.php';

// Retrieve the total number of orders
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM `order`";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];

// Retrieve the total number of users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM user";
$totalUsersResult = mysqli_query($conn, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

// Retrieve the total number of products
$totalProductsQuery = "SELECT COUNT(*) AS total_products FROM product";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProducts = mysqli_fetch_assoc($totalProductsResult)['total_products'];

// Retrieve the total product sales and profit
$totalSalesQuery = "SELECT SUM(ORDER_QUANTITY) AS total_sales, SUM(ORDER_QUANTITY * PRODUCT_PRICE) AS total_profit FROM `order` o JOIN product p ON o.PRODUCT_ID = p.PRODUCT_ID";
$totalSalesResult = mysqli_query($conn, $totalSalesQuery);
$totalSalesData = mysqli_fetch_assoc($totalSalesResult);
$totalSales = $totalSalesData['total_sales'];
$totalProfit = $totalSalesData['total_profit'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text"><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text"><?php echo $totalProducts; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Product Sales</h5>
                    <p class="card-text"><?php echo $totalSales; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Profit</h5>
                    <p class="card-text"><?php echo 'RM ' .$totalProfit; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

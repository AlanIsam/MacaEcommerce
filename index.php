<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BestCrochet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="image/image1.png" alt="First slide">
            <div class = "overlay">
                <div class="carousel-caption">
                <h2>Best Crochet Store</h2>
                <p>Where your sastifaction is our priority</p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="image/image3.jpg" alt="Second slide">
            <div class = "overlay">
            <div class="carousel-caption">
                <h2>Best Crochet Store</h2>
                <p>Where our quality is everything</p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="image/image2.jpg" alt="Third slide">
            <div class = "overlay">
                <div class="carousel-caption">
                    <h2>Order now!</h2>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>
<script>
    // Enable autoplay for the carousel
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 3000 // Time in milliseconds between each slide transition
        });
    });
</script>



<!-- Bootstrap JS with jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<br>
<div class="container">
    <style>
        .product-image {
            height: 200px; /* Adjust the height as per your requirements */
            object-fit: cover;
        }
    </style>

    <div class="row">
        <?php
        // Fetch data from the database
        require_once 'connection.php';
        $query = "SELECT * FROM product";
        $result = mysqli_query($conn, $query);

        // Loop through the data and display it in cards
        while ($row = mysqli_fetch_assoc($result)) {
            $productName = $row['PRODUCT_NAME'];
            $productQuantity = $row['PRODUCT_QUANTITY'];
            $productPrice = $row['PRODUCT_PRICE'];
            $productType = $row['PRODUCT_TYPE'];
            $productImage = $row['PRODUCT_IMAGE'];
            $productId = $row['PRODUCT_ID'];
            ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img class="card-img-top product-image" src="data:image/jpeg;base64,<?php echo base64_encode($productImage); ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $productName; ?></h5>
                        <p class="card-text">
                            Quantity: <?php echo $productQuantity; ?><br>
                            Price: <?php echo 'RM' .$productPrice; ?><br>
                            Type: <?php echo $productType; ?>
                        </p>
                        <a href="product.php?id=<?php echo $productId; ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
            <?php
        }
        mysqli_close($conn);
        ?>
    </div>

</div>
</body>
</html>

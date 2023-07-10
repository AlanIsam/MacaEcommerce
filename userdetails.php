<?php
session_start();


if (!isset($_SESSION['userID'])) {

    header("Location: login.php");
    exit();
}


require_once 'connection.php';


$userId = $_SESSION['userID'];
$cartId = mysqli_insert_id($conn);


$_SESSION['cartID'] = $cartId;

if (!isset($_GET['payment']) || ($_GET['payment'] !== 'credit' && $_GET['payment'] !== 'cash')) {

    header("Location: checkout.php");
    exit();
}

$paymentOption = $_GET['payment'];


if (isset($_POST['submit'])) {
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];


    if (!is_numeric($phoneNumber)) {
        $error = "Phone number should be an integer.";
    } else {

        $updateQuery = "UPDATE user SET USER_PHONENUM = '$phoneNumber', USER_ADDRESS = '$address' WHERE USER_ID = '$userId'";
        mysqli_query($conn, $updateQuery);


        header("Location: payment_confirmation.php?payment=$paymentOption");
        exit();
    }
}

// Retrieve the user details from the database
$userQuery = "SELECT USER_PHONENUM, USER_ADDRESS FROM user WHERE USER_ID = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <h3 class="text-center">Payment Details</h3>
                        <img class="img-responsive cc-img" src="http://www.prepbootstrap.com/Content/images/shared/misc/creditcardicons.png">
                    </div>
                </div>
                <div class="panel-body">
                    <form method="post" id="payment-form">
                        <div class="form-group">
                            <label for="credit_card_number">Card Number</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="credit_card_number" name="credit_card_number" placeholder="Valid Card Number" required>
                                <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expiration_date">Expiration Date</label>
                            <div class="input-group">
                                <select class="form-control" id="expiration_month" name="expiration_month" required>
                                    <option value=""> Select Month </option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <select class="form-control" id="expiration_year" name="expiration_year" required>
                                    <option value=""> Select Year </option>
                                    <option value="23">2023</option>
                                    <option value="24">2024</option>
                                    <option value="25">2025</option>
                                    <option value="26">2026</option>
                                    <option value="27">2027</option>
                                    <option value="28">2028</option>
                                    <option value="29">2029</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CV Code</label>
                            <input type="tel" class="form-control" id="cvv" name="cvv" placeholder="CVC" required>
                        </div>
                        <div class="form-group">
                            <label for="card_owner">Card Owner</label>
                            <input type="text" class="form-control" id="card_owner" name="card_owner" placeholder="Card Owner Names" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]+" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-warning btn-lg btn-block">Process payment</button>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("payment-form").addEventListener("submit", function(event) {
        var form = event.target;
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add("was-validated");
    });
</script>

<style>
    .cc-img {
        margin: 0 auto;
    }
</style>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php } ?>
</div>
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


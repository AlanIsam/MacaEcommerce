
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Maca E-commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['userName'])) {
                        $username = $_SESSION['userName'];
                        echo '<a class="nav-link" href="editprofile.php"><i class="fas fa-user"></i> '.$username.'</a>';
                    } else {
                        echo '<a class="nav-link" href="login.php"><i class="fas fa-user"></i> Login</a>';
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="message.php"><i class="fas fa-heart"></i>Message Us!</a>
                </li>
                <?php
                if (isset($_SESSION['userName'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

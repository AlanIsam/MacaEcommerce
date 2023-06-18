<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Maca E-commerce</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <form class="form-inline">
                    <div class="input-group">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i>Search</button>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <?php
                if (isset($_SESSION['userName'])) {
                    $username = $_SESSION['userName'];
                    echo '<a class="nav-link" href="#"><i class="fas fa-user"></i> '.$username.'</a>';
                } else {
                    echo '<a class="nav-link" href="login.php"><i class="fas fa-user"></i> Login</a>';
                }
                ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
            <?php
            if (isset($_SESSION['userName'])) {
                echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

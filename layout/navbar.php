<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white bg_color">
        <div class="container">
            <a class="navbar-brand font-weight-bold" style="font-family: 'Lato', sans-serif; color: #481639"
                href="index.php"><img src="images/Logo cropped.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="burger.php">Burgers</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="side.php">Sides</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="drink.php">Drinks</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="create.php">Create Burger</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="about_us.php">About Us</a>
                    </li>

                    <?php if (isset($_SESSION['email'])) { ?>
                    <li class="nav-item p-1">
                        <a class="nav-link text-dark font-weight-bold" href="cart.php">Basket</a>
                    </li>

                    <li class="nav-item back_nav p-1 shadow-sm">
                        <a class="nav-link text-white font-weight-bold" href="profile.php"><i
                                class="far fa-user mr-2"></i>Profile</a>
                    </li>
                    <?php } else { ?>

                    <li class="nav-item back_nav p-1 shadow-sm">
                        <a class="nav-link text-white font-weight-bold" href="signInUp.php"><i
                                class="far fa-user mr-2"></i>Login /
                            Register</a>
                    </li>
                    <?php } ?>



                </ul>

            </div>
        </div>
    </nav>
</div>
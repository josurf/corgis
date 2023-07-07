<!-- back to top button -->
<a id="button"></a>

<!-- Nav Bar -->
<section id="title">
    <div class="container-fluid main-container">

        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="<?php echo SITE_ROOT; ?>index.php">Corgi Fansite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>index.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-house"></i> Home</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>aboutMe.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-user"></i> About Me</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>gallery.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-images"></i> Gallery</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>contact.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fas fa-hand-point-up"></i> Contact</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>game.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-gamepad"></i> Game</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>shop.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-shop"></i> Shop</button></a>
                    </li>
                    <li class="nav-item" id="adminButton">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>admin.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-unlock"></i> Admin</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_ROOT; ?>logout.php"><button type="NavBarButtons" class="btn navbtn btn-outline-light btn-lg"><i class="fa-solid fa-door-open"></i> Logout</button></a>
                    </li>
                </ul>
            </div>
            <a id="cartButton" href="<?php echo SITE_ROOT; ?>cart.php"><i class="fa-solid fa-cart-shopping fa-3x"></i>
                <span id="badge">
                <?php 
                $cartQuery = DB::query("SELECT DISTINCT cartItem FROM cart WHERE fanID=%i and cartStatus>%i", $userID, 0);
                foreach($cartQuery as $cartResult){
                    $userCartItems = $cartResult["cartItem"];
                }
                echo count($cartQuery);
                ?>
                </span>
            </a>
        </nav>
    </div>
</section>
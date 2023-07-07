<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "shop";

if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}

// DB::debugMode();

if(isset($_SESSION["fanEmail"])){
	$currentUserEmail = $_SESSION["fanEmail"];
}
elseif(isset($_COOKIE["fanEmail"])){
	$currentUserEmail = $_COOKIE["fanEmail"];
}

//Query Current LoggedIn User DB
$userQuery = DB::query("SELECT * FROM fan WHERE fanEmail=%s", $currentUserEmail);
foreach($userQuery as $userResult){
    $userID = $userResult["fanID"];
    $userName = $userResult["fanName"];
    $userEmail = $userResult["fanEmail"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>
    <link rel="stylesheet" href="css/shop.css">
    <link rel="stylesheet" href="css/buttonTheme.css">
</head>

<body>
	<?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
	<div class="container-fluid" style="min-height:600px;overflow-y:auto;">
        
        <button type="button" name="addNewUser" onclick="location.href='<?php echo SITE_ROOT . 'cart.php'?>';" class="btn btn-primary" style="margin:10px;">Go to Cart <i class="fa-solid fa-cart-shopping"></i></button>

        <button id="addProduct" type="button" name="addNewProduct" onclick="location.href='<?php echo SITE_ROOT . 'product-add.php'?>';" class="btn btn-primary" style="margin:10px;">Add a Product</button>

        <div class="row row-cols-1 row-cols-md-4 g-4">

        <?php
        $allProductQuery = DB::query("SELECT * FROM product");
        foreach($allProductQuery as $allProductResult){
            $allProductID = $allProductResult["productID"];
            $allProductName = $allProductResult["productName"];
            $allProductPrice = $allProductResult["productPrice"];
            $allProductQuantity = $allProductResult["productQuantity"];
            $allProductImageUrl = $allProductResult["productImageUrl"];
        ?>

            <div class="col allShopItems" <?php if($allProductQuantity == 0){echo "style=display:none;";} ?>>
                <div class="card <?php if($allProductQuantity == 0){echo "bg-dark";} ?>" style="height:450px;width:350px;border-radius:5%; <?php if($allProductQuantity == 0){echo "color:white;border:solid red 5px;";} ?> ">
                    <img style="height:60%;border-radius:5%;" src="<?php echo $allProductImageUrl; ?>" class="card-img-top shopImg" alt="<?php echo $allProductName; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $allProductName; ?></h5>
                        <p class="card-text">$<?php echo $allProductPrice; ?></p>
                        <p class="card-text" style="color:red;"><?php if($allProductQuantity <= 20){echo "Hurry, <u>" . $allProductQuantity . "</u> left in stock!";} ?></p>
                    </div>
                    <form method="POST" action="addToCart.php">
                        <input style="display:none;" type="text" name="productName" value="<?php echo $allProductName; ?>">
                        <input style="display:none;" type="number" step="0.01" name="productPrice" value="<?php echo $allProductPrice; ?>">
                        <label for="productQuantity" class="form-label" style="padding-left:15px;">Quantity: </label>
                        <input style="width:15%;" type="number" name="productQuantity" min="0" max="999" value="0">
                        <button type="submit" id="addToCart" name="addToCart" class="btn btn-primary" style="margin:5px;">Add to Cart <i class="fa-solid fa-cart-plus"></i></button>
                        <a class="editProduct" href="<?php echo SITE_ROOT; ?>product-edit.php?productID=<?php echo $allProductID; ?>"><i class="fa-regular fa-pen-to-square me-3 fs-3" style="color: #2C3639;<?php if($allProductQuantity == 0){echo "color:white;";} ?>"></i></a>
                    </form>
                </div>
            </div>

        <?php
        }
        ?>

        </div>

        <!-- The Modal/Lightbox -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>

    </div>    
	<?php 
    include "templates/footer.php"; 

    if(!isAdmin()) {
        echo '<script>$("#addProduct").css("display", "none"); </script>';
        echo '<script>$(".editProduct").css("display", "none"); </script>';
    } else {
        echo '<script>$(".allShopItems").css("display", "block"); </script>';
    }
    ?>

    <script src="js/shop.js"></script>

</body>
</html>
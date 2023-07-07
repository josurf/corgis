<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "cart";

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

$cartQuery = DB::query("SELECT DISTINCT cartItem FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
foreach($cartQuery as $cartResult){
    $userCartItems = $cartResult["cartItem"];
}
if(count($cartQuery) == 0) {
    jsAlert("You have no cart items");
    jsRedirect(SITE_ROOT . "shop.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>
    <link rel="stylesheet" href="css/buttonTheme.css">
</head>

<body>
	<?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
	<div class="container-fluid main-container" style="min-height:600px;overflow-y:auto;overflow-x:hidden;">
        
        <button type="button" name="backToShop" onclick="location.href='<?php echo SITE_ROOT . 'shop.php'?>';" class="btn btn-primary" style="margin:10px;">Shop Now <i class="fa-solid fa-shop"></i></button>

        <button type="button" name="checkoutCart" onclick="location.href='<?php echo SITE_ROOT . 'checkout.php'?>';" class="btn btn-primary" style="margin:10px;">Cart Checkout <i class="fa-solid fa-arrow-right"></i></button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="padding-left:3%;">Edit Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allCartQuery = DB::query("SELECT * FROM cart WHERE fanID=%s AND cartStatus>%i", $userID, 0);
                foreach($allCartQuery as $allCartResult){
                    $allCartID = $allCartResult["cartID"];
                    $allCartItem = $allCartResult["cartItem"];
                    $allCartPrice = $allCartResult["cartPrice"];
                    $allCartQuantity = $allCartResult["cartQuantity"];
                    $allCartUser = $allCartResult["fanID"];
                    $allCartProduct = $allCartResult["productID"];
                ?>
                <tr>
                    <th scope="row"><?php echo $allCartItem; ?></th>
                    <th><?php echo $allCartQuantity; ?></th>
                    <th>$<span class="prices"><?php echo sprintf("%.2f",($allCartPrice * $allCartQuantity ) ); ?></span></th>
                    <td id="cartAction">
                        <form method="POST" action="cart-edit.php">
                            <label for="cartQuantity" class="form-label"><strong>Qty: </strong></label>
                            <input id="updateQty" style="width:30%;" type="number" name="cartQuantity" min="0" max="999">
                            <input style="display:none;" type="number" name="cartID" min="0" value="<?php echo $allCartID; ?>">
                            <input style="display:none;" type="number" name="productID" min="0" value="<?php echo $allCartProduct; ?>">
                            <button type="submit" name="editQty" class="btn btn-primary" >Edit</button>
                            <a style="margin-left:1%;position:absolute;" onclick="javascript:return confirm('Remove <?php echo $allCartItem ?> from the cart?');" href="<?php echo SITE_ROOT; ?>cart-delete.php?cartID=<?php echo $allCartID; ?>"><i class="fa-solid fa-trash fs-2" style="color: #2C3639;"></i></a>       
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th id="totalPrice" scope="col"></th>
                    <th scope="col">
                        <button type="button" name="checkoutCart" onclick="location.href='<?php echo SITE_ROOT . 'checkout.php'?>';" class="btn btn-primary">Cart Checkout <i class="fa-solid fa-arrow-right"></i></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>    
	<?php include "templates/footer.php"; ?>
    <script>
        var sum = 0.00;
        $('.prices').each(function(){
            sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            $('#totalPrice').html('<strong>Total (USD): $' + sum.toFixed(2) + '</strong>');
        });
    </script>
</body>
</html>
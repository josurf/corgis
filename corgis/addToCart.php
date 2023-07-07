<?php
include "lib/config.php"; 
include "lib/db.class.php";
include "lib/functions.php";

if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}

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

$productQuery = DB::query("SELECT * FROM product WHERE productName=%s", $_POST["productName"]);
foreach($productQuery as $productResult){
    $productID = $productResult["productID"];
    $productQuantity = $productResult["productQuantity"];
}

$cartQuantity = 0;

$cartQuery = DB::query("SELECT cartQuantity FROM cart WHERE cartItem=%s AND fanID=%i AND cartStatus>%i", $_POST["productName"], $userID, 0);
foreach($cartQuery as $cartResult){
    $cartQuantity = $cartResult["cartQuantity"];
}

if(isset($_POST["addToCart"])){

    DB::query("SELECT * FROM cart WHERE cartItem=%s AND cartStatus>%i", $_POST["productName"], 0);
    $productExist = DB::count();
    
    DB::query("SELECT * FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
    $userExist = DB::count();

    DB::query("SELECT * FROM cart WHERE cartItem=%s AND fanID=%i AND cartStatus>%i", $_POST["productName"], $userID, 0);
    $cartExist = DB::count();

    if($_POST["productQuantity"] > 0) {

        if(!$cartExist){
            DB::startTransaction();
            DB::insert('cart', [
                'cartItem' => $_POST["productName"],
                'cartPrice' => $_POST["productPrice"],
                'cartQuantity' => $_POST["productQuantity"],
                'fanID' => $userID,
                'productID' => $productID
            ]);
            $success = DB::affectedRows();
            if($success && ($_POST["productQuantity"] <= $productQuantity)){
                DB::commit();
                jsAlert("Added to cart");
                jsRedirect(SITE_ROOT . "shop.php");
            } elseif ($success && ($_POST["productQuantity"] > $productQuantity)) {
                DB::rollback();
                jsAlert("Quantity exceeded stock availability");
                jsRedirect(SITE_ROOT . "shop.php");
            } else {
                DB::rollback();
                jsAlert("Failed to update cart");
                jsRedirect(SITE_ROOT . "shop.php");
            }        
        } elseif($productExist && $userExist) {
            DB::startTransaction();
            DB::update('cart', [
                'cartItem' => $_POST["productName"],
                'cartPrice' => $_POST["productPrice"],
                'cartQuantity' => $_POST["productQuantity"] + $cartQuantity,
                'fanID' => $userID,
                'productID' => $productID
            ], 'cartItem=%s AND fanID=%i', $_POST["productName"], $userID);
            $success = DB::affectedRows();
            $updatedCartQuantity = $_POST["productQuantity"] + $cartQuantity;
            if($success && $updatedCartQuantity <= $productQuantity){
                DB::commit();
                jsAlert("Added to cart");
                jsRedirect(SITE_ROOT . "shop.php");
            } elseif($success && $updatedCartQuantity > $productQuantity){
                DB::rollback();
                jsAlert("Quantity exceeded stock availability");
                jsRedirect(SITE_ROOT . "shop.php");
            } else {
                DB::rollback();
                jsAlert("Failed to update cart");
                jsRedirect(SITE_ROOT . "shop.php");
            }
        } else {
            jsAlert("Failed to update cart");
            jsRedirect(SITE_ROOT . "shop.php");
        }
    } else {
        jsAlert("Please select an order quantity");
        jsRedirect(SITE_ROOT . "shop.php");
    }
    
}

?>
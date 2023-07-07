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

if(!isset($_POST["editQty"])){
    jsRedirect(SITE_ROOT . "cart.php");
} else {
    if(isset($_POST["cartQuantity"])){
        if($_POST["cartQuantity"] == 0) {
            DB::delete('cart', 'cartID=%i', $_POST["cartID"]);
            jsAlert("Removed from cart");
            jsRedirect(SITE_ROOT . "cart.php");
        } elseif($_POST["cartQuantity"] == "")  {
            jsAlert("Please input quantity");
            jsRedirect(SITE_ROOT . "cart.php");
        } else {
            DB::update('cart', ['cartQuantity' => $_POST["cartQuantity"]], "cartID=%i", $_POST["cartID"]);
            jsAlert("Cart updated");
            jsRedirect(SITE_ROOT . "cart.php");
        }
    } else {
        jsAlert("Please input quantity");
        jsRedirect(SITE_ROOT . "cart.php");
    }
}

?>
<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

if(!isAdmin()){
    jsRedirect(SITE_ROOT);
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

$deletee = DB::query("SELECT * FROM product WHERE productID=%i", $_GET["productID"]);
foreach($deletee as $productResult){
    $productID = $productResult["productID"];
}


if(!isAdmin()) {
    jsRedirect(SITE_ROOT . "shop.php");
} else {
    if(!isset($_GET["productID"])){
        jsRedirect(SITE_ROOT . "shop.php");
    } else {
        $allCartQuery = DB::query("SELECT cartID FROM cart WHERE productID=%i", $productID);
        $cartIDExist = DB::count();
        foreach($allCartQuery as $allCartResult){
        $allCartID = $allCartResult["cartID"];
        }
        if($cartIDExist){
            DB::delete('cart', 'cartID=%i', $allCartID);
            DB::delete('product', 'productID=%i', $productID);
            jsAlert('Product deleted successfully');
            jsRedirect(SITE_ROOT . "shop.php");
        } else {
            DB::delete('product', 'productID=%i', $productID);
            jsAlert('Product deleted successfully');
            jsRedirect(SITE_ROOT . "shop.php");
        }
    }
}

?>
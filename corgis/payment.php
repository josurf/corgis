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
    $userAdmin = $userResult["fanAdmin"];
}

$cartQuery = DB::query("SELECT DISTINCT cartItem FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
foreach($cartQuery as $cartResult){
    $userCartItems = $cartResult["cartItem"];
}
if(count($cartQuery) == 0) {
    jsRedirect(SITE_ROOT . "shop.php");
}

if(isset($_POST["goToPayment"])){
    print_r($_POST["total"]);
    DB::insert('payment', [
        'paymentCreated' => , $_POST["datetime"],
        'paymentTotal' => $_POST["total"]
    ]);
    $paymentID = DB::query("SELECT paymentID FROM payment WHERE paymentCreated=%s", $_POST["datetime"]);
    $cartID = DB::query("SELECT DISTINCT cartID FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
    foreach($cartID as $cartResult){
        $userCartID = $cartResult["cartID"];
    }
    DB::update("cart", [
        "cartStatus" => 0,
        "paymentID" => $paymentID
    ], "fanID=%i", $userID);
    jsRedirect(SITE_ROOT . "shop.php");
} else {
    jsRedirect(SITE_ROOT . "cart.php");
}
?>
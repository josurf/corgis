<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

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

if(isset($_GET["cartID"])){
    $getUserID = $_GET["cartID"];
    DB::delete('cart', 'cartID=%i', $_GET["cartID"]);
    jsRedirect(SITE_ROOT . "cart.php");
} else {
    jsRedirect(SITE_ROOT . "cart.php");
}

?>
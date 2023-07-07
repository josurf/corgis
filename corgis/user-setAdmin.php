<?php
include "lib/config.php"; 
include "lib/db.class.php";
include "lib/functions.php";

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
    $userAdmin = $userResult["fanAdmin"];
}

if(isset($_POST["query"])){
    DB::update("fan", [
    "fanAdmin" => $_POST["setAs"],
    ], "fanID=%i", $_POST["query"]);
} else {
    jsRedirect(SITE_ROOT . "admin.php");
}
?>
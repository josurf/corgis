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

if(isset($_POST["query"])){
    DB::update('fan', ['fanMessage' => filter_var($_POST["query"])], "fanEmail=%s", $userEmail);
} else {
    jsRedirect(SITE_ROOT . "contact.php");
}
?>
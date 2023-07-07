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

$deletee = DB::query("SELECT * FROM fan WHERE fanID=%s", $_GET["fanID"]);
foreach($deletee as $fanResult){
    $fanID = $fanResult["fanID"];
    $fanAdmin = $fanResult["fanAdmin"];
}


if(!isAdmin()) {
    jsRedirect(SITE_ROOT);
} else {
    if(!isset($_GET["fanID"])){
        jsRedirect(SITE_ROOT . "admin.php");
    } else {
        if($_GET["fanID"] == $userID) {
            jsAlert("You cannot delete yourself!");
            jsRedirect(SITE_ROOT . "admin.php");
        } else {
            if($fanAdmin == 1 && !isSuperAdmin() ){
                jsAlert("You cannot delete another admin!");
                jsRedirect(SITE_ROOT . "admin.php");
            } else {
                $getUserID = $_GET["fanID"];
                DB::delete('cart', 'fanID=%i', $getUserID);
                DB::delete('fan', 'fanID=%i', $getUserID);
                jsRedirect(SITE_ROOT . "admin.php");
            }
        }
    }
}

?>
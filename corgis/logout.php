<?php
include "lib/config.php"; 
include "lib/functions.php";

//If the user is logged in
if(isLoggedIn()){
    if(isset($_COOKIE["fanName"]) && isset($_COOKIE["fanEmail"]) && isset($_COOKIE["fanAdmin"])){
        //delete the cookie
        setcookie("fanName", "", time() - 3600);
        setcookie("fanEmail", "", time() - 3600);
        setcookie("fanAdmin", "", time() - 3600);
    } elseif(isset($_SESSION["fanName"]) && isset($_SESSION["fanEmail"]) && isset($_SESSION["fanAdmin"])){ //email & name session do not exists
        //Clear & Destroy all sessions
        session_unset(); // remove all session variables
        session_destroy(); // destroy the session
    }
    jsRedirect(SITE_ROOT . "login.php");
} else {
    jsRedirect(SITE_ROOT . "login.php");
}
?>
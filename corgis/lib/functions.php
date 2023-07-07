<?php

// Start the session
session_start();

function jsRedirect($url){
    echo "<script>window.location.href = '" . $url . "';</script>";
}

function jsAlert($text){
    echo "<script>alert('" . $text . "');</script>";
}

function jsConfirm($text){
    echo "<script>confirm('" . $text . "');</script>";
}

function getCurrentHour(){
    $today = date("d-M-Y h:i:s A"); //get today's date
    $currentHour = date("H", strtotime($today)); // get the current hour from today's date

    if($currentHour < 12 && $currentHour >= 5){ // before 12pm
        $day = "Morning";
    } elseif($currentHour >= 12 && $currentHour <= 17) { // from 12pm to 5pm
        $day = "Afternoon";
    } elseif($currentHour > 17 || $currentHour < 5) { // after 5pm
        $day = "Evening";
    }

    return $day;
}

function shortenWordsTo150($string){
    if(strlen($string) > 150) {
        return substr($string, 0, 150) . '...';
    } else {
        return $string;
    }
}

function filterInput($input){
    $input = trim($input); // remove unnecessary spaces, tabs, or new line
    $input = stripslashes($input); // remove backslashes "\"
    $input = htmlspecialchars($input); // remove any special html characters that might harm your code
    return $input; // final filtered input
}

function isValidEmail($email){
    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // Check if email format is valid
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function isValidURL($url){
    // Remove all illegal characters from url
    $url = filter_var($url, FILTER_SANITIZE_URL);
    // Check if url format is valid
    if(filter_var($url, FILTER_VALIDATE_URL)){
        return true;
    } else {
        return false;
    }
}

function isValidNum($num){
    if (preg_match('/^[0-9]{3}+$/', $num) || preg_match('/^[0-9]{2}+$/', $num) || preg_match('/^[0-9]{1}+$/', $num)) {
        if ($num <= 999.99) {
            return true;
        } else {
        return false;
        }
    }
}

function isLoggedIn() {
    if(isset($_COOKIE["fanName"]) && isset($_COOKIE["fanEmail"])){
        return true;
    } else {

        //Check if user is logged in
        if(isset($_SESSION["fanName"]) && isset($_SESSION["fanEmail"]) && isset($_SESSION["fanAdmin"])){ //email & name session exists
            return true;
        } else {
            return false;
        }
    }    
}

function loginCookies($name, $email, $perm) {
    // store cookies
    setcookie("fanName", $name, time() + (86400 * 999));
    setcookie("fanEmail", $email, time() + (86400 * 999));
    setcookie("fanAdmin", $perm, time() + (86400 * 999));
}

function loginSession($name, $email, $perm) {
    $_SESSION["fanName"] = $name;
    $_SESSION["fanEmail"] = $email;
    $_SESSION["fanAdmin"] = $perm;
}

function isAdmin() {
    if(isset($_SESSION["fanAdmin"])){
        if($_SESSION["fanAdmin"] > 0){
            return true;
        } else {
            return false;
        }
    } elseif(isset($_COOKIE["fanAdmin"])){
        if($_COOKIE["fanAdmin"] > 0){
            return true;
        } else {
            return false;
        }
    } else {
        jsAlert("Please log in");
        return false;
    }
}

function isSuperAdmin() {
    if(isset($_SESSION["fanAdmin"])){
        if($_SESSION["fanAdmin"] > 1){
            return true;
        } else {
            return false;
        }
    } elseif(isset($_COOKIE["fanAdmin"])){
        if($_COOKIE["fanAdmin"] > 1){
            return true;
        } else {
            return false;
        }
    } else {
        jsAlert("Please log in");
        return false;
    }
}

function sweetAlertRedirect($title, $message, $type, $redirectURL)
{
    echo "<script>$(function(){Swal.fire({
            title: '$title',
            text: '$message',
            icon: '$type',
            confirmButtonText: 'OK',
            customClass: 
            {
                confirmButton: 'btn btn-primary',
            }
        }).then(function() {
            window.location = '$redirectURL';
        })});</script>";
}

function sweetAlertTimerRedirect($title, $message, $type, $redirectURL){
    echo "<script>$(function(){Swal.fire({
        title: '$title!',
        text: '$message',
        icon: '$type',
        timer: 3000
        }).then(function() {
            window.location = '$redirectURL';
        })});</script>";
}

function sweetAlertReload($title, $message, $type)
{
    echo "<script>$(function(){Swal.fire({
            title: '$title',
            text: '$message',
            icon: '$type',
            confirmButtonText: 'OK',
            customClass: 
            {
                confirmButton: 'btn btn-primary',
            }
        }).then(function() {
            window.location = window.location.href;
        })});</script>";
}

function sweetAlert($title, $message, $type) // types: "warning", "error", "success" and "info".
{
    echo "<script>$(function(){Swal.fire({
        title: '$title',
        text: '$message',
        icon: '$type',
        confirmButtonText: 'OK',
        customClass: 
        {
            confirmButton: 'btn btn-primary',
        }
        })});</script>";
}

?>

<?php
include "lib/config.php"; 
include "lib/db.class.php";
include "lib/functions.php";

if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}

if(isset($_POST["query"])){
    $chatQuery = DB::queryFirstRow("SELECT * FROM chat WHERE chatMessage LIKE %ss", $_POST["query"]);

    if($chatQuery) {
        echo '<div class="messages botMessage">' . $chatQuery["chatReply"] . '</div>';
    } else {
        echo '<div class="messages botMessage">Woof???</div>';
    }
}
?>
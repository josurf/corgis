<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "about me";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>	
	<link rel="stylesheet" href="css/aboutMe.css">
</head>

<body> 
	<?php include "templates/nav.php"; ?>

	<!-- Profile -->
	<section id="Profile">
		<div class="row top-captions">
			<div class="col-lg-6 profile-text">
				<p>About Me</p><hr>
				<h3>I am Joseph, and I have with me a 5 year old female sable Pembroke Welsh Corgi. She is timid by nature, loves food and walks. Feel free to have a look around my site.</h3>
				<img src="images/jolly2.jpg" alt="">
			</div>
			<div class="col-lg-6">
				<img class="title-img" id="myImg" src="images/jolly.png" alt="The Majestic Corgi">
			</div>
		</div>
	</section>
	
	<!-- The Modal -->
	<div id="myModal" class="modal">
		<span class="close">&times;</span>
		<img class="modal-content" id="img01">
		<div id="caption"></div>
	</div>

	<?php include "templates/footer.php"; ?>
	<script src="js/aboutMe.js"></script>
</body>
</html>
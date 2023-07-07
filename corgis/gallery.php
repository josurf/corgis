<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "gallery";

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
	<link rel="stylesheet" href="css/gallery.css">
</head>

<body> 
	<?php include "templates/nav.php"; ?>

	<!-- Gallery -->
	<section id="Gallery">
		<div class="row top-captions">
		<div class="col-lg-6 gallery-text">
			<p id="gallery-title">Gallery</p><hr>
			<h3>Corgis appear in all shapes, sizes, positions, and they have different kinds of energy. It is absolutely exciting to be around them! Here are some images of corgis in different sizes, ages, and mood.</h3>
			<br>
			<video width="104%" height="320" autoplay muted loop>
				<source src="videos/jolly1.mp4" type="video/mp4">
			</video>
		</div>
		<div class="col-lg-6">
			<div class="slideshow-container fades">
				<div class="Containers">
					<div class="MessageInfo">1 / 7</div>
					<img src="images/gallery/corgi in snow.png" style="width:100%">
					<div class="Info">Corgi in Snow</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">2 / 7</div>
					<img src="images/gallery/corgi on floor.png" style="width:100%">
					<div class="Info">Corgi on the Floor</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">3 / 7</div>
					<img src="images/gallery/corgi puppy.png" style="width:100%">
					<div class="Info">Corgi Puppy</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">4 / 7</div>
					<img src="images/gallery/paw wave.png" style="width:100%">
					<div class="Info">Waving with Paw</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">5 / 7</div>
					<img src="images/gallery/pretty corgi.png" style="width:100%">
					<div class="Info">Pretty Corgi</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">6 / 7</div>
					<img src="images/gallery/puppy napping 2.png" style="width:100%">
					<div class="Info">Puppy Napping 2</div>
				</div>
				<div class="Containers">
					<div class="MessageInfo">7 / 7</div>
					<img src="images/gallery/puppy napping.png" style="width:100%">
					<div class="Info">Puppy Napping</div>
				</div>
				<a class="back" onclick="plusSlides(-1)">&#10094;</a>
				<a class="forward" onclick="plusSlides(1)">&#10095;</a>
			</div>
			<br>
			<div style="text-align:center">
				<span class="dots" onclick="currentSlide(1)"></span>
				<span class="dots" onclick="currentSlide(2)"></span>
				<span class="dots" onclick="currentSlide(3)"></span>
				<span class="dots" onclick="currentSlide(4)"></span>
				<span class="dots" onclick="currentSlide(5)"></span>
				<span class="dots" onclick="currentSlide(6)"></span>
				<span class="dots" onclick="currentSlide(7)"></span>
			</div> 
		</div>
		</div>
	</section>

	<?php include "templates/footer.php"; ?>
	<script src="js/gallery.js"></script>
</body>
</html>
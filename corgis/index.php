<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "home";

if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}

// DB::debugMode();

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
	<link rel="stylesheet" href="css/index.css">
</head>

<body>
	<?php include "templates/nav.php"; ?>
	<h4 class="card-title" style="padding-left:20%;"><?php echo "Good " . getCurrentHour() . ", " . $userName . "!"; ?></h4>
	<!-- captions -->
	<div class="container-fluid row top-captions">
		<div class="top--captions col-lg-6 col-md-6 col-sm-12">
			<p><i class="fa-solid fa-paw"></i> "If it smells, roll in it!"</p><br>
			<p><i class="fa-solid fa-paw"></i> "I don't always bark, but when I do it's at nothing."</p><br>
			<p><i class="fa-solid fa-paw"></i> "Go ahead. I'm all ears."</p><br>
			<p><i class="fa-solid fa-paw"></i> "I'm not short. I'm fun-sized."</p><br>
			<p><i class="fa-solid fa-paw"></i> "Life is ruff."</p>
			</div>
			<div class="imgDiv col-lg-6 col-md-6 col-sm-12">
			<img class="title-img" src="images/corgi derp.png" alt="The Majestic Corgi"><dfn>Floating </dfn>
		</div>
	</div>
	<hr>
  
	<!-- Stats -->
	<section id="corgi-stats" style="overflow-x:auto;">
		<h2>Breed Information</h2>
		<table class="table table-success">
		<thead>
			<tr>
				<th scope="col">Gender</th>
				<th scope="col">Dog Breed Group</th>
				<th scope="col" class="heightCol">Height <button class="btn btn-success" id="heightToggle">inches</button></th>
				<th scope="col" class="weightCol">Weight <button class="btn btn-success" id="weightToggle">lbs</button></th>
				<th scope="col">Life Expectancy</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row">Male</th>
				<td rowspan="2">Herding Dogs</td>
				<td rowspan="2" class="height heightCol">10 to 12 inches tall at the shoulder</td>
				<td class="weight weightCol">Up to 30 lbs</td>
				<td rowspan="2">12 to 14 years</td>
				</tr>
				<tr>
				<th scope="row">Female</th>
				<td class="weight weightCol">Up to 28 lbs</td>
			</tr>
		</tbody>  
		</table>
	</section>
	<hr>

	<!-- Traits -->
	<section id="Traits">
		<h2>Characteristics</h2>
		<div class="row flex">
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi outgoing.png" alt="outgoing corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Friendly and socially confident.">Outgoing</dfn></button>
		</div>
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi friendly.png" alt="friendly corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Kind and pleasant.">Friendly</dfn></button>
		</div>
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi playful.png" alt="playful corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Fond of games and amusement; light-hearted.">Playful</dfn></button>
		</div>
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi tenacious.png" alt="tenacious corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Tending to keep a firm hold of something; clinging or adhering closely.">Tenacious</dfn></button>
		</div>
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi bold.png" alt="bold corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Showing a willingness to take risks; confident and courageous.">Bold</dfn></button>
		</div>
		<div class="traitsdiv col-lg-4 col-md-6 col-sm-12">
			<img class="traitsimg" src="images/corgi protective.png" alt="protective corgi"><button type="button" class="btn btn-traits btn-outline-light btn-lg btn-block btn-dark"><dfn data-info="Intended to protect someone or something.">Protective</dfn></button>
		</div>
		</div>
	</section>

	<!-- The Modal/Lightbox -->
	<div id="myModal" class="modal">
		<span class="close">&times;</span>
		<img class="modal-content" id="img01">
		<div id="caption"></div>
	</div>

	<?php include "templates/footer.php"; ?>
	<script src="js/index.js"></script>
</body>
</html>
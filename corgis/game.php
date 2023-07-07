<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "game";

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
	<link rel="stylesheet" href="css/game.css">
</head>

<body>
	<?php include "templates/nav.php"; ?>

	<!-- Game - picture boxes -->
	<div id="picbox">
		<span id="boxbuttons">
			<span class="button">
				<span id="counter">0</span>
				Clicks
			</span>
			<span class="button">
				<a id="resetGame" onclick="resetGame();hideSendButton();">Reset</a>
			</span>
			<span id="viewScore" class="button" onclick="window.location='<?php echo SITE_ROOT . 'scoreBoard.php' ?>'">
				View Scoreboard
			</span>
			<span id="sendScore" style="display:none;" class="button">
				Send Score
			</span>
		</span>
		<div id="boxcard"></div>
	</div>

	<?php include "templates/footer.php"; ?>
	<script src="js/game.js"></script>
	<script>
	function hideSendButton(){
		$("#sendScore").css("display","none");
	}

	$(document).ready(function(){
		function load_data(query){
			$.ajax({
				url: "addScore.php",
				method: "POST",
				data:{
					query: query
				},
				success:function(){
					alert('Score added successfully.');
					$("#sendScore").css("display","none");
					$('#resetGame').trigger('click');
				}
			});
		}
		$('#sendScore').click(function(){
			var score = $('#counter').html().replace(/[^0-9]/g, '');
			if(score != 0){
				load_data(score);
			} else {
				load_data();
			}
		});
	});
	</script>

</body>
</html>
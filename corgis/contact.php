<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "contact";

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
</head>

<body>
	<?php include "templates/nav.php"; ?>

	<!-- Contact Me -->
	<section id="Contact">
		<div class="row top-captions">
			<div class="col-lg-4">
				<p id="contactMe">Contact Me</p><hr>
				<form id="validationForm" method="POST" action="">
					<div class="mb-3 pt-3">
						<label for="message" class="form-label">Message</label>
						<textarea id="messageText" class="form-control" rows="10" style="resize:none;" placeholder="Hi there" rows="3"></textarea>
					</div>
					<div class="col-12">
						<input type="submit" value="Submit" id="submitBtn" class="btn btn-primary" style="margin-top:30px;">
						<button type="button" name="goToMessageBoard" onclick="location.href='<?php echo SITE_ROOT . 'messageBoard.php'?>';" class="btn btn-primary" style="margin-top:30px;">View Message Board</button>
					</div>
				</form>
			</div>
			<div class="col-lg-8">
				<img class="title-img" src="images/nerd corgi.png" alt="a nerdy corgi">
			</div>
		</div>
	</section>
  
	<?php include "templates/footer.php"; ?>
	<script src="js/contact.js"></script>
	<script>
	$(document).ready(function(){
		function load_data(query){
			$.ajax({
				url: "addMessage.php",
				method: "POST",
				data:{
					query: query
				},
				success:function(data){
					alert('Message Sent!');
				}
			});
		}
		$('#submitBtn').click(function(){
			var message = $('#messageText').val();
			if(message != ""){
				load_data(message);
			} else {
				load_data();
			}
		});
	});
	</script>
</body>
</html>
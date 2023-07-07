<?php 
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "login";

if(isLoggedIn()){
    jsRedirect(SITE_ROOT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>
	<link rel="stylesheet" href="css/buttonTheme.css">
</head>



<?php

$email = $password = '';

if(isset($_POST["login"])){ // if login form is submitted
	$email = filterInput($_POST["email"]);
	$password = filterInput($_POST["password"]);
	if(!isset($_POST["remember"])){
		$remember = 0;
	} else {
		$remember = 1;
	}

	if($email == "" || $password == ""){ // check if email and password are filled
		sweetAlert('Empty Field(s)', 'Please fill up your email address and password', 'error');
		// jsAlert("Please fill up your email address and password.");
	} else {
		if(!isValidEmail($email)){ // check if email is valid
			sweetAlert('Invalid Email/Password', 'Please enter a valid email address and password', 'error');
			// jsAlert("Please enter a valid email address");
		} else {
			// check db if user exist
			$getUserQuery = DB::query("SELECT * FROM fan WHERE fanEmail=%s", $email);
			$userExist = DB::count(); // if user exist. BOTH Email & Password exist.
			foreach($getUserQuery as $getUserResult){
				$getDBUserName = $getUserResult["fanName"];
				$getDBUserPassword = $getUserResult["fanPassword"];
				$getDBUserAdmin = $getUserResult["fanAdmin"];
			}

			if($userExist){ // user exists (return 1)
				// check if password is correct
				if(password_verify($password, $getDBUserPassword)){
					//true
					if($remember){
						loginCookies($getDBUserName, $email, $getDBUserAdmin);
					} else {
						loginSession($getDBUserName, $email, $getDBUserAdmin);
					}
					sweetAlertTimerRedirect('Welcome! *woof*', 'You are logged in! You will be redirected shortly', 'success', SITE_ROOT);
				} else {
				//false: password is invalid
					sweetAlert('Invalid Email/Password', 'Please enter a valid email address and password', 'error');
					// jsAlert("Email or Password is invalid. Please try again.");
				}
			} else { // user does not exist: email is invalid
				sweetAlert('Invalid Email/Password', 'Please enter a valid email address and password', 'error');
				// jsAlert("Email or Password is invalid. Please try again.");
			}
		}
	}
}
?>

<body class="hold-transition login-page">
	<div class="login-box" style="height:680px;overflow-y:auto;">

		<!-- /.login-logo -->
		<div class="card" style="width:50%;position:fixed;top:45%;left:50%;transform: translate(-50%, -50%);">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="input-group mb-3">
					<input type="email" name="email" class="form-control" placeholder="Email*" value="<?php echo $email; ?>">
					<div class="input-group-append">
						<div class="input-group-text">
						<span class="fas fa-envelope mb-2"></span>
						</div>
					</div>
					</div>
					<div class="input-group mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password*">
					<div class="input-group-append">
						<div class="input-group-text">
						<span class="fas fa-lock mb-2"></span>
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
						<input type="checkbox" name="remember[]" id="remember" value="1">
						<label for="remember">
							Remember Me
						</label>
						</div>
					</div>
					<div class="col-4">
						<button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
					</div>
					</div>
				</form>

				<a href="<?php echo SITE_ROOT; ?>register.php" class="text-center">Register Now</a>  
			</div>
		</div>
	</div>
	
	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- fontawesome icons -->
	<script src="https://kit.fontawesome.com/5975090965.js" crossorigin="anonymous"></script>

	<!-- jquery and js -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	<script src="./js/script.js"></script>

</body>
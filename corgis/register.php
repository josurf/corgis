<?php 
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "register";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>
	<link rel="stylesheet" href="css/buttonTheme.css">
</head>

<?php

$name = $email = "";

if(isset($_POST["register"])){
	$name = filterInput($_POST["name"]);
	$email = filterInput($_POST["email"]);
	$password = filterInput($_POST["password"]);
	$cfmPassword = filterInput($_POST["cfmPassword"]);
	if(!isset($_POST["agree"])){
		$agree = 0;
	} else {
		$agree = 1;
	}

  if($name == "" || $email == "" || $password == "" || $cfmPassword == ""){
		sweetAlert('Empty Field(s)', 'Please fill up all fields', 'error');
		// jsAlert("Please fill up all fields");
	} else {
		if(!isValidEmail($email)){ // check if email is valid
			sweetAlert('Invalid Email', 'Please enter a valid email address', 'error');
			// jsAlert("Please enter a valid email address");
		} else {
			if($password != $cfmPassword){
				sweetAlert('Password Mismatch', 'Password & Confirm Password Mismatch', 'error');
				// jsAlert("Password & Confirm Password Mismatch");
			} else {
				if(!$agree){
					sweetAlert('Notice!', 'Please agree to the terms and conditions', 'warning');
					// jsAlert("Please agree to the terms and conditions");
				} else {
					$getUserQuery = DB::query("SELECT * FROM fan WHERE fanEmail=%s", $email);
					$userExist = DB::count();
					if($userExist){
						sweetAlertRedirect('Welcome back!', 'User already exists, please proceed to login', 'warning', SITE_ROOT);
						// jsAlert("User already exists, please proceed to login");
					} else {
						DB::startTransaction();
						DB::insert('fan', [
							'fanName' => $name,
							'fanEmail' => $email,
							'fanPassword' => password_hash($password, PASSWORD_DEFAULT),
						]);
						$success = DB::affectedRows();
						if($success){
							// jsAlert("Register Success");
							DB::commit();
							loginCookies($name, $email, 0);
							// jsRedirect(SITE_ROOT);
							sweetAlertTimerRedirect('Welcome! *woof*', 'You are successfully registered! You will be redirected.', 'success', SITE_ROOT);
						} else {
							sweetAlert('Error!', 'Failed to register', 'error');
							// jsAlert("Register Fail");
							DB::rollback();
						}
					}
				}
			}
		}
	}
}

?>

<body class="hold-transition register-page">
	<div class="register-box" style="height:680px;overflow-y:auto;">

	<div class="card" style="width:50%;position:fixed;top:45%;left:50%;transform:translate(-50%, -50%);">
		<div class="card-body register-card-body">
		<p class="login-box-msg">Register a new membership</p>

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="input-group mb-3">
			<input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>">
			<div class="input-group-append">
				<div class="input-group-text">
				<span class="fas fa-user mb-2"></span>
				</div>
			</div>
			</div>
			<div class="input-group mb-3">
			<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
			<div class="input-group-append">
				<div class="input-group-text">
				<span class="fas fa-envelope mb-2"></span>
				</div>
			</div>
			</div>
			<div class="input-group mb-3">
			<input type="password" name="password" class="form-control" placeholder="Password">
			<div class="input-group-append">
				<div class="input-group-text">
				<span class="fas fa-lock mb-2"></span>
				</div>
			</div>
			</div>
			<div class="input-group mb-3">
			<input type="password" name="cfmPassword" class="form-control" placeholder="Retype password">
			<div class="input-group-append">
				<div class="input-group-text">
				<span class="fas fa-lock mb-2"></span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-8">
				<div class="icheck-primary">
				<input type="checkbox" name="agree" id="agreeTerms" name="terms" value="1">
				<label for="agreeTerms">
				I agree to the <a href="#">terms.</a>
				</label>
				</div>
			</div>
			<div class="col-4">
				<button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
				<button type="button" name="cancelRegister" class="btn btn-secondary" id="cancelRegister" onclick="redirect('login.php')">Cancel</button>
			</div>
			</div>
		</form>

		<a href="<?php echo SITE_ROOT; ?>login.php" class="text-center">Already a member? Log in here!</a>
		</div>
	</div>
	</div>
	
	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- fontawesome icons -->
	<script src="https://kit.fontawesome.com/5975090965.js" crossorigin="anonymous"></script>

	<!-- jquery and js -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/user-edit.js"></script>
</body>

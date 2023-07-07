<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "add user";

if(!isAdmin()){
    jsRedirect(SITE_ROOT);
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
    <link rel="stylesheet" href="css/buttonTheme.css">
</head>

<?php

//Initialise the variable so that the variable can be used in the form input value
$newUserName = $newUserEmail = $newUserPassword = $newUserBio = "";

//addNewUser - submit button below
if(isset($_POST["addNewUser"])){
    $newUserName = filterInput($_POST["fanName"]); //filter the input and grab the name from the input field
    $newUserEmail = filterInput($_POST["fanEmail"]);
    $newUserPassword = filterInput($_POST["fanPassword"]);
    $newUserBio = filterInput($_POST["fanBio"]);

    if($newUserName != "" && $newUserEmail != "" && $newUserPassword != ""){ //check if input is not empty
        // Validate e-mail format
        if(isValidEmail($newUserEmail)){
            //Email is Valid
            DB::startTransaction();
            DB::insert('fan', [
                'fanName' => $newUserName,
                'fanEmail' => $newUserEmail,
                'fanPassword' => password_hash($newUserPassword, PASSWORD_DEFAULT),
                'fanBio' => $newUserBio
            ]);
            $success = DB::affectedRows();
            if($success){
                jsAlert("User added successfully");
                DB::commit();
                jsRedirect(SITE_ROOT . "admin.php");
            } else {
                jsAlert("Failed to add user");
                DB::rollback();
            }
        } else {
            //Email is Not Valid
            $errorMsg = "invalid-email";
            jsAlert("Invalid email.");
        }
    } else {
        //Email is Not Valid
        $errorMsg = "empty-fields";
        jsAlert("Please fill in the fields marked with an asterisk.");
    }
}
?>
<body>
    <?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
    <div class="container-fluid" style="height:600px;overflow-y:auto;">
        <div class="row">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="fanName" class="form-label">Full Name*</label>
                    <input type="text" name="fanName" class="form-control" id="fanName" placeholder="e.g. John Doe" value="<?php echo $newUserName; ?>">
                </div>
                <div class="mb-3">
                    <label for="fanEmail" class="form-label">Email*</label>
                    <input type="email" name="fanEmail" class="form-control" id="fanEmail" placeholder="e.g. john.doe@email.com" value="<?php echo $newUserEmail; ?>">
                </div>
                <div class="mb-3">
                    <label for="fanPassword" class="form-label">Password*</label>
                    <input type="password" name="fanPassword" class="form-control" id="fanPassword" placeholder="*****">
                </div>
                <div class="mb-3">
                    <label for="fanBio" class="form-label">Bio</label>
                    <textarea class="form-control" name="fanBio" id="fanBio" rows="3"><?php echo $newUserBio; ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" name="addNewUser" class="btn btn-primary">Add User</button>
                    <button type="button" name="cancelEdit" class="btn btn-secondary" id="cancelEdit" onclick="redirect('admin.php')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Index Content Ends Here -->

    <?php include "templates/footer.php"; ?>
    <script src="js/edit.js"></script>
</body>
</html>
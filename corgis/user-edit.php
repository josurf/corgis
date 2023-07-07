<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "edit user";

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
    $userAdmin = $userResult["fanAdmin"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "templates/header.php"; ?>
    <link rel="stylesheet" href="css/buttonTheme.css">	
</head>

<?php

if(!isset($_GET["fanID"]) || $_GET["fanID"] == ""){
    jsRedirect(SITE_ROOT . "admin.php");
} else {
    $getUserQuery = DB::query("SELECT * FROM fan WHERE fanID=%i", $_GET["fanID"]);
    foreach($getUserQuery as $getUserResult){
        $userDBName = $getUserResult["fanName"];
        $userDBEmail = $getUserResult["fanEmail"];
        $userDBBio = $getUserResult["fanBio"];
        $userDBAdmin = $getUserResult["fanAdmin"];
    }
    if (!isSuperAdmin() && $_GET["fanID"] != $userID && $userDBAdmin > 0){
        jsAlert("You cannot edit other Admins");
        jsRedirect(SITE_ROOT . "admin.php");
    } else {
        //addeditUser - submit button below
        if(isset($_POST["editUser"])){
            $editUserName = filterInput($_POST["fanName"]); //filter the input and grab the name from the input field
            $editUserEmail = filterInput($_POST["fanEmail"]);
            $editUserPassword = filterInput($_POST["fanPassword"]);
            $editUserBio = filterInput($_POST["fanBio"]);

            if($editUserName != "" && $editUserEmail != ""){ //check if input is not empty
                // Validate e-mail format
                if(isValidEmail($editUserEmail)){
                    //Email is Valid
                    DB::startTransaction();

                    if($editUserPassword == ""){ // Do not change password
                        DB::update('fan', [
                            'fanName' => $editUserName,
                            'fanEmail' => $editUserEmail,
                            'fanBio' => $editUserBio,
                        ], "fanID=%i", $_GET["fanID"]);
                    } else { // Change Password
                        DB::update('fan', [
                            'fanName' => $editUserName,
                            'fanEmail' => $editUserEmail,
                            'fanPassword' => password_hash($editUserPassword, PASSWORD_DEFAULT),
                            'fanBio' => $editUserBio,
                        ], "fanID=%i", $_GET["fanID"]);
                    }

                    $success = DB::affectedRows();
                    if($success){
                        jsAlert("User updated successfully");
                        DB::commit();
                        jsRedirect(SITE_ROOT . "admin.php");
                    } else {
                        jsAlert("Failed to update user");
                        DB::rollback();
                    }
                } else {
                    //Email is Not Valid
                    $errorMsg = "invalid-email";
                    jsAlert("invalid-email");
                }
            } else {
                $errorMsg = "empty-fields";
                jsAlert("empty-fields");
            }
        }
    }
}

?>
<body>
    <?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
    <div class="container-fluid" style="height:600px;overflow-y:auto;">
        <div class="row">
            <form method="POST">
                <div class="mb-3">
                    <label for="fanName" class="form-label">Name*</label>
                    <input type="text" name="fanName" class="form-control" id="fanName" placeholder="e.g. John Doe" value="<?php echo $userDBName; ?>">
                </div>
                <div class="mb-3">
                    <label for="fanEmail" class="form-label">Email*</label>
                    <input type="email" name="fanEmail" class="form-control" id="fanEmail" placeholder="e.g. john.doe@email.com" value="<?php echo $userDBEmail; ?>">
                </div>
                <div class="mb-3">
                    <label for="fanPassword" class="form-label">Password (Leave it blank to not change password)</label>
                    <input type="password" name="fanPassword" class="form-control" id="fanPassword" placeholder="*****">
                </div>
                <div class="mb-3">
                    <label for="fanBio" class="form-label">Bio</label>
                    <textarea class="form-control" name="fanBio" id="fanBio" rows="3"><?php echo $userDBBio; ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" name="editUser" class="btn btn-primary">Update User</button>
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
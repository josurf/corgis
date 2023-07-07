<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "messageboard";

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
    <link rel="stylesheet" href="css/buttonTheme.css">
</head>

<body>
	<?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
	<div class="container-fluid" style="min-height:600px;overflow-y:auto;">        
    <button type="button" name="backToContact" onclick="location.href='<?php echo SITE_ROOT . 'contact.php'?>';" class="btn btn-primary" style="margin-top:10px;">Back</button>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUserQuery = DB::query("SELECT * FROM fan WHERE fanMessage != %s", '');
                $i = 1;
                foreach($allUserQuery as $allUserResult){
                    $allUserID = $allUserResult["fanID"];
                    $allUserName = $allUserResult["fanName"];
                    $allUserMessage = $allUserResult["fanMessage"];
                ?>
                <tr>
                    <th scope="row"> <?php echo $i++ ?></th>
                    <th scope="row"> <?php echo $allUserName; ?></th>
                    <td id="messageBoard"><?php  echo $allUserMessage ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

	<?php include "templates/footer.php"; ?>
    <script src="js/contact.js"></script>
</body>
</html>
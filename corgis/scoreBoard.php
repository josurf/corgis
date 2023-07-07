<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "scoreboard";

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
    <button type="button" name="backToGame" onclick="location.href='<?php echo SITE_ROOT . 'game.php'?>';" class="btn btn-primary" style="margin-top:10px;">Back</button>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Name</th>
                    <th scope="col">Game Score (The best possible score is 18.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUserQuery = DB::query("SELECT * FROM fan WHERE fanScore > %i ORDER BY fanScore ASC", 0);
                $i = 1;
                foreach($allUserQuery as $allUserResult){
                    $allUserID = $allUserResult["fanID"];
                    $allUserName = $allUserResult["fanName"];
                    $allUserScore = $allUserResult["fanScore"];
                ?>
                <tr>
                    <th scope="row"> <?php echo $i++ ?></th>
                    <th scope="row"> <?php echo $allUserName; ?></th>
                    <td id="scoreBoard" <?php if($allUserScore < 18) {echo 'style=visibility:hidden;';} ?>>Completed in <strong><?php echo $allUserScore ?></strong> clicks.</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

	<?php include "templates/footer.php"; ?>
    <script src="js/game.js"></script>
</body>
</html>
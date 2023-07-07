<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "admin panel";

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

<body>
	<?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
	<div class="container-fluid" style="min-height:600px;overflow-y:auto;">
    <button type="button" name="addNewUser" onclick="location.href='<?php echo SITE_ROOT . 'user-add.php'?>';" class="btn btn-primary" style="margin-top:10px;">Add New User</button>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Bio</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUserQuery = DB::query("SELECT * FROM fan WHERE fanAdmin<=%i", 1);
                foreach($allUserQuery as $allUserResult){
                    $allUserID = $allUserResult["fanID"];
                    $allUserName = $allUserResult["fanName"];
                    $allUserEmail = $allUserResult["fanEmail"];
                    $allUserBio = $allUserResult["fanBio"];
                    $allUserScore = $allUserResult["fanScore"];
                    $allUserMessage = $allUserResult["fanMessage"];
                    $allUserAdmin = $allUserResult["fanAdmin"];
                ?>
                <tr>
                    <th scope="row"> <?php echo $allUserName; ?></th>
                    <td><?php echo $allUserEmail; ?></td>
                    <td><?php echo shortenWordsTo150($allUserBio); ?></td>
                    <td>
                        <input class="selectedUserAdmin" style="display:none;" type="number" name="selectedUserAdmin" value="<?php echo $allUserAdmin; ?>">
                        <input class="setAdmin" type="checkbox" name="setAdmin"  value="<?php echo $allUserID; ?>" <?php if($allUserAdmin > 0){echo "checked";}?> >
                        <label style="margin-right:10px" for="setAdmin">Admin</label>
                        <a href="<?php echo SITE_ROOT; ?>user-edit.php?fanID=<?php echo $allUserID; ?>"><i class="fa-regular fa-pen-to-square me-3 fs-4" style="color:#2C3639;"></i></a>
                        <a onclick="javascript:return confirm('Confirm delete user <?php echo $allUserName ?>?');" href="<?php echo SITE_ROOT; ?>user-delete.php?fanID=<?php echo $allUserID; ?>"><i class="fa-solid fa-trash fs-4" style="color:#2C3639;"></i></a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <input class="currentUserAdmin" style="display:none;" type="number" name="currentUserAdmin" value="<?php echo $userAdmin; ?>">
    <input class="currentUser" style="display:none;" type="number" name="currentUser" value="<?php echo $userID; ?>">

	<?php include "templates/footer.php"; ?>
    <script src="js/admin.js"></script>

    <script>
        $(document).ready(function(){
            function load_data(query,setAs){
                $.ajax({
                    url: "user-setAdmin.php",
                    method: "POST",
                    data:{
                        query: query,
                        setAs: setAs
                    },
                    success:function(done){
                        if (setAs == 1){
                            alert("Added user as Admin");
                        } else if (setAs == 0) {
                            alert("Removed user as Admin");
                        }
                    }
                });
            }
            $(".setAdmin").change(function() {
                if ($(".currentUserAdmin").val() > 1) {
                    if ($(this).is(":checked")) {
                        load_data($(this).val(),1);
                    } else {
                        load_data($(this).val(),0);
                    }
                } else {
                    if ($(this).val() == $(".currentUser").val()){
                        alert("Unable to remove self as Admin");
                        $(this).prop("checked", true);
                    } else {
                        if($(this).prev().val() > 0){
                            alert("Unable to remove others' Admin rights");
                            $(this).prop("checked", true);
                        } else {
                            if ($(this).is(":checked")) {
                                load_data($(this).val(),1);
                            } else {
                                load_data($(this).val(),0);
                            }
                        }        
                    }
                }
            });
        });
    </script>
</body>
</html>
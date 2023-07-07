<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "add product";

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
$newProductName = $newProductPrice = $newProductQuantity = $newProductImageUrl = "";

//addNewProduct - submit button below
if(isset($_POST["addNewProduct"])){
    $newProductName = filterInput($_POST["productName"]); //filter the input and grab the name from the input field
    $newProductPrice = filterInput($_POST["productPrice"]);
    $newProductQuantity = filterInput($_POST["productQuantity"]);
    $newProductImageUrl = filterInput($_POST["productImageUrl"]);

    if($newProductName != "" && $newProductPrice != "" && $newProductQuantity != "" && $newProductImageUrl != ""){ //check if input is not empty
        if(is_numeric($newProductPrice)){ //validate Price input  
            if(isValidNum($newProductQuantity)){ //validate quantity input     
                if(isValidURL($newProductImageUrl)){ //validate URL input
                    DB::startTransaction(); 
                    DB::insert('product', [
                    'productName' => $newProductName,
                    'productPrice' => $newProductPrice,
                    'productQuantity' => $newProductQuantity,
                    'productImageUrl' => $newProductImageUrl
                    ]);
                    $success = DB::affectedRows();
                    if($success){
                    jsAlert("Product added successfully");
                    DB::commit();
                    jsRedirect(SITE_ROOT . "shop.php");
                    } else {
                    jsAlert("Failed to add product");
                    DB::rollback();
                    }
                } else {
                    //URL is Not Valid
                    jsAlert("Invalid URL");
                }
            } else {
                //Price is Not Valid
                jsAlert("Invalid Qty");
            }   
        } else {
            //URL is Not Numeric
            jsAlert("Invalid Price");
        }
    } else {
        jsAlert("Please fill in the fields marked with an asterisk");
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
                    <label for="productName" class="form-label">Name of Product*</label>
                    <input type="text" name="productName" class="form-control" id="productName" value="<?php echo $newProductName; ?>">
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Price*</label>
                    <input type="number" step="0.01" name="productPrice" class="form-control" id="productPrice" value="<?php echo $newProductPrice; ?>">
                </div>
                <div class="mb-3">
                    <label for="productQuantity" class="form-label">Available Quantity (up to 999)*</label>
                    <input type="number" min="0" max="999" name="productQuantity" class="form-control" id="productQuantity" value="<?php echo $newProductQuantity; ?>">
                </div>
                <div class="mb-3">
                    <label for="productImageUrl" class="form-label">Image URL*</label>
                    <input type="url" name="productImageUrl" class="form-control" id="productImageUrl" value="<?php echo $newProductImageUrl; ?>">
                </div>
                <div class="mb-3">
                    <button type="submit" name="addNewProduct" class="btn btn-primary">Add Item to Shop</button>
                    <button type="button" name="cancelAdd" class="btn btn-secondary" id="cancelAdd" onclick="redirect('shop.php')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Index Content Ends Here -->

    <?php include "templates/footer.php"; ?>
    <script src="js/edit.js"></script>
</body>
</html>
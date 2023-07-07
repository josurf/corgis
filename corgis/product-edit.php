<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "edit product";

if(!isAdmin()){
    jsRedirect(SITE_ROOT . "shop.php");
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

if(!isset($_GET["productID"]) || $_GET["productID"] == ""){
    jsRedirect(SITE_ROOT . "shop.php");
} else {
    $getProductQuery = DB::query("SELECT * FROM product WHERE productID=%i", $_GET["productID"]);
    foreach($getProductQuery as $getProductResult){
        $productDBName = $getProductResult["productName"];
        $productDBPrice = $getProductResult["productPrice"];
        $productDBQuantity = $getProductResult["productQuantity"];
        $productDBImageUrl = $getProductResult["productImageUrl"];
    }

    //add editProduct - submit button below
    if(isset($_POST["editProduct"])){
        $editProductName = filterInput($_POST["productName"]); //filter the input and grab the name from the input field
        $editProductPrice = filterInput($_POST["productPrice"]);
        $editProductQuantity = filterInput($_POST["productQuantity"]);
        $editProductImageUrl = filterInput($_POST["productImageUrl"]);

        if($editProductName != "" && $editProductPrice != "" && $editProductQuantity != "" && $editProductImageUrl != ""){ //check if inputs are not empty
            if(is_numeric($editProductPrice)){ //validate Price input  
                if(isValidNum($editProductQuantity)){ //validate quantity input     
                    if(isValidURL($editProductImageUrl)){ //validate URL input
                        DB::startTransaction();
                        DB::update('product', [
                            'productName' => $editProductName,
                            'productPrice' => $editProductPrice,
                            'productQuantity' => $editProductQuantity,
                            'productImageUrl' => $editProductImageUrl,
                        ], "productID=%i", $_GET["productID"]);
                        $success = DB::affectedRows();
                        if($success){
                            jsAlert("Product info updated successfully");
                            DB::commit();
                            jsRedirect(SITE_ROOT . "shop.php");
                        } else {
                            jsAlert("Failed to update product info");
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
}

?>
<body>
    <?php include "templates/nav.php"; ?>

    <!-- Index Content Starts Here -->
    <div class="container-fluid" style="height:600px;overflow-y:auto;">
        <div class="row">
            <form method="POST">
                <div class="mb-3">
                    <label for="productName" class="form-label">Name of Product*</label>
                    <input type="text" name="productName" class="form-control" id="productName" value="<?php echo $productDBName; ?>">
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Price*</label>
                    <input type="number" step="0.01" name="productPrice" class="form-control" id="productPrice" value="<?php echo $productDBPrice; ?>">
                </div>
                <div class="mb-3">
                    <label for="productQuantity" class="form-label">Available Quantity (up to 999)*</label>
                    <input type="number" min="0" max="999" name="productQuantity" class="form-control" id="productQuantity" value="<?php echo $productDBQuantity; ?>">
                </div>
                <div class="mb-3">
                    <label for="productImageUrl" class="form-label">Image URL*</label>
                    <input type="url" name="productImageUrl" class="form-control" id="productImageUrl" value="<?php echo $productDBImageUrl; ?>">
                </div>
                <div class="mb-3">
                    <button type="submit" name="editProduct" class="btn btn-primary">Update Product Information</button>
                    <a onclick="javascript:return confirm('Remove <?php echo $productDBName ?> from the shop?');" href="<?php echo SITE_ROOT; ?>product-delete.php?productID=<?php echo $_GET['productID'] ?>"><button type="button" name="deleteProduct" class="btn btn-danger deleteButton" id="deleteProduct">Delete Product</button></a>
                    <button type="button" name="cancelEdit" class="btn btn-secondary" id="editProduct" onclick="redirect('shop.php')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Index Content Ends Here -->

    <?php include "templates/footer.php"; ?>
    <script src="js/edit.js"></script>
</body>
</html>
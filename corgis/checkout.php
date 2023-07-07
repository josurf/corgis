<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";

$pageName = "cart checkout";

if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}

// DB::debugMode();

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

$cartQuery = DB::query("SELECT DISTINCT cartItem FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
foreach($cartQuery as $cartResult){
    $userCartItems = $cartResult["cartItem"];
}
if(count($cartQuery) == 0) {
    jsAlert("You have no cart items");
    jsRedirect(SITE_ROOT . "shop.php");
}

$now = date('Y-m-d H:i:s');
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
	<div class="container-fluid" style="min-height:600px;overflow-y:auto;overflow-x:hidden;">

        <div class="py-5 text-center">
            <h2>CART CHECKOUT</h2>
        </div>

        <div class="row g-5">
            
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" novalidate="">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" required="">
                                <option value="">Choose...</option>
                                <option selected>Singapore</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="zip" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Postal code required.
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span>Cart Summary</span>
                <span class="badge bg-success rounded-pill">
                    <?php 
                    $cartQuery = DB::query("SELECT DISTINCT cartItem FROM cart WHERE fanID=%i AND cartStatus>%i", $userID, 0);
                    foreach($cartQuery as $cartResult){
                        $userCartItems = $cartResult["cartItem"];
                    }
                    echo count($cartQuery);
                    ?>
                </span>
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    $allCartQuery = DB::query("SELECT * FROM cart WHERE fanID=%s AND cartStatus>%i", $userID, 0);
                    foreach($allCartQuery as $allCartResult){
                        $allCartID = $allCartResult["cartID"];
                        $allCartItem = $allCartResult["cartItem"];
                        $allCartPrice = $allCartResult["cartPrice"];
                        $allCartQuantity = $allCartResult["cartQuantity"];
                        $allCartStatus = $allCartResult["cartStatus"];
                        $allCartUser = $allCartResult["fanID"];
                        $allCartProduct = $allCartResult["productID"];
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <input type="number" class="allCartID" style="display:none;" value="<?php echo $allCartID; ?>">
                            <input type="number" class="allCartProduct" style="display:none;" value="<?php echo $allCartProduct; ?>">
                            <input type="number" class="allCartQuantity" style="display:none;" value="<?php echo $allCartQuantity; ?>">
                            <h6 class="my-0"><?php echo $allCartItem; ?></h6>
                            <small class="text-muted">Qty: <?php echo $allCartQuantity; ?></small>
                        </div>
                        <span class="text-muted" style="text-align:right;">$<?php echo $allCartPrice; ?>
                            <br>
                            <span>
                                Sub-total: $<span style="font-weight:bolder;" class="cartTotal"><?php echo sprintf('%0.2f', ($allCartPrice * $allCartQuantity)) ?></span>
                            </span>
                        </span>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <span id="cartTotal"></span>
                    </li>
                </ul>
                <div id="smart-button-container" style="z-index:0;position:relative;">
                    <div style="text-align: center;">
                        <form id="paymentForm" method="POST" action="payment.php">
                            <input id="paymentDateTime" style="display:none;" name="datetime" type="text" value="<?php echo $now ?>">
                            <input id="paymentTotal" style="display:none;" name="total" type="number" step="0.01">
                            <button style="visibility:hidden;width:450px;" type="submit" id="paymentButton" name="goToPayment">
                                <div id="paypal-button-container"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <input type="text" class="dateTimeNow" style="display:none;" value="<?php echo $now; ?>">
	<?php include "templates/footer.php"; ?>
    <script src="https://www.paypal.com/sdk/js?client-id=AUelOLq6zu9cvGL9u7gMv49huMPmqRkfdT4gJEdWP0A7auOEVl8Yz0oVzVT0qDJBbaO89xybNE-QVjmb" data-sdk-integration-source="button-factory"></script>

    <script>
        var sum = 0.00;
        $('.cartTotal').each(function(){
            sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            $('#cartTotal').html('<strong>Total: $' + sum.toFixed(2) + '</strong>');
            $('#paymentTotal').val(sum.toFixed(2));
        });

        var cartID = [];
        //iterates through each input field and pushes the name to the array
        $(".allCartID").each(function() {
            var ids = $(this).val();
            cartID.push(ids);
        });

        var cartProduct = [];
        //iterates through each input field and pushes the name to the array
        $(".allCartProduct").each(function() {
            var products = $(this).val();
            cartProduct.push(products);
        });

        var cartQuantity = [];
        //iterates through each input field and pushes the name to the array
        $(".allCartQuantity").each(function() {
            var quantities = $(this).val();
            cartQuantity.push(quantities);
        });

        var dateTimeNow = $(".dateTimeNow").val()

        function initPayPalButton() {
            paypal.Buttons({
                style: {
                    shape: 'pill',
                    color: 'blue',
                    layout: 'vertical',
                    label: 'paypal'
                },

                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{"amount":{"currency_code":"USD","value":sum}}]
                    });
                },

                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        
                        // Full available details
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                        // Show a success message within this page, e.g.
                        const element = document.getElementById('paypal-button-container');
                        element.innerHTML = '';
                        element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        
                        $(function(){Swal.fire({
                            title: 'Payment Success!',
                            text: 'You will be redirected.',
                            icon: 'success',
                            timer: 5500
                        }).then(function() {
                            window.location = 'shop.php';
                        })});

                        // Or go to another URL:  actions.redirect('thank_you.html');
                        
                    });
                    
                },

                onCancel: function(data) {
                    console.log(data);
                    $(function(){Swal.fire({
                        title: 'Payment Failure',
                        text: 'Please try again!',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: 
                        {
                            confirmButton: 'btn btn-primary',
                        }
                    })});
                }

                // onError: function(err) {
                //     console.log(err);
                //     $(function(){Swal.fire({
                //         title: 'Payment Failure',
                //         text: 'Please try again!',
                //         icon: 'error',
                //         confirmButtonText: 'OK',
                //         customClass: 
                //         {
                //             confirmButton: 'btn btn-primary',
                //         }
                //     })});
                // }
            }).render('#paypal-button-container');
        }
        initPayPalButton();

        // $("#goToPayment").click(function() {
        //     function load_data(dateTimeNow,sum){
        //         $.ajax({
        //             url: "payment.php",
        //             method: "POST",
        //             data:{
        //                 datetime: dateTimeNow,
        //                 total: sum
        //             },
        //             success:function(done){
        //             }
        //         });
        //     }
        //     // $("#paypal-button-container").click(function() {
        //     //     load_data(dateTimeNow,sum);
        //     // });
        // });

    </script>
</body>
</html>
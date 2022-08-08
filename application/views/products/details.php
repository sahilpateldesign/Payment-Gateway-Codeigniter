<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Payment Details</title>
<meta charset="utf-8">

<!-- Stylesheet file -->
<link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css'); ?>">
	
<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v2/"></script>
	
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script src="<?php echo base_url('public/assets/js/jquery.min.js'); ?>"></script>
	
</head>
<body>
<div class="container">
	<h1>Purchase - Payment Gateway</h1>
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Charge <?php echo '$'.$product['price']; ?> with Stripe</h3>
			
			<!-- Product Info -->
			<p><b>Item Name:</b> <?php echo $product['name']; ?></p>
			<p><b>Price:</b> <?php echo '$'.$product['price'].' '.$product['currency']; ?></p>
		</div>
		<div class="panel-body">
			<!-- Display errors returned by createToken -->
			<div class="card-errors"></div>
			
			<!-- Payment form -->
			<form action="" method="POST" id="paymentFrm">
				<div class="form-group">
					<label>NAME</label>
					<input type="text" name="name" id="name" placeholder="Enter name" required="" autofocus="">
				</div>
				<div class="form-group">
					<label>EMAIL</label>
					<input type="email" name="email" id="email" placeholder="Enter email" required="">
				</div>
				<div class="form-group">
					<label>CARD NUMBER</label>
					<input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" autocomplete="off" required="" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
				</div>
				<div class="row">
					<div class="left">
						<div class="form-group">
							<label>EXPIRY DATE</label>
							<div class="col-1">
								<input type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" required="" maxlength='2' onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
							</div>
							<div class="col-2">
								<input type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" required="" maxlength='4' onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
							</div>
						</div>
					</div>
					<div class="right">
						<div class="form-group">
							<label>CVC CODE</label>
							<input type="text" name="card_cvc" id="card_cvc" placeholder="CVC" autocomplete="off" required="" maxlength='3' onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
			</form>
		</div>
	</div>
</div>
<script>
// Set your publishable key
Stripe.setPublishableKey('<?php echo $this->config->item('stripe_publishable_key'); ?>');

// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
	if (response.error) {
		// Enable the submit button
		$('#payBtn').removeAttr("disabled");
		// Display the errors on the form
		$(".card-errors").html('<p>'+response.error.message+'</p>');
	} else {
		var form$ = $("#paymentFrm");
		// Get token id
		var token = response.id;
		// Insert the token into the form
		form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
		// Submit form to the server
		form$.get(0).submit();
	}
}

$(document).ready(function() {
	// On form submit
	$("#paymentFrm").submit(function() {
		// Disable the submit button to prevent repeated clicks
		$('#payBtn').attr("disabled", "disabled");
		
		// Create single-use token to charge the user
		Stripe.createToken({
			number: $('#card_number').val(),
			exp_month: $('#card_exp_month').val(),
			exp_year: $('#card_exp_year').val(),
			cvc: $('#card_cvc').val()
		}, stripeResponseHandler);
		
		// Submit from callback
		return false;
	});
});
</script>
</body>
</html>
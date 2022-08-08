
<div class="container">
	<div class="status">
		<?php if(!empty($order)){ ?>
			
			<?php if($order['payment_status'] == 'succeeded'){ ?>
			<h1 class="success">Your Payment has been Successful!</h1>
			<?php }else{ ?>
			<h1 class="error">The transaction was successful! But your payment has been failed!</h1>
			<?php } ?>
			<button class="btn btn-sm btn-dark" style="float:right !important; width:6%;" onclick="window.print()">Print</button>
			<h4>Payment Information</h4>
			<div class="status_div">
				<p><img src="<?php echo base_url() . $order['product_images']; ?>" style="height:333px; width:100%;"></p>
				<p><b>Reference Number:</b> <?php echo $order['id']; ?></p>
				<p><b>Transaction ID:</b> <?php echo $order['txn_id']; ?></p>
				<p><b>Paid Amount:</b> <?php echo $order['paid_amount'].' '.$order['paid_amount_currency']; ?></p>
				<p><b>Payment Status:</b> <?php echo $order['payment_status']; ?></p>
				
				<h4 class="mt-4">Product Information</h4>
				<hr class="mt-1 bg-primary">
				<p><b>Books Name:</b> <?php echo $order['product_name']; ?></p>
				<p><b>Price:</b> <?php echo $order['product_price'].' '.$order['product_price_currency']; ?></p>
			</div>
		<?php }else{ ?>
			<h1 class="error">The transaction has failed</h1>
		<?php } ?>
	</div>
	<a href="<?php echo base_url('products/'); ?>" class="btn-link">Back to Product Page</a>
</div>

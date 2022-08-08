
<div class="container">
	<h1>Products - Stripe Payment Gateway Integration</h1>
	<!-- List all products -->
	<?php if(!empty($products)){ foreach($products as $row){ ?>
    <div class="pro-box">
		<div class="product_boxx">
			<div class="bookimg">
				<img src="<?php echo base_url() . $row['images'] ?>" class="card-img" alt="<?= $row['name'] . ' Image' ?>">
			</div>
			<div class="info">
				<h4><?php echo $row['name']; ?></h4>
				<h5>Price: <?php echo '$'.$row['price'].' '.$row['currency']; ?></h5>
			</div>
			<div class="action">
				<a href="<?php echo base_url('products/purchase/'.$row['id']); ?>" class="w-100">Buy Now</a>
			</div>
		</div>
    </div>
	<?php } }else{ ?>
    <p>Product(s) not found...</p>
	<?php } ?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if(!empty($title)){
            echo $title;
        }
        ?>
    </title>
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Stripe JavaScript library -->
    <script src="https://js.stripe.com/v2/"></script>
	
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script src="<?php echo base_url('public/assets/js/jquery.min.js'); ?>"></script>
</head>
<body>

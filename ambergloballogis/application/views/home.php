<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Amber Global Logistics</title>
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700:latin">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="courier-detail">
    <div class="container">
        <img src="https://www.ambergloballogistics.com/assets/img/amber/amber_logo.png" data-courier-image="12">
        <h1>Tracking Number Search</h1>
        <div class="detail-items">
            <li><span class="icon"><i class="fa fa-phone"></i></span> <a href="https://api.whatsapp.com/send?phone=60138810307">+60138810307</a></li>
            <li><span class="icon"><i class="fa fa-envelope"></i></span> <a href="#"> track@ambergloballogistics.com </a></li>
            <li><span class="icon"><i class="fa fa-globe"></i></span> <a href="https://www.ambergloballogistics.com" target="_blank" rel="nofollow">https://www.ambergloballogistics.com</a></li>
        </div>
        <form id="tracking-form" class="search-here">
            <input type="text" id="tracking_number" name="tracking_number" class="form-control" placeholder="Enter tracking number here" autocomplete="off" required>
            <button type="submit" id="btn-search"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>
<footer>
    <div class="container">
        <div class="pull-right d-none d-lg-block">
            <img src="https://www.ambergloballogistics.com/assets/img/amber/trackmeuplogo.png">
        </div>
        <p>System Developed by <a href="https://techswk.com" target="_blank">Tech SWK </a></a>. All rights reserved.</p>
    </div>
</footer>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
<script>
	$(document).on("click", "#btn-search", function(e){
		e.preventDefault();
		var tracking_number = $('#tracking_number').val();
		if(tracking_number == ''){
            alert('Please input tracking number!');
			$('#tracking_number').focus();
			return;
		}
		location.href="tracking?tracking_number="+tracking_number;
	});
</script>
</body>
</html>
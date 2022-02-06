<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>CTSI</title>
    <link rel="stylesheet" href="https://ambergloballogistics.com/assets/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700:latin">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="courier-detail">
    <div class="container">
        <a href="https://ambergloballogistics.com/ctsi"><img src="https://ambergloballogistics.com/assets/img/amber/ctsilogo.jpeg" data-courier-image="12"></a>
        <h1>Tracking Number Search</h1>
        <div class="detail-items">
            <li><span class="icon"><i class="fa fa-phone"></i></span> +603-87871303</li>
            <li><span class="icon"><i class="fa fa-envelope"></i></span> <a href="#"> enquiry@ctsi.my </a></li>
            <li><span class="icon"><i class="fa fa-globe"></i></span> <a href="http://www.ctsi.my" target="_blank" rel="nofollow">http://www.ctsi.my</a></li>
        </div>
        <form id="tracking-form" class="search-here">
            <input type="text" id="tracking_number" name="tracking_number" class="form-control" placeholder="Enter tracking number here" autocomplete="off" required>
            <button type="submit" id="btn-search"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <br><br><br>
	<p><b>CTSI Logistics (M) Sdn Bhd</b></p>
    <p>Lot D12, Block D, MAS Freight Forwarders Complex,
    <br>Free Commercial Zone, 64000 KLIA,
    <br>Selangor, Malaysia.
    <br>
    <br>Tel: +603-87871303
    <br>Fax: +603-87871304</p>
</div>
<footer>
    <div class="container">
        <div class="pull-right d-none d-lg-block">
            <img src="https://ambergloballogistics.com/assets/img/amber/trackmeuplogo.png">
        </div>
        <p>System powered by <a href="#">TRACKMEUP v1.2</a>. All rights reserved.</p>
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
		location.href="trackingctsi?tracking_number="+tracking_number;
	});
</script>
</body>
</html>
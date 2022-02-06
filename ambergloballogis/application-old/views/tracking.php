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
    <style>
        .color-1 {
            background-color: green;
        }
        .color-default{
            background-color: #90949C ;
        }
        .tracking-item .tracking-icon {
            line-height: 2.6rem;
            position: absolute;
            left: -0.45rem;
            width: 1rem;
            height: 1rem;
            text-align: center;
            border-radius: 50%;
            font-size: 1.1rem;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="courier-detail">
    <section class="courier-min-detail">
        <div class="container">
            <div class="row">
                <img style="margin-left: 40%;margin-bottom: 16px;" src="http://track.ambergloballogistics.com/assets/images/amber_logo.png" data-courier-image="12">
                
            </div>
            <div class="row">

                <div class="col-sm-8 col-md-8 col-lg-8">
                    <form id="tracking-form" class="search-here" action="" method="get">
                        <input type="text" id="tracking_number" name="tracking_number" class="form-control" value="<?php echo $tracking_number; ?>" placeholder="Enter tracking number here" autocomplete="off" required>
                        <button type="submit" id="btn-search"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="hidden-sm-down col-md-4 col-lg-4">
                    <div class="detail-items">
                        <li><span class="icon"><i class="fa fa-phone"></i></span> <a
                                    href="https://api.whatsapp.com/send?phone=60138810307"
                                    data-anchor-protocol="tel">+60138810307</a>
                        </li>
                        <li><span class="icon"><i class="fa fa-envelope"></i></span> <a
                                    href="mailto:track@ambergloballogistics.com"
                                    data-anchor-protocol="mailto">track@ambergloballogistics.com</a>
                        </li>
                    </div>
                </div>
            </div>
    </section>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div id="tracking-pre"></div>
                <div id="tracking">
                    <?php if(count($trackings) > 0){ ?>
                    <div class="text-center tracking-status-<?php if($trackings[0]['status_name'] != 'Delivered'){echo 'default'; }else{ echo '1';} ?>">
                        <p class="tracking-status text-tight" style='color:black;'><?php echo $trackings[0]['status_name']; ?></p>
                    </div>

                    <div class="tracking-list" style="background-color: white">
                        <?php foreach($trackings as $tracking){ ?>
                        <div class="tracking-item">
                            <div class="tracking-icon color-<?php if($tracking['status_name'] != 'Delivered'){echo 'default'; }else{ echo '1';} ?>">
                            </div>
                            <div class="tracking-date"><?php echo $tracking['date_stamp']; ?></div>
                            <div class="tracking-content" style="text-align: left; font-size: 18px;">
                                <?php echo $tracking['location']; ?>
                                <span><?php echo $tracking['status_name']; ?></span>
                                <span><?php echo $tracking['remark']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                    <div class="text-center tracking-status-default">
                        <p class="tracking-status text-tight" style='color:black;'>No Records found</p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="pull-right d-none d-lg-block">
            <img src="assets/img/amber/trackmeuplogo.png">
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
		location.href="tracking?tracking_number="+tracking_number;
	});
</script>
</body>
</html>
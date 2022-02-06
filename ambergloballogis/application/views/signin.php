<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title>Sign In / Amber Logistic</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/open-sans/style.min.css"> <!-- common font  styles  -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/universe-admin/style.css"> <!-- universeadmin icon font styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/mdi/css/materialdesignicons.min.css"> <!-- meterialdesignicons -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/iconfont/style.css"> <!-- DEPRECATED iconmonstr -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/flatpickr/flatpickr.min.css"> <!-- original flatpickr plugin (datepicker) styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/simplebar/simplebar.css"> <!-- original simplebar plugin (scrollbar) styles  -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/tagify/tagify.css"> <!-- styles for tags -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/tippyjs/tippy.css"> <!-- original tippy plugin (tooltip) styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2/css/select2.min.css"> <!-- original select2 plugin styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"> <!-- original bootstrap styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.min.css" id="stylesheet"> <!-- universeadmin styles -->

	<script src="<?php echo base_url(); ?>assets/js/ie.assign.fix.min.js"></script>
</head>

<body class="p-front">
	<div class="navbar navbar-light navbar-expand-lg p-front__navbar">
		<!-- is-dark -->
		<a class="navbar-brand" href="/"><img src="<?php echo base_url(); ?>assets/img/amber/amber_logo.png" style="width: 50%;" alt="" /></a>
		<a class="navbar-brand-sm" href="/"><img src="<?php echo base_url(); ?>assets/img/amber/amber_logo.png" style="width: 30%;" alt="" /></a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse">
			<span class="ua-icon-navbar-open navbar-toggler__open"></span>
			<span class="ua-icon-alert-close navbar-toggler__close"></span>
		</button>
	</div>
	<div class="p-front__content">
		<div class="p-signin-a">
			<form class="p-signin-a__form">
				<h4 class="p-signin-a__form-heading">Sign In</h4>
				<p class="text-center">Do you have an account? <span class="text-primary"><a href="<?php echo site_url('register'); ?>">Create One</a> </span></p>
				<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
					<span class="alert-icon ua-icon-info"></span>
					<strong id="alert-message"></strong>
					<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
				</div>
				<div class="form-group">
					<input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username">
				</div>
				<div class="form-group">
					<input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password">
				</div>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="ch1" value="1">
						<label class="custom-control-label" for="ch1">Remember Me</label>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-info btn-lg btn-block btn-rounded" type="submit" id="btn-signin">Sign In</button>
				</div>
			</form>
		</div>
	</div>
	<footer class="p-front__footer">
		<span>2020 &copy; Amber Logistic</span>
	</footer>

	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/select2/js/select2.full.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/simplebar/simplebar.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/text-avatar/jquery.textavatar.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/tippyjs/tippy.all.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/flatpickr/flatpickr.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/wnumb/wNumb.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>

	<script src="<?php echo base_url(); ?>assets/customjs/signin.js"></script>

</body>

</html>
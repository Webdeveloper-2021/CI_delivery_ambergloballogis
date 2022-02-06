<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title>Sign Up / Amber Logistic</title>

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

	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Welcome</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body text-center">
					Successfully completed!
				</div>
				<div class="modal-footer justify-content-end">
					<button type="button" class="btn btn-outline-info btn-rounded" id="goToSignin">Sign In</button>
				</div>
			</div>
		</div>
	</div>

	<div class="p-front__content">
		<div class="form-group container w-50 px-5 pt-3 bg-white mt-3">
			<h4 class="p-signin-a__form-heading">Sign Up</h4>

			<form id="form-customer">
				<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
					<span class="alert-icon ua-icon-info"></span>
					<strong id="alert-message"></strong>
					<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Enter user's name">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">Email address</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" pattern=".{6,}" class="form-control" name="password" id="password" placeholder="Password" required title="6 characters minimum">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Enter user's name">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="contact_number">Contact number</label>
							<input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter user's contact number">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="company">Company Name</label>
							<input type="text" class="form-control" name="company" id="company" placeholder="Enter company's name">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="country">Country</label>
							<input type="text" class="form-control" name="country" id="country" placeholder="country">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="state">State</label>
							<input type="text" class="form-control" name="state" id="state" placeholder="state">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="city">City</label>
							<input type="text" class="form-control" name="city" id="city" placeholder="city">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="post_code">Post code</label>
							<input type="text" class="form-control" name="post_code" id="post_code" placeholder="postal code">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" class="form-control" name="address" id="address" placeholder="address">
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer modal-footer--center">
				<input type="hidden" id="edit_id" value="">
				<input type="hidden" id="edit_index" value="">
				<button type="button " class="btn btn-outline-info btn-rounded" data-dismiss="modal" id="goToLogin"> Sign In</button>
				<button type="button" class="btn btn-info btn-rounded" id="btn-save">Register</button>
				<!--<button class="btn btn-info" type="button" id="btn-update">Update</button>-->
			</div>
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

	<script src="<?php echo base_url(); ?>assets/customjs/register.js"></script>

</body>

</html>
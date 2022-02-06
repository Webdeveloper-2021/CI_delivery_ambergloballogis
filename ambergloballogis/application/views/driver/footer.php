	</div>

	<script src="<?php echo base_url(); ?>assets/vendor/echarts/echarts.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/simplebar/simplebar.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/text-avatar/jquery.textavatar.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/tippyjs/tippy.all.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/flatpickr/flatpickr.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/wnumb/wNumb.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/preview/datepicker.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm/jquery-confirm.min.js"></script>
	
	<?php if($page_title == 'dashboard') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/dashboard_driver.js"></script>
	<?php }elseif($page_title == 'trackingnumber_view') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/trackingnumber_view_customer.js"></script>
	<?php }elseif($page_title == 'profile') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/profile_driver.js"></script>
	<?php } ?>
</body>
</html>
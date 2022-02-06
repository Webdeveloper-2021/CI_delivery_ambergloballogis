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
	<?php if($page_title == 'trackingnumbers') { ?>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/moment.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/datetime-moment.js"></script>
	<?php } ?>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm/jquery-confirm.min.js"></script>
	
	<?php if($page_title == 'customers') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/customers.js"></script>
	<?php }elseif($page_title == 'stations') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/stations.js"></script>
	<?php }elseif($page_title == 'prefixset') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/prefixset.js"></script>
	<?php }elseif($page_title == 'drivers') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/drivers.js"></script>
	<?php }elseif($page_title == 'deliveryrequest') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/deliveryrequest.js"></script>
	<?php }elseif($page_title == 'trackingnumbers') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/trackingnumbers.js"></script>
	<?php }elseif($page_title == 'trackingnumber_view') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/trackingnumber_view.js"></script>
	<?php }elseif($page_title == 'trackingstatus') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/trackingstatus.js"></script>
	<?php }elseif($page_title == 'precedence') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/precedence.js"></script>
	<?php }elseif($page_title == 'uploadexcel') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/uploadexcel.js"></script>
	<?php }elseif($page_title == 'profile') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/profile.js"></script>
	<?php }elseif($page_title == 'dashboard') { ?>
		<script src="<?php echo base_url(); ?>assets/vendor/jodit/jodit.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/vendor/momentjs/moment-with-locales.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/date-range-picker/daterangepicker.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/preview/date-range-picker.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/customjs/dashboard.js"></script>
	<?php } ?>
	
	

<script type='text/javascript'>
$(document).ready(function() {
	
	var path = '<?php echo base_url();?>';
	
	createPagination(0);
	$('#pagination').on('click','a',function(e){
		e.preventDefault(); 
		var pageNum = $(this).attr('data-ci-pagination-page');
		createPagination(pageNum);
	});
	function createPagination(pageNum){
		$.ajax({
//			url: '<?=base_url()?>index.php/Employee/loadData/'+pageNum,
			url: path + 'index.php/admin/Trackingnumbers/loadData/'+pageNum,

			type: 'get',
			dataType: 'json',
			success: function(responseData){
				$('#pagination').html(responseData.pagination);
				
				
				
				
				paginationData(responseData.empData);
			}
		});
	}
	function paginationData(data) {
		$('#employeeList tbody').empty();
		for(emp in data){
			var empRow = "<tr>";
			empRow += "<td>" + data[emp].id + "</td>";
			empRow += "<td>" + data[emp].tracking_number + "</td>";
			empRow += "<td>" + data[emp].sender_station + "</td>";
			empRow += "<td>" + data[emp].receiver_station + "</td>";
			empRow += "<td>" + data[emp].status_name + "</td>";
			empRow += "<td>" + data[emp].date_stamp + "</td>";
			empRow += "<td>" + data[emp].remark + "</td>";
			empRow += "<td>" + data[emp].image_path + "</td>";
						
			if ((data[emp].image_path != null) && (data[emp].image_path != '')){
				empRow += '<td><button class="btn btn-info btn-view-image" type="button">View Image</button></td>';
			} else {
				empRow += '<td><button class="btn btn-danger" type="button">No Image</button></td>';
			}
			
			
			empRow += '<td>';
			empRow += '<button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>';
			empRow += '<button class="btn btn-warning mb-2 mr-1 btn-pdf" type="button" title="A4 format"><span class="btn-icon ua-icon-pages"></button>';
				empRow += '<button class="btn btn-success mb-2 mr-1 btn-pdf1" type="button" title="sticker format"><span class="btn-icon ua-icon-pages"></button>';
				empRow += '<button class="btn btn-purple mb-2 mr-1 btn-edit" type="button"><span class="btn-icon ua-icon-pencil"></button>';
				empRow += '<button class="btn btn-danger mb-2 mr-1 btn-remove" type="button"><span class="btn-icon ua-icon-trash"></button>';
			empRow += '</td>';
			
			empRow += "</tr>";
			$('#employeeList tbody').append(empRow);					
		}
	}
});
</script>
</body>
</html>
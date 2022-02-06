	</div>
	
<style>
#mdl-pickup {
/*	-webkit-transform: translate3d(15%, 0, 0);
	transform: translate3d(15%, 0, 0);*/
}
@media screen and (min-width: 768px) {
#mdl-pickup {
	-webkit-transform: translate3d(0, 0, 0);
	transform: translate3d(0, 0, 0);
}

</style>	
	
<div id="mdl-pickup" class="modal fade custom-modal-tabs" style="color: grey;">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header has-border">
				<h5 class="modal-title" id="pick_title">Pick up form</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body"  style="padding-top: 2rem; font-size:1.2rem;">				
							<div class="row">
								<div class="col-xs-6 col-md-6">Name</div>
								<div class="col-xs-6 col-md-6" id="pick_name"></div>
							</div>
							<div class="row" style="padding-top:1rem;">
								<div class="col-xs-6 col-md-6">Email Address</div>
								<div class="col-xs-6 col-md-6" id="pick_email"></div>
							</div>
							<div class="row" style="padding-top:1rem;">
								<div class="col-xs-6 col-md-6">Contact Number</div>
								<div class="col-xs-6 col-md-6" id="pick_contact_num"></div>
							</div>
							
							<div class="row" style="padding-top:1.5rem;">
								<div class="col-xs-12 col-md-6">
									<div class="row">
										<div class="col-12"><h3>Pick-Up Address</h3></div>
										<div class="col-12">
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6" style="letter-spacing: -0.05em">Address Type</div>
												<div class="col-xs-6 col-md-6" id="pick_up_address_type"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6" style="letter-spacing: -0.05em">Office/Residential</div>
												<div class="col-xs-6 col-md-6" id="pick_up_office"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Address</div>
												<div class="col-xs-6 col-md-6" id="pick_up_address"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Postcode</div>
												<div class="col-xs-6 col-md-6" id="pick_up_post"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">City</div>
												<div class="col-xs-6 col-md-6" id="pick_up_city"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">State</div>
												<div class="col-xs-6 col-md-6" id="pick_up_state"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Country</div>
												<div class="col-xs-6 col-md-6" id="pick_up_country"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-md-6">
									<div class="row">
										<div class="col-12"><h3>Delivery Address</h3></div>
										<div class="col-12">
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6" style="letter-spacing: -0.1em">Receiver Name</div>
												<div class="col-xs-6 col-md-6" id="pick_rec_name"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<!--<div class="col-xs-6 col-md-6">Receiver Company</div>-->
												<div class="col-xs-6 col-md-6">Receiver Co.</div>
												<div class="col-xs-6 col-md-6" id="pick_rec_company"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Address</div>
												<div class="col-xs-6 col-md-6" id="pick_deliver_address"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Postcode</div>
												<div class="col-xs-6 col-md-6" id="pick_deliver_post"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">City</div>
												<div class="col-xs-6 col-md-6" id="pick_deliver_city"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">State</div>
												<div class="col-xs-6 col-md-6" id="pick_deliver_state"></div>
											</div>
											<div class="row col-12" style="padding-top:1rem;">
												<div class="col-xs-6 col-md-6">Country</div>
												<div class="col-xs-6 col-md-6" id="pick_deliver_country"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row" style="padding-top:1rem;">
								<div class="col-xs-12 col-lg-12">
									<div class="row" style="padding-top:1rem;">
										<div class="col-xs-6 col-md-4">Parcel Info</div>
										<div class="col-xs-6 col-md-8" id="pick_parcel"></div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="row" style="padding-top:1rem;">
										<div class="col-xs-6 col-md-4">Content Description</div>
										<div class="col-xs-6 col-md-8" id="pick_content"></div>
									</div>
								</div>
							</div>
						
			<div class="modal-footer modal-footer--center">
				<!--<button type="button" class="btn btn-outline-info" data-dismiss="modal">Close</button>				-->
			</div>
		</div>
		</div>
	</div>
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
	
	<?php if($page_title == 'trackingnumbers' || $page_title == 'add_trackingnumber' || $page_title == 'getTrackingnumbers_pickup') { ?>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/moment.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/datetime-moment.js"></script>
	<?php } ?>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm/jquery-confirm.min.js"></script>
	
	<?php if($page_title == 'customers' || $page_title == 'add_customer') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/customers.js"></script>
	<?php }elseif($page_title == 'stations') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/stations.js"></script>
	<?php }elseif($page_title == 'prefixset') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/prefixset.js"></script>
	<?php }elseif($page_title == 'drivers') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/drivers.js"></script>
	<?php }elseif($page_title == 'deliveryrequest') { ?>
		<script src="<?php echo base_url(); ?>assets/customjs/deliveryrequest.js"></script>
	<?php }elseif($page_title == 'trackingnumbers' || $page_title == 'add_trackingnumber' || $page_title == 'getTrackingnumbers_pickup') { ?>
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
	
	<?php if($page_title == 'notifications') { ?>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/moment.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendor/datatables/datetime-moment.js"></script>
		<script src="<?php echo base_url(); ?>assets/customjs/notifications.js"></script>
	<?php } ?>
	
	<script src="<?php echo base_url(); ?>assets/js/notify.js"></script>
		
	 <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	 
	  <script>
		var cur_userid 		= '<?php echo $this->session->userdata['amber_in']['userid'];?>';
		var cur_level 		= '<?php echo $this->session->userdata['amber_in']['level'];?>';	
		
		var base_url = "<?php echo base_url(); ?>";
		
	    // Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('0c8237974ab4bd669688', {
	      cluster: 'eu'
	    });

	    var channel = pusher.subscribe('my-app-development');
	    channel.bind('my-event', function(data) {
//	    	alert(JSON.stringify(data));
//	      	alert(data.message);
			
			var dest_userid		= data.dest_userid;
			var dest_userlevel 	= data.dest_userlevel;
			
			
			if ((dest_userid != 'admin') && (dest_userlevel != 0)) return;
			//if ((dest_userid != cur_userid) && (dest_userlevel != cur_level)) return;

			var msg = data.message;
	      	var n = msg.indexOf("<br/>");
	      	var title = msg.slice(0,n);	      	
	      	n += 5;
	    
	      	$("#pick_title").html(title);
	      	
			var msg = data.message;
			var tracking_data 	= data.tracking_data;
			//var status_data		= data.status_data;
			var sender_data		= data.sender_data;
			var receiver_data	= data.receiver_data;
			
	/*		$('#pick_name').html(sender_data['name']);
			$('#pick_email').html(sender_data['email']);
			$('#pick_contact_num').html(sender_data['contact_number']);
			
			$('#pick_up_address_type').html(sender_data['address']);
			$('#pick_up_office').html('');
			$('#pick_up_address').html(sender_data['address']);
			$('#pick_up_post').html(sender_data['post_code']);
			$('#pick_up_city').html(sender_data['city']);
			$('#pick_up_state').html(sender_data['state']);
			$('#pick_up_country').html(sender_data['country']);
			
			$('#pick_rec_name').html(receiver_data['name']);
			$('#pick_rec_company').html(receiver_data['company_name']);
			$('#pick_deliver_address').html(receiver_data['address']);
			$('#pick_deliver_post').html(receiver_data['post_code']);
			$('#pick_deliver_city').html(receiver_data['city']);
			$('#pick_deliver_state').html(receiver_data['state']);
			$('#pick_deliver_country').html(receiver_data['country']);
			
			$('#pick_parcel').html(tracking_data['parcel_type']);
			$('#pick_content').html(tracking_data['content_description']);*/
			
			
			/*$('#mdl-pickup').modal('show');

			setTimeout(function() {
			    $('#mdl-pickup').modal('hide');
			}, 3000);*/
			$.notify(title, "info");	

	    	var cur_count = $('#notice_count').html();
	    	
	    	var nCnt = (cur_count == '') ? 0 : parseInt(cur_count);
	    	nCnt += 1;
	    	$('#notice_count').html(nCnt);
	    });
	    
	  </script>
	
	
	
	<script>
		$(document).ready(function() {

		/*$.notify("Access granted", "success");	
		$.notify(title, "info");	*/

//			 load_data();

		 function load_data(query)
		 {
		  $.ajax({
		   url:"<?php echo base_url(); ?>admin/Trackingnumbers/get_search",
		   async:false,
		   type:"POST",
		   dataType: "json",
		   data:{query:query},
		   success:function(data){
				var data_content = '';
				data_content += '<div class="m-datatable">';
				data_content += 	'<table id="datatable" class="table table-striped">'
				data_content += 		'<thead>';
				data_content += 			'<tr>';
				data_content += 				'<th>#</th>';
				data_content += 				'<th>Tracking Number</th>';
				data_content += 				'<th>Sender Station</th>';
				data_content += 				'<th>Receiver Station</th>';
				data_content += 				'<th>Status</th>';
				data_content += 				'<th>Date</th>';
				data_content += 				'<th>Remark</th>';
				data_content += 				'<th>Image Path</th>';
				data_content += 				'<th>Image</th>';
				data_content += 				'<th>Action</th>';
				data_content += 			'</tr>';
				data_content += 		'</thead>';
				data_content += 		'<tbody>';
						
				var rows = data.arr_data;
				var nLen = rows.length;
				for(var i = 0; i < nLen; i++)
				{
					var row = rows[i];
//					data_content += '<tr><td>' + (i+1) + '</td>';
					data_content += '<tr><td>' + row['id'] + '</td>';
					data_content += '<td>' + row['tracking_number'] + '</td>';
					data_content += '<td>' + row['sender_station'] + '</td>';
					data_content += '<td>' + row['receiver_station'] + '</td>';
					data_content += '<td>' + row['status_name'] + '</td>';

					var date = new Date(row['date_stamp'] * 1000);
//					var months_arr = ['January','February','March','April','May','June','July','August','September','October','November','December'];
					var months_arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
//					var strDate = date.getDate()+"/"+(date.getMonth()+1)+ "/"+date.getFullYear();
					var strDate = date.getDate()+" "+ months_arr[date.getMonth()]+ " "+date.getFullYear();
					data_content += '<td>' + strDate + '</td>';
					
					data_content += '<td class="remark-content">' + row['remark'] + '</td>';
					data_content += '<td>' + row['image_path'] + '</td>';
					data_content += '<td>';
					if(row['image_path'] != null && row['image_path'] != '') { 
							data_content += '<button class="btn btn-info btn-view-image" type="button">View Image</button>';
					} else {
							data_content += '<button class="btn btn-danger" type="button">No Image</button>';
					}
					data_content += '</td>';
					data_content += '<td><button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>';
					data_content += '<button class="btn btn-warning mb-2 mr-1 btn-pdf" type="button" title="A4 format"><span class="btn-icon ua-icon-pages"></button>';
					data_content += '<button class="btn btn-success mb-2 mr-1 btn-pdf1" type="button" title="sticker format"><span class="btn-icon ua-icon-pages"></button>';
					data_content += '<button class="btn btn-purple mb-2 mr-1 btn-edit" type="button"><span class="btn-icon ua-icon-pencil"></button>';
					data_content += '<button class="btn btn-danger mb-2 mr-1 btn-remove" type="button"><span class="btn-icon ua-icon-trash"></button>';
					data_content += '</td></tr>';
				 }
					data_content += '</tbody>';
					data_content += '</table>';
					data_content += '</div>';
		    			
		    		$("#ajax_table").html(data_content);
		    			
    			 var table = $('#datatable').DataTable({
				        lengthChange: false,
				        buttons: [
				          'print', 'excel', 'pdf', 'colvis'
				        ],
				        select: true,
				        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
				        order: [5, "desc"],
				        "columnDefs": [
				            {
				                "targets": [ 7 ],
				                "visible": false,
				                "searchable": false
				            }
				        ]
				    });
				    
		    	$("#datatable_filter").html('');
		    	 table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
		   },
         
			error: function (jqXHR, exception) {
		        var msg = '';
		        if (jqXHR.status === 0) 		{
	            msg = 'Not connect.\n Verify Network.';
	        	} else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) 		{
	            msg = 'Internal Server Error [500].';
	        	} else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') 		{
	            msg = 'Ajax request aborted.';
	        	} else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        console.log(msg);
			},
		  });
		 }

		 $('#search_text').keyup(function(e){
		 	if (event.keyCode === 13) {
			  var search = $(this).val();
			  if(search != '')
			  {
			   load_data(search);
			  }
			  else
			  {
//			   load_data();
				alert("Please enter search terms.");
			  }
			}
		 });
		 
		 $('#btn_search').click(function(){
		 	var search = $("#search_text").val();
		 	  if(search != '')
			  {
			   load_data(search);
			  }
			  else
			  {
//			   load_data();
				alert("Please enter search terms.");
			  }
		 });
		 
		 $('#btn_notice_list').click(function(){
				$.ajax({
			   	url:"<?php echo base_url(); ?>admin/Notifications/get_notice_track",
			   	async:false,
			   	type:"POST",
			   	dataType: "json",
			   	data:{ nCnt : 10 },
			    success:function(data){
					var data_content = '';
		
					var rows = data.arr_data;
					var nLen = rows.length;
					var tmp = '';
					for(var i = 0; i < nLen; i++)
					{
						var row = rows[i];
						tmp = "<?php echo base_url(); ?>admin/Notifications/show_notice_track_ById?id=" + row['id'];
						data_content += '<a class="dropdown-item waves-effect waves-light" href="' + tmp + '">' + row['title'] + '</a>';
	    		
					 }	
		    		var link = "<?php echo base_url(); ?>admin/Notifications/show_notice_tracks";
	    			data_content += '<hr/><a class="dropdown-item waves-effect waves-light" href="' + link + '" style="text-align:center;display: block;">View all</a>';	
	    		
		    		$("#notice_list").html(data_content);
		    		$("#notice_count").html('');
			    			
	  		   },
	         
				error: function (jqXHR, exception) 																		{
		        var msg = '';
		        if (jqXHR.status === 0) 		{
	            msg = 'Not connect.\n Verify Network.';
	        	} else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) 		{
	            msg = 'Internal Server Error [500].';
	        	} else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') 		{
	            msg = 'Ajax request aborted.';
	        	} else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        console.log(msg);
			},
			  });
		});
		
		$("#notice_onoff").click(function(){ 
		
			$.ajax({
		    	url:"<?php echo base_url(); ?>Signin/change_notice_onoff",
			   	async:false,
			   	type:"POST",
			   	dataType: "json",
			   	data:{ onoff : 'on' },
			    success:function(data){
				
					var ret = data.result;
					alert(ret);
					alert(data.onoff);	
					location.href = "#";
			    			
	  		   },
	         
				error: function (jqXHR, exception) 																		{
		        var msg = '';
		        if (jqXHR.status === 0) 		{
	            msg = 'Not connect.\n Verify Network.';
	        	} else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) 		{
	            msg = 'Internal Server Error [500].';
	        	} else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') 		{
	            msg = 'Ajax request aborted.';
	        	} else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        console.log(msg);
			},
			  });
		
		});
	
	});
	</script>

</body>
</html>
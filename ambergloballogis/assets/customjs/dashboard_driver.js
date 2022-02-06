$(document).ready(function() {
    $(document).on("click", "#btn-submit", function(e){
		var tracking_number = $('#tracking_number').val();
		if(tracking_number == ''){
            $.alert('Please input tracking number!');
			$('#tracking_number').focus();
			return;
		}
        $.ajax({
			url: "dashboard/check",
			type: "POST",
			dataType: 'json',
			data: {tracking_number: tracking_number},
			success: function(response){
				if(response.success == 1) {
					var html = '';
					html += '<h4>Tracking Status Update: <span id="tracking_no">'+tracking_number+'</span></h4>';
					html += '<input type="hidden" id="tracking_number_id" value="'+response.tracking_number_id+'">';
					html += '<div class="widget widget-alpha widget-alpha--color-amaranth">';
					html += '	<div class="row">';
					html += '		<div class="col-12">';
					html += '			<div class="form-group">';
					html += '				<label for="status_id">Update Status</label>';
					html += '				<select id="status_id" name="status_id" class="form-control">';
					html += '					<option></option>';
					$.each(response.data, function(index, value){
						html += '				<option value="'+value.id+'">'+value.name+'</option>';
					});
					html += '				</select>';
					html += '			</div>';
					html += '		</div>';
					html += '		<div class="col-12">';
					html += '			<div class="form-group">';
					html += '				<label for="image_path">Upload Delivery Proof</label>';
					html += '				<input type="file" class="form-control" accept=".jpg, .jpeg" name="image_path" id="image_path">';
					html += '			</div>';
					html += '		</div>';
					html += '		<div class="col-12">';
					html += '			<div class="form-group">';
					html += '				<label for="location">Location</label>';
					html += '				<input type="text" class="form-control" name="location" id="location" placeholder="Enter Location">';
					html += '			</div>';
					html += '		</div>';
					html += '		<div class="col-12">';
					html += '			<div class="form-group">';
					html += '				<label for="remark">Remark</label>';
					html += '				<div class="col-lg-12">';
					html += '					<textarea class="form-control" name="remark" id="remark" rows="3"></textarea>';
					html += '				</div>';
					html += '			</div>';
					html += '		</div>';
					html += '		<div class="col-12">';
					html += '			<div class="form-group">';
					html += '				<button class="btn btn-info" type="button" id="btn-update">Update</button>';
					html += '			</div>';
					html += '		</div>';
					html += '	</div>';
					html += '</div>';
					$('#div-update').html(html);
				}else if(response.success == 0){
					$.alert('The tracking number does not exist!');
					$('#div-update').html('');
				}else{
					$.alert('The tracking number have already delivered!');
					$('#div-update').html('');
				}
			}
		});
        
	});

	$(document).on("click", "#btn-update", function(e){
		var tracking_number_id = $('#tracking_number_id').val();
		var status_id = $('#status_id').val();
		var remark = $('#remark').val();
		var location = $('#location').val();

		if(status_id == ''){
            $.alert('Please select tracking status!');
			$('#status_id').focus();
			return;
		}
		var formdata = new FormData();
		formdata.append('tracking_number_id', tracking_number_id);
		formdata.append('status_id', status_id);
		formdata.append('remark', remark);
		formdata.append('location', location);
        formdata.append('image_path', $('#image_path')[0].files[0]);
        $.ajax({
			url: "dashboard/create_status", 
			type: "POST",
			dataType: 'json',
            data: formdata,
            processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(response){
				if(response.success == 1){
					$.alert('Successfully updated!');
					$('#div-update').empty();
                }else if(response.success == 0){
					$.alert('Some errors happens! Please try again!');
				}else{
                    $.alert('Duplicated tracking status!');
                    $('#status_id').focus();
				}
			}
		});

	});
});
$(document).ready(function() {
    var table = $('#datatable').DataTable({
        lengthChange: false,
        buttons: [
          'print', 'excel', 'pdf', 'colvis'
        ],
        select: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: []
    });
    table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
    
    function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
    }

    function isNumeric(value) {
        return /^-?\d+$/.test(value);
    }
    
    $(document).on("click", "#btn-new", function(e){
        $('#mdl-driver').modal('show');
        $('.modal-title').html('Add new driver');
        $("#btn-save").removeAttr('style');
        $("#btn-update").css("display","none");
        $('#edit_id').val('');
        $('#edit_index').val('');
    });

    $(document).on("click", "#btn-save", function(e){
        var username	    = $('#username').val();
        var email	        = $('#email').val();
        var password	    = $('#password').val();
        var name	        = $('#name').val();
        var contact_number	= $('#contact_number').val();
        var zone	        = $('#zone').val();
        var vehicle_number	= $('#vehicle_number').val();
        var vehicle_type	= $('#vehicle_type').val();
        var country	        = $('#country').val();
        var state	        = $('#state').val();
        var city	        = $('#city').val();
        var post_code	    = $('#post_code').val();
        var address         = $('#address').val();
        var vehicle_type_txt= $('#vehicle_type option:selected').text();

        if(username == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input username!");
			$('#username').focus();
			return;
        }
        if(!validateEmail(email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid email address!");
			$('#email').focus();
			return;
        }
        if(password == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input password!");
			$('#password').focus();
			return;
        }
        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input name!");
			$('#name').focus();
			return;
        }
        if(!isNumeric(contact_number)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Contact number should be numeric!");
			$('#contact_number').focus();
			return;
        }
        if(zone == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input zone name!");
			$('#zone').focus();
			return;
        }
        if(vehicle_number == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input vehicle number!");
			$('#vehicle_number').focus();
			return;
        }
        if(country == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input country!");
			$('#country').focus();
			return;
        }
        if(state == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input state!");
			$('#state').focus();
			return;
        }
        if(city == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input city!");
			$('#city').focus();
			return;
        }
        if(!isNumeric(post_code)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Postal code should be numeric!");
			$('#post_code').focus();
			return;
        }
        if(address == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input address!");
			$('#address').focus();
			return;
        }

        var formdata = new FormData();
        formdata.append('username', username);
        formdata.append('email', email);
        formdata.append('password', password);
        formdata.append('name', name);
        formdata.append('contact_number', contact_number);
        formdata.append('zone', zone);
        formdata.append('vehicle_number', vehicle_number);
        formdata.append('vehicle_type', vehicle_type);
        formdata.append('post_code', post_code);
        formdata.append('country', country);
        formdata.append('state', state);
        formdata.append('city', city);
        formdata.append('address', address);
        // formdata.append('image_path', imgSrc);
        formdata.append('image_path', $('#image_path')[0].files[0]);
        $.ajax({
			url: "drivers/create", 
			type: "POST",
			dataType: 'json',
            data: formdata,
            processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(response){
				if(response.success == 1){
                    $('#mdl-driver').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-driver").trigger('reset');
                    // $('.img-container').empty();
                    $('#vehicle_type').select2('');
                    
                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    table.row.add([ response.id, username, email, contact_number, vehicle_number, vehicle_type_txt, zone, country, state, city, address, action ]).draw();
                }else if(response.success == 0){
					$("#div-alert").removeAttr('style');
			        $("#alert-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert").removeAttr('style');
                    $("#alert-message").html("Duplicated username!");
                    $('#username').focus();
				}
			}
		});
        
    });

    $(document).on("click", ".edit-row", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        var id		= data[0];

        $.ajax({
			url: "drivers/get_driver", 
			type: "POST",
			dataType: 'json',
			data: { id: id },
			success: function(response){
				if(response !== false){
                    $('#mdl-driver').modal('show');
                    $('.modal-title').html('Edit driver');
                    $("#btn-update").removeAttr('style');
                    $("#btn-save").css("display","none");
                    $('#edit_id').val(id);
                    $('#edit_index').val(index);
                    $('#username').val(response[0].username);
                    $('#email').val(response[0].email);
                    $('#password').val('**********');
                    $('#name').val(response[0].name);
                    $('#contact_number').val(response[0].contact_number);
                    $('#vehicle_number').val(response[0].vehicle_number);
                    $('#vehicle_type').val(response[0].vehicle_type);
                    $('#vehicle_type').trigger('change');
                    $('#zone').val(response[0].zone);
                    $('#country').val(response[0].country);
                    $('#state').val(response[0].state);
                    $('#city').val(response[0].city);
                    $('#post_code').val(response[0].post_code);
                    $('#address').val(response[0].address);
                }
			}
		});
        
    });

    $(document).on("click", "#btn-update", function(e){
        var id              = $('#edit_id').val();
        var index           = $('#edit_index').val();
        var username	    = $('#username').val();
        var email	        = $('#email').val();
        var password	    = $('#password').val();
        var name	        = $('#name').val();
        var contact_number	= $('#contact_number').val();
        var zone	        = $('#zone').val();
        var vehicle_number	= $('#vehicle_number').val();
        var vehicle_type	= $('#vehicle_type').val();
        var country	        = $('#country').val();
        var state	        = $('#state').val();
        var city	        = $('#city').val();
        var post_code	    = $('#post_code').val();
        var address         = $('#address').val();
        var vehicle_type_txt= $('#vehicle_type option:selected').text();

        if(username == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input username!");
			$('#username').focus();
			return;
        }
        if(!validateEmail(email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid email address!");
			$('#email').focus();
			return;
        }
        if(password == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input password!");
			$('#password').focus();
			return;
        }
        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input name!");
			$('#name').focus();
			return;
        }
        if(!isNumeric(contact_number)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Contact number should be numeric!");
			$('#contact_number').focus();
			return;
        }
        if(zone == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input zone name!");
			$('#zone').focus();
			return;
        }
        if(vehicle_number == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input vehicle number!");
			$('#vehicle_number').focus();
			return;
        }
        if(country == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input country!");
			$('#country').focus();
			return;
        }
        if(state == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input state!");
			$('#state').focus();
			return;
        }
        if(city == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input city!");
			$('#city').focus();
			return;
        }
        if(!isNumeric(post_code)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Postal code should be numeric!");
			$('#post_code').focus();
			return;
        }
        if(address == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input address!");
			$('#address').focus();
			return;
        }

        var formdata = new FormData();
        formdata.append('id', id);
        formdata.append('username', username);
        formdata.append('email', email);
        formdata.append('password', password);
        formdata.append('name', name);
        formdata.append('contact_number', contact_number);
        formdata.append('zone', zone);
        formdata.append('vehicle_number', vehicle_number);
        formdata.append('vehicle_type', vehicle_type);
        formdata.append('post_code', post_code);
        formdata.append('country', country);
        formdata.append('state', state);
        formdata.append('city', city);
        formdata.append('address', address);
        formdata.append('image_path', $('#image_path')[0].files[0]);

        $.ajax({
			url: "drivers/update", 
			type: "POST",
			dataType: 'json',
            data: formdata,
            processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(response){
				if(response.success == 1){
                    $('#mdl-driver').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-driver").trigger('reset');
                    $('#vehicle_type').select2('');
                    
                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    table.row(index).data([ id, username, email, contact_number, vehicle_number, vehicle_type_txt, zone, country, state, city, address, action ]).draw();
                }else if(response.success == 0){
					$("#div-alert").removeAttr('style');
			        $("#alert-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert").removeAttr('style');
                    $("#alert-message").html("Duplicated username!");
                    $('#username').focus();
				}
			}
		});
        
    });

    $(document).on("click", ".remove-row", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        var id		= data[0];

        $.alert({
            title: 'Are you sure?',
            content: 'Are you sure you want to delete this customer?',
            animation: 'top',
            closeAnimation: 'bottom',
            backgroundDismiss: true,
            closeIcon: true,
            draggable: false,
            buttons: {
                okay: {
                    text: 'okay',
                    btnClass: 'btn-info',
                    action: function () {
                        $.ajax({
                            url: "drivers/delete", 
                            type: "POST",
                            dataType: 'json',
                            data: { id: id },
                            success: function(response){
                                if(response === true){
                                    var table = $('#datatable').DataTable();
                                    table.row(index).remove().draw();
                                }else{
                                    $.alert('Some errors happened! Please try again!');
                                }
                            }
                        });
                    }
                },
                cancelAction: {
                    text: 'Cancel',
                    action: function () {
    
                    }
                }
            }
        });
    });

    // let result = document.querySelector('.img-container'),
    // save = document.querySelector('#btn-crop'),
    // upload = document.querySelector('#image_path'),
	// cropper = '';
    // let imgSrc = '';
    
    // upload.addEventListener('change', (e) => {
	// 	if (e.target.files.length) {
    //         $('.img-container').empty();
    //         $('#btn-crop').removeAttr('style');
	// 		// start file reader
	// 		const reader = new FileReader();
	// 		reader.onload = (e)=> {
	// 			if(e.target.result){
	// 				// create new image
	// 				let img = document.createElement('img');
	// 				img.id = 'image';
	// 				img.src = e.target.result
	// 				// clean result before
	// 				result.innerHTML = '';
	// 				// append new image
	// 				result.appendChild(img);
	// 				// init cropper
	// 				cropper = new Cropper(img, {
	// 					aspectRatio: 1 / 1
	// 				});
	// 			}
	// 		};
	// 		reader.readAsDataURL(e.target.files[0]);
	// 	}
    // });
    
    // save.addEventListener('click',(e)=>{
	// 	e.preventDefault();
	// 	// get result to data uri
	// 	imgSrc = cropper.getCroppedCanvas({
	// 		width: 1000,
	// 	}).toDataURL();
	// 	// remove hide class of img
	// 	$('.img-container').empty();
	// 	var image_html = '<img id="image" src="'+imgSrc+'" alt="Picture">';
	// 	$('.img-container').append(image_html);
	// 	$('#btn-crop').css('display', 'none');
	// });

});
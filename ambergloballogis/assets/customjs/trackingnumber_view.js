$(document).ready(function() {    

    function validateEmail(email) {

		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		return re.test(email);

    }



    function isNumeric(value) {

        return /^-?\d+$/.test(value);

    }



    var base_url = $('#base_url').val();

    var modal = document.getElementById("myModal");



    // Get the image and insert it inside the modal - use its "alt" text as a caption

    var modalImg = document.getElementById("img01");

    $(document).on("click", ".btn-view-image", function(e){

        var image_path = $(this).closest('tr').find('.image_path').val();

        modal.style.display = "block";

        modalImg.src = base_url+'uploads/delivery/'+image_path;

    });



    // When the user clicks on <span> (x), close the modal

    $(document).on("click", ".close1", function(e){

        modal.style.display = "none";

    });



    var _self;

    

    $(document).on("click", "#btn-new", function(e){

        $('#mdl-trackingstatus').modal('show');

        $('.modal-title').html('Add new Tracking Status');

        $("#btn-save").removeAttr('style');

        $("#btn-update").css("display","none");

        $('#edit_id').val('');

        $('#status_id').select2();

    });



    $(document).on("click", "#btn-save", function(e){
        var tracking_number_id	= $('#tracking_number_id').val();
        var status_id	        = $('#status_id').val();
        var date_stamp	        = $('#date_stamp').val();
        var location	        = $('#location').val();
        var remark	            = $('#remark').val();
        var status_txt          = $('#status_id option:selected').text();
        if(status_id == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please select status!");
			$('#status_id').focus();
			return;
        }
        if(date_stamp == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input date!");
			$('#date_stamp').focus();
			return;
        }
        if(location == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input location!");
			$('#location').focus();
			return;
        }
        var formdata = new FormData();
        formdata.append('tracking_number_id', tracking_number_id);
        formdata.append('status_id', status_id);
        formdata.append('date_stamp', date_stamp);
        formdata.append('location', location);
        formdata.append('remark', remark);
        // formdata.append('image_path', imgSrc);
        formdata.append('image_path', $('#image_path')[0].files[0]);
        $.ajax({
			url: "create_status", 
			type: "POST",
			dataType: 'json',
            data: formdata,
            processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(response){
				if(response.success == 1){
                    $('#mdl-trackingstatus').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-trackingstatus").trigger('reset');
                    // $('.img-container').empty();
                    var image = '';
                    if(response.image_path === null || response.image_path == ''){
                        image = '<button class="btn btn-danger" type="button">No Image</button>';
                    }else{
                        image = '<button class="btn btn-info btn-view-image" type="button">View Image</button>';
                    }
                    var html = '';
                    html += '<tr>'
                    html += '<td>'+status_txt+'</td>'
                    html += '<td>'+response.date_stamp+'</td>'
                    html += '<td>'+remark+'</td>'
                    html += '<td>'+location+'</td>'
                    html += '<td>'+image+'</td>'
                    html += '<td>'+response.creator_name+'</td>'
                    html += '<td>'
                    html += '   <input type="hidden" class="statusid" value="'+response.id+'">'
                    html += '   <input type="hidden" class="image_path" value="'+response.image_path+'">'
                    html += '   <button class="btn btn-purple mb-2 mr-1 btn-edit" type="button"><span class="btn-icon ua-icon-pencil"></button>'
                    html += '   <button class="btn btn-danger mb-2 mr-1 btn-remove" type="button"><span class="btn-icon ua-icon-trash"></button>'
                    html += '</td>'
                    html += '</tr>'
                    $('#status_list').prepend(html);
                }else if(response.success == 0){
					$("#div-alert").removeAttr('style');
			        $("#alert-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert").removeAttr('style');
                    $("#alert-message").html("Duplicated tracking status!");
                    $('#status_id').focus();
				}
			}
		});
    });
    $(document).on("click", ".btn-edit", function(e){

        var id = $(this).closest( 'td' ).find('.statusid').val();

        _self = $(this);

        $.ajax({

			url: "get_trackingstatus", 

			type: "POST",

			dataType: 'json',

			data: { id: id },

			success: function(response){

				if(response !== false){

                    $('#mdl-trackingstatus').modal('show');

                    $('.modal-title').html('Edit tracking status');

                    $("#btn-update").removeAttr('style');

                    $("#btn-save").css("display","none");



                    $('#edit_id').val(id);

                    $('#status_id').val(response[0].status_id);

                    $('#status_id').trigger('change');

                    $('#date_stamp').val(response[0].date_stamp);

                    $('#location').val(response[0].location);
                    $('#remark').val(response[0].remark);

                }

			}

		});

        

    });



    $(document).on("click", "#btn-update", function(e){

        var id                  = $('#edit_id').val();

        var status_id	        = $('#status_id').val();

        var date_stamp	        = $('#date_stamp').val();

        var location	        = $('#location').val();

        var remark	            = $('#remark').val();

        var status_data         = $('#status_id').select2('data');

        var status_name         = status_data[0].text;

        var tracking_number_id	= $('#tracking_number_id').val();



        if(status_id == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please select status!");

			$('#status_id').focus();

			return;

        }

        if(date_stamp == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input date!");

			$('#date_stamp').focus();

			return;

        }

        if(location == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input location!");

			$('#location').focus();

			return;

        }



        var formdata = new FormData();

        formdata.append('tracking_number_id', tracking_number_id);

        formdata.append('id', id);

        formdata.append('status_id', status_id);

        formdata.append('date_stamp', date_stamp);

        formdata.append('location', location);

        formdata.append('remark', remark);

        // formdata.append('image_path', imgSrc);

        formdata.append('image_path', $('#image_path')[0].files[0]);



        $.ajax({

			url: "update_status", 

			type: "POST",

			dataType: 'json',

            data: formdata,

            processData:false,

			contentType:false,

			cache:false,

			async:false,

			success: function(response){

				if(response.success == 1){

                    $('#mdl-trackingstatus').modal('hide');

                    $("#div-alert").css("display","none");

                    $("#form-trackingstatus").trigger('reset');

                    // $('.img-container').empty();



                    var image = '';

                    if(response.image_path === null || response.image_path == ''){

                        image = '<button class="btn btn-danger" type="button">No Image</button>';

                    }else{

                        image = '<button class="btn btn-info btn-view-image" type="button">View Image</button>';

                    }



                    _self.closest('tr').find('td:eq(0)').html(status_name);

                    _self.closest('tr').find('td:eq(1)').html(response.date_stamp);

                    _self.closest('tr').find('td:eq(2)').html(remark);

                    _self.closest('tr').find('td:eq(3)').html(location);

                    _self.closest('tr').find('td:eq(4)').html(image);

                    _self.closest('tr').find('.image_path').val(response.image_path);



                }else if(response.success == 0){

					$("#div-alert").removeAttr('style');

			        $("#alert-message").html("Some errors happens! Please try again!");

				}else{

                    $("#div-alert").removeAttr('style');

                    $("#alert-message").html("Duplicated tracking status!");

                    $('#status_id').focus();

				}

			}

		});

        

    });



    $(document).on("click", ".btn-remove", function(e){

        var tracking_number_id	= $('#tracking_number_id').val();

        var id = $(this).closest( 'td' ).find('.statusid').val();

        _self = $(this);

        $.alert({

            title: 'Are you sure?',

            content: 'Are you sure you want to delete this tracking status?',

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

                            url: "delete_status", 

                            type: "POST",

                            dataType: 'json',

                            data: { id: id, tracking_number_id: tracking_number_id },

                            success: function(response){

                                if(response !== false){

                                    _self.closest('tr').remove();

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
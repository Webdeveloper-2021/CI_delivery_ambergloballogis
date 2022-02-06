$(document).ready(function() {

	function OnInit_trackingnumber_add(){
		
		var date = new Date();

 	   	var cur_date = ('0' + date.getDate()).slice(-2);
   		var cur_month = ('0' + (date.getMonth() + 1)).slice(-2);
    	var cur_year = date.getFullYear().toString().substr(2,2);
    	var cur_hour = ('0' + date.getHours()).slice(-2);
    	var cur_minute = ('0' + date.getMinutes()).slice(-2);
    	var cur_second = ('0' + date.getSeconds()).slice(-2);
    	
		var track_id = 'AC' + cur_year + cur_month + cur_date + cur_hour + cur_minute + cur_second;
		
		$('#tracking_number').val(track_id);
		$('#tracking_number').prop("readonly", true);
		
        $('#station_id').select2();

        $('#status_id').select2();

        $('#sender_id').select2();

        $('#receiver_id').select2();

	}
	
	OnInit_trackingnumber_add();

    $.fn.dataTable.moment( 'DD MMM YYYY' );

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


 	$("#datatable_filter").hide();
    


    table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

    

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

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data	= table.row($row).data();

        var id		= data[0];



        $.ajax({

			url: "trackingnumbers/get_last_status", 

			type: "POST",

			dataType: 'json',

			data: { id: id },

			success: function(response){

				modal.style.display = "block";

                modalImg.src = base_url+'uploads/delivery/'+response[0].image_path;

			}

		});

    });



    // When the user clicks on <span> (x), close the modal

    $(document).on("click", ".close1", function(e){

        modal.style.display = "none";

    });

  
	var flag_edit_track_num = 0;
    $(document).on("click", "#btn_edit_track_num", function(e){
    	if (flag_edit_track_num == 0){
			$('#tracking_number').prop("readonly", false);
    		$('#tracking_number').focus;
    		flag_edit_track_num = 1;
		}else{
			$('#tracking_number').prop("readonly", true);
			flag_edit_track_num = 0;
		}
     });
    
   $('#docket, #sender_station select:first, #receiver_station select:first, #status_id, #date_stamp, #location, #image_path, #remark, #size, #weight, #no_of_pieces, #parcel_type, #special_notes, #content_description, #sender_id, #receiver_id').focus(function(){
	    $('#tracking_number').prop("readonly", true);
	});
	
    $(document).on("click", "#btn-new", function(e){
    	var date = new Date();
 	   	var cur_date = ('0' + date.getDate()).slice(-2);
   		var cur_month = ('0' + (date.getMonth() + 1)).slice(-2);
    	var cur_year = date.getFullYear().toString().substr(2,2);
    	var cur_hour = ('0' + date.getHours()).slice(-2);
    	var cur_minute = ('0' + date.getMinutes()).slice(-2);
    	var cur_second = ('0' + date.getSeconds()).slice(-2);    	
		var track_id = 'AC' + cur_year + cur_month + cur_date + cur_hour + cur_minute + cur_second;		
	    $.ajax({

			url: "trackingnumbers/get_trackingnumber", 

			type: "POST",

			dataType: 'json',

			data: { id: track_id },

			success: function(response){

				if(response === false){
					$('#tracking_number').val(track_id);
					$('#tracking_number').prop("readonly", true);
	            }else{
					$('#tracking_number').val('');
					$('#tracking_number').focus();
				}
			}
		});

        $('#mdl-trackingnumber').modal('show');

        $('#station_id').select2();

        $('#status_id').select2();

        $('#sender_id').select2();

        $('#receiver_id').select2();

    });



    $(document).on("click", "#btn-save", function(e){

        var docket	            = $('#docket').val();

        var tracking_number	    = $('#tracking_number').val();

        var sender_station	    = $('#sender_station').val();

        var receiver_station	= $('#receiver_station').val();

        var status_id	        = $('#status_id').val();

        var date_stamp	        = $('#date_stamp').val();

        var remark	            = $('#remark').val();

        var size	            = $('#size').val();

        var weight	            = $('#weight').val();

        var no_of_pieces	    = $('#no_of_pieces').val();

        var parcel_type	        = $('#parcel_type').val();

        var special_notes	    = $('#special_notes').val();

        var content_description = $('#content_description').val();

        var sender_id           = $('#sender_id').val();

        var receiver_id         = $('#receiver_id').val();

        var location            = $('#location').val();

        var sender_station_txt  = $('#sender_station option:selected').text();

        var receiver_station_txt= $('#receiver_station option:selected').text();



        if(docket == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input docket#!");

			$('#docket').focus();

			return;

        }

        if(tracking_number == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input tracking number!");

			$('#tracking_number').focus();

			return;

        }
        
    /*    var nLen_tracking_number 	= tracking_number.length;
        var pre_tracking_number 	= tracking_number.substr(0,2);      
        if(nLen_tracking_number != 14){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html('The tracking number format to be "AC + 12 random digits".');
			$('#tracking_number').focus();
			return;
        }        
        if(pre_tracking_number != 'AC'){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html('The tracking number format to be "AC + 12 random digits".');
			$('#tracking_number').focus();
			return;
        }*/

        if(sender_station == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please select sender station name!");

			$('#sender_station').focus();

			return;

        }

        if(receiver_station == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please select receiver station name!");

			$('#receiver_station').focus();

			return;

        }

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

        if(sender_id == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please select sender!");

			$('#sender_id').focus();

			return;

        }

        if(receiver_id == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please select receiver!");

			$('#receiver_id').focus();

			return;

        }

        if(special_notes.length > 80) {

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("The count of characters should not exceed 80!");

			$('#special_notes').focus();

			return;

        }

        if(content_description.length > 180) {

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("The count of characters should not exceed 180!");

			$('#content_description').focus();

			return;

        }



        var formdata = new FormData();

        formdata.append('docket', docket);

        formdata.append('tracking_number', tracking_number);

        formdata.append('sender_station', sender_station);

        formdata.append('receiver_station', receiver_station);

        formdata.append('status_id', status_id);

        formdata.append('date_stamp', date_stamp);

        formdata.append('remark', remark);

        formdata.append('size', size);

        formdata.append('weight', weight);

        formdata.append('no_of_pieces', no_of_pieces);

        formdata.append('parcel_type', parcel_type);

        formdata.append('special_notes', special_notes);

        formdata.append('content_description', content_description);

        formdata.append('sender_id', sender_id);

        formdata.append('receiver_id', receiver_id);

        formdata.append('location', location);

        formdata.append('image_path', $('#image_path')[0].files[0]);

        $.ajax({

			//url: "trackingnumbers/create", 
			url: base_url + "/station/trackingnumbers/create", 

			type: "POST",

			dataType: 'json',

            data: formdata,

            processData:false,

			contentType:false,

			cache:false,

			async:false,

			success: function(response){

				if(response.success == 1){
/*                    $('#mdl-trackingnumber').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-trackingnumber").trigger('reset');

                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>\n<button class="btn btn-warning mb-2 mr-1 btn-pdf" type="button"><span class="btn-icon ua-icon-pages"></button>\n<button class="btn btn-purple mb-2 mr-1 btn-edit" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 btn-remove" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    var image = '';
                    if(response.image_path === null || response.image_path == ''){
                        image = '<td>\n<button class="btn btn-danger" type="button">No Image</button>\n</td>';
                    }else{
                        image = '<td>\n<button class="btn btn-info btn-view-image" type="button">View Image</button>\n</td>';
                    }
                    table.row.add([ response.id, tracking_number, sender_station_txt, receiver_station_txt, response.status_name, response.date_stamp, response.remark, image, action ]).draw();
*/
					$("#form-trackingnumber").trigger('reset');
					$("#div-alert").removeAttr('style');

			        $("#alert-message").html("Added new trackingnumber successfully!");
			        $("#div-alert").css("background-color", "#56ce56");
                    OnInit_trackingnumber_add();
                }else if(response.success == 0){

					$("#div-alert").removeAttr('style');

			        $("#alert-message").html("Some errors happens! Please try again!");

				}else{

                    $("#div-alert").removeAttr('style');

                    $("#alert-message").html("Duplicated tracking number!");

                    $('#tracking_number').focus();

				}

			}

		});

        

    });



    $(document).on("click", ".btn-edit", function(e){

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data	= table.row($row).data();

        var index	= table.row($row).index();

        var id		= data[0];



        $.ajax({

			//url: "trackingnumbers/get_trackingnumber", 
			url: base_url + "station/trackingnumbers/get_trackingnumber", 

			type: "POST",

			dataType: 'json',

			data: { id: id },

			success: function(response){

				if(response !== false){

                    $('#mdl-edit-trackingnumber').modal('show');

                    $('#e_station_id').select2();

                    $('#e_sender_id').select2();

                    $('#e_receiver_id').select2();



                    $('#edit_id').val(id);

                    $('#edit_index').val(index);

                    $('#e_docket').val(response[0].docket);

                    $('#e_tracking_number').val(response[0].tracking_number);
                    
                    
                    $('#e_sender_station').val(response[0].sender_station);

                    $('#e_sender_station').trigger('change');
                    

                    $('#e_receiver_station').val(response[0].receiver_station);

                    $('#e_receiver_station').trigger('change');

                    $('#e_size').val(response[0].size);

                    $('#e_weight').val(response[0].weight);

                    $('#e_no_of_pieces').val(response[0].no_of_pieces);

                    $('#e_parcel_type').val(response[0].parcel_type);

                    $('#e_parcel_type').trigger('change');

                    $('#e_special_notes').val(response[0].special_notes);

                    $('#e_content_description').val(response[0].content_description);

                    $('#e_sender_id').val(response[0].sender_id);

                    $('#e_sender_id').trigger('change');

                    $('#e_receiver_id').val(response[0].receiver_id);

                    $('#e_receiver_id').trigger('change');

                }

			}

		});

        

    });



    $(document).on("click", "#btn-update", function(e){

        var id                  = $('#edit_id').val();

        var index               = $('#edit_index').val();

        var docket	            = $('#e_docket').val();

        var tracking_number	    = $('#e_tracking_number').val();

        var sender_station      = $('#e_sender_station').val();

        var receiver_station    = $('#e_receiver_station').val();

        var size	            = $('#e_size').val();

        var weight	            = $('#e_weight').val();

        var no_of_pieces	    = $('#e_no_of_pieces').val();

        var parcel_type	        = $('#e_parcel_type').val();

        var special_notes	    = $('#e_special_notes').val();

        var content_description = $('#e_content_description').val();

        var sender_id           = $('#e_sender_id').val();

        var receiver_id         = $('#e_receiver_id').val();

        var sender_station_txt  = $('#e_sender_station option:selected').text();

        var receiver_station_txt= $('#e_receiver_station option:selected').text();

        var parcel_type_txt     = $('#e_parcel_type option:selected').text();



        if(docket == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please input docket#!");

			$('#e_docket').focus();

			return;

        }

        if(tracking_number == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please input tracking number!");

			$('#e_tracking_number').focus();

			return;

        }
        
        /*var nLen_tracking_number 	= tracking_number.length;
        var pre_tracking_number 	= tracking_number.substr(0,2);      
        if(nLen_tracking_number != 14){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html('The tracking number format to be "AC + 12 random digits".');
			$('#tracking_number').focus();
			return;
        }        
        if(pre_tracking_number != 'AC'){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html('The tracking number format to be "AC + 12 random digits".');
			$('#tracking_number').focus();
			return;
        }*/


        if(sender_station == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please select sender station name!");

			$('#e_sender_station').focus();

			return;

        }

        if(receiver_station == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please select receiver station name!");

			$('#e_receiver_station').focus();

			return;

        }

        if(sender_id == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please select sender!");

			$('#e_sender_id').focus();

			return;

        }

        if(receiver_id == ''){

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("Please select receiver!");

			$('#e_receiver_id').focus();

			return;

        }

        if(special_notes.length > 80) {

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("The count of characters should not exceed 80!");

			$('#e_special_notes').focus();

			return;

        }

        if(content_description.length > 180) {

            $("#div-edit-alert").removeAttr('style');

			$("#alert-edit-message").html("The count of characters should not exceed 180!");

			$('#e_content_description').focus();

			return;

        }



        $.ajax({

			//url: "trackingnumbers/update", 
			url: base_url + "station/trackingnumbers/update", 

			type: "POST",

			dataType: 'json',

			data: { id: id, tracking_number: tracking_number, sender_station: sender_station, receiver_station: receiver_station, size: size, weight: weight, no_of_pieces: no_of_pieces, parcel_type: parcel_type, special_notes: special_notes, content_description: content_description, sender_id: sender_id, receiver_id: receiver_id, docket: docket },

			success: function(response){

				if(response.success == 1){

                    $('#mdl-edit-trackingnumber').modal('hide');

                    $("#div-edit-alert").css("display","none");

                    $("#form-edit-trackingnumber").trigger('reset');

                    

                    var table = $('#datatable').DataTable();

                    table.cell({row: index, column: 1}).data(tracking_number);

                    table.cell({row: index, column: 2}).data(sender_station_txt);

                    table.cell({row: index, column: 3}).data(receiver_station_txt);

                }else if(response.success == 0){

					$("#div-edit-alert").removeAttr('style');

			        $("#alert-edit-message").html("Some errors happens! Please try again!");

				}else{

                    $("#div-edit-alert").removeAttr('style');

                    $("#alert-edit-message").html("Duplicated tracking number!");

                    $('#e_tracking_number').focus();

				}

			}

		});

        

    });



    $(document).on("click", ".btn-remove", function(e){

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data	= table.row($row).data();

        var index	= table.row($row).index();

        var id		= data[0];



        $.alert({

            title: 'Are you sure?',

            content: 'Are you sure you want to delete this tracking number?',

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

                            //url: "trackingnumbers/delete", 
                            url: base_url + "station/trackingnumbers/delete", 

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



    $(document).on("click", ".btn-view", function(e){

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data	= table.row($row).data();

        var id		= data[0];

        var tracking_number	= data[1];



        // $.ajax({

        //     url: "trackingnumbers/get_trackingdetail", 

        //     type: "POST",

        //     dataType: 'json',

        //     data: { id: id },

        //     success: function(response){

        //         $('#mdl-trackingnumberstatus').modal('show');

        //         $('.action-alert__action-message').html(tracking_number);

        //         $('#tracking_number_id').val(id);



        //         var html = '';

        //         $.each(response, function(index, value){

        //             html += '';

        //             html += '<tr>';

        //             html += '<td>'+value.status_name+'</td>';

        //             html += '<td>'+value.date_stamp+'</td>';

        //             html += '<td>'+value.remark+'</td>';

        //             if(value.image_path === null || value.image_path == ''){

        //                 html += '<td><button class="btn btn-danger" type="button">No Image</button></td>';

        //             }else{

        //                 html += '<td><button class="btn btn-info btn-view-image1" type="button">View Image</button></td>';

        //             }

                   

        //             html += '<td>';

        //             html += '   <input type="hidden" class="statusid1" value="'+value.id+'">';

        //             html += '   <button class="btn btn-purple mb-2 mr-1 btn-edit1" type="button"><span class="btn-icon ua-icon-pencil"></button>';

        //             html += '   <button class="btn btn-danger mb-2 mr-1 btn-remove1" type="button"><span class="btn-icon ua-icon-trash"></button>';

        //             html += '</td>';

        //             html += '</tr>';

        //         });

        //         $('#status_list').empty();

        //         $('#status_list').append(html);

        //     }

        // });



        //location.href = 'trackingnumbers/view?id='+id;
        location.href = base_url + 'station/trackingnumbers/view?id='+id;

        

    });



    $(document).on("click", ".btn-edit1", function(e){

        var id = $(this).parent().find('.statusid1').val();

        _self = $(this);

        $.ajax({

			url: "trackingnumbers/get_trackingstatus", 

			type: "POST",

			dataType: 'json',

			data: { id: id },

			success: function(response){

				if(response !== false){

                    $('#mdl-trackingstatus').modal('show');

                    $('.modal-title1').html('Edit tracking status');

                    $("#btn-update1").removeAttr('style');

                    $("#btn-save1").css("display","none");



                    $('#edit_id1').val(id);

                    $('#status_id1').val(response[0].status_id);

                    $('#status_id1').trigger('change');

                    $('#date_stamp1').val(response[0].date_stamp);

                    $('#remark1').val(response[0].remark);

                }

			}

		});

        

    });



    $(document).on("click", "#btn-update1", function(e){

        var id                  = $('#edit_id1').val();

        var status_id	        = $('#status_id1').val();

        var date_stamp	        = $('#date_stamp1').val();

        var remark	            = $('#remark1').val();

        var status_data         = $('#status_id1').select2('data');

        var status_name         = status_data[0].text;

        var tracking_number_id	= $('#tracking_number_id').val();



        if(status_id == ''){

            $("#div-alert1").removeAttr('style');

			$("#alert-message1").html("Please select status!");

			$('#status_id1').focus();

			return;

        }

        if(date_stamp == ''){

            $("#div-alert1").removeAttr('style');

			$("#alert-message1").html("Please input date!");

			$('#date_stamp1').focus();

			return;

        }



        var formdata = new FormData();

        formdata.append('tracking_number_id', tracking_number_id);

        formdata.append('id', id);

        formdata.append('status_id', status_id);

        formdata.append('date_stamp', date_stamp);

        formdata.append('remark', remark);

        formdata.append('image_path', $('#image_path')[0].files[0]);



        $.ajax({

			url: "trackingnumbers/update_status", 

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

                    $("#div-alert1").css("display","none");

                    $("#form-trackingstatus").trigger('reset');



                    _self.closest( '.timeline__block' ).find('.timeline__title').html(status_name);

                    _self.closest( '.timeline__block' ).find('p').html(remark);

                    _self.closest( '.timeline__block' ).find('img').attr("src", base_url+'uploads/delivery/'+response.image_path);



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



    $(document).on("click", ".btn-pdf", function(e){

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data	= table.row($row).data();

        var id		= data[0];



        // location.href = 'trackingnumbers/pdfexport?id='+id;

        //window.open('trackingnumbers/pdfexport?id='+id, '_blank');
        var url = base_url + 'station/trackingnumbers/pdfexport?id='+id;
        window.open(url, '_blank');

    });



    $(document).on("click", ".btn-pdf1", function(e){

        var table = $('#datatable').DataTable();

        var $row = $(this).closest( 'tr' );

        var data    = table.row($row).data();

        var id      = data[0];



        // location.href = 'trackingnumbers/pdfexport?id='+id;

        //window.open('trackingnumbers/pdfexport1?id='+id, '_blank');
        window.open(base_url + 'station/trackingnumbers/pdfexport1?id='+id, '_blank');

    });

    
    
    

    $(document).on("click", "#btn-new-customer", function(e){

        $('#mdl-new-customer').modal('show');

    });
    
    
    $(document).on("click", "#btn-customer-save", function(e){

        var username	    = $('#username').val();

        var email	        = $('#email').val();

        var password	    = $('#password').val();

        var name	        = $('#name').val();

        // var custom_id	    = $('#custom_id').val();

        var contact_number	= $('#contact_number').val();

        var company	        = $('#company').val();

        var country	        = $('#country').val();

        var state	        = $('#state').val();

        var city	        = $('#city').val();

        var post_code	    = $('#post_code').val();

        var address         = $('#address').val();



        if(username == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input username!");

			$('#username').focus();

			return;

        }

        if(!validateEmail(email)){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input valid email address!");

			$('#email').focus();

			return;

        }

        if(password == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input password!");

			$('#password').focus();

			return;

        }

        if(name == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input name!");

			$('#name').focus();

			return;

        }

        // if(custom_id == ''){

        //     $("#div-customer-alert").removeAttr('style');

		// 	$("#alert-customer-message").html("Please input customer ID!");

		// 	$('#custom_id').focus();

		// 	return;

        // }

        if(!isNumeric(contact_number)){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Contact number should be numeric!");

			$('#contact_number').focus();

			return;

        }

        if(company == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input company name!");

			$('#company').focus();

			return;

        }

        if(country == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input country!");

			$('#country').focus();

			return;

        }

        if(state == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input state!");

			$('#state').focus();

			return;

        }

        if(city == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input city!");

			$('#city').focus();

			return;

        }

        if(!isNumeric(post_code)){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Postal code should be numeric!");

			$('#post_code').focus();

			return;

        }

        if(address == ''){

            $("#div-customer-alert").removeAttr('style');

			$("#alert-customer-message").html("Please input address!");

			$('#address').focus();

			return;

        }



        $.ajax({

			//url: base_url + "admin/customers/create", 
			url: base_url + "station/customers/create", 

			type: "POST",

			dataType: 'json',

			data: { username: username, email:email, password: password, name: name, contact_number: contact_number, company: company, country: country, state: state, city: city, post_code: post_code, address: address },

			success: function(response){

				if(response.success == 1){

                    $('#mdl-new-customer').modal('hide');

                    $("#div-customer-alert").css("display","none");

                    $("#form-customer").trigger('reset');

                    

                    var html = '<option value="'+response.id+'">'+name+'-'+email+'</option>';

                    $('#sender_id').prepend(html);

                    $('#receiver_id').prepend(html);



                    $('#sender_id').select2();

                    $('#receiver_id').select2();

                }else if(response.success == 0){

					$("#div-customer-alert").removeAttr('style');

			        $("#alert-customer-message").html("Some errors happens! Please try again!");

				}else{

                    $("#div-customer-alert").removeAttr('style');

                    $("#alert-customer-message").html("Duplicated username!");

                    $('#username').focus();

				}

			}

		});

        

    });



});
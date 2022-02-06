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
    
    $("#datatable_filter").hide();

    table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');



    function validateEmail(email) {

		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		return re.test(email);

    }



    function isNumeric(value) {

        return /^-?\d+$/.test(value);

    }

    

    $(document).on("click", "#btn-new", function(e){

        $('#mdl-new-customer').modal('show');

        $('.modal-title').html('Add new customer');

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

        // var custom_id	    = $('#custom_id').val();

        var contact_number	= $('#contact_number').val();

        var company	        = $('#company').val();

        var country	        = $('#country').val();

        var state	        = $('#state').val();

        var city	        = $('#city').val();

        var post_code	    = $('#post_code').val();

        var address         = $('#address').val();



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

        // if(custom_id == ''){

        //     $("#div-alert").removeAttr('style');

		// 	$("#alert-message").html("Please input customer ID!");

		// 	$('#custom_id').focus();

		// 	return;

        // }

        if(!isNumeric(contact_number)){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Contact number should be numeric!");

			$('#contact_number').focus();

			return;

        }

        if(company == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input company name!");

			$('#company').focus();

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



        $.ajax({

			//url: "customers/create", 
			url: base_url + "station/customers/create", 

			type: "POST",

			dataType: 'json',

			data: { username: username, email:email, password: password, name: name, contact_number: contact_number, company: company, country: country, state: state, city: city, post_code: post_code, address: address },

			success: function(response){

				if(response.success == 1){

                    /*$('#mdl-new-customer').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-customer").trigger('reset');                    

                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    table.row.add([ response.id, username, email, contact_number, country, state, city, post_code, address, action ]).draw();*/
                    $("#form-customer").trigger('reset');
					$("#div-alert").removeAttr('style');

			        $("#alert-message").html("Added new customer successfully!");
			        $("#div-alert").css("background-color", "#56ce56");

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

			url: "customers/get_customer", 

			type: "POST",

			dataType: 'json',

			data: { id: id },

			success: function(response){

				if(response !== false){

                    $('#mdl-new-customer').modal('show');

                    $('.modal-title').html('Edit customer');

                    $("#btn-update").removeAttr('style');

                    $("#btn-save").css("display","none");

                    $('#edit_id').val(id);

                    $('#edit_index').val(index);

                    $('#username').val(response[0].username);

                    $('#email').val(response[0].email);

                    $('#password').val('**********');

                    $('#name').val(response[0].name);

                    $('#contact_number').val(response[0].contact_number);

                    $('#company').val(response[0].company_name);

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

        // var custom_id	    = $('#custom_id').val();

        var contact_number	= $('#contact_number').val();

        var company	        = $('#company').val();

        var country	        = $('#country').val();

        var state	        = $('#state').val();

        var city	        = $('#city').val();

        var post_code	    = $('#post_code').val();

        var address         = $('#address').val();



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

        // if(custom_id == ''){

        //     $("#div-alert").removeAttr('style');

		// 	$("#alert-message").html("Please input customer ID!");

		// 	$('#custom_id').focus();

		// 	return;

        // }

        if(!isNumeric(contact_number)){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Contact number should be numeric!");

			$('#contact_number').focus();

			return;

        }

        if(company == ''){

            $("#div-alert").removeAttr('style');

			$("#alert-message").html("Please input company name!");

			$('#company').focus();

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



        $.ajax({

			url: "customers/update", 

			type: "POST",

			dataType: 'json',

			data: { id: id, username: username, email:email, password: password, name: name, contact_number: contact_number, company: company, country: country, state: state, city: city, post_code: post_code, address: address },

			success: function(response){

				if(response.success == 1){

                    $('#mdl-new-customer').modal('hide');

                    $("#div-alert").css("display","none");

                    $("#form-customer").trigger('reset');

                    

                    var table = $('#datatable').DataTable();

                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';

                    table.row(index).data([ id, username, email, contact_number, country, state, city, post_code, address, action ]).draw();

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

                            url: "customers/delete", 

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
    
    
		 function load_data_customer(query)
		 {
		  $.ajax({
		   url: base_url + "station/customers/get_search_customer",
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
				data_content += 				'<th>Customer<br>Name</th>';
				data_content += 				'<th>Email</th>';
				data_content += 				'<th>Contact<br>Number</th>';
				data_content += 				'<th>Country</th>';
				data_content += 				'<th>State</th>';
				data_content += 				'<th>City</th>';
				data_content += 				'<th>Postal<br>Code</th>';
				data_content += 				'<th>Address</th>';
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
					data_content += '<td>' + row['username'] + '</td>';
					data_content += '<td>' + row['email'] + '</td>';
					data_content += '<td>' + row['contact_number'] + '</td>';
					data_content += '<td>' + row['country'] + '</td>';
					data_content += '<td>' + row['state'] + '</td>';
					data_content += '<td>' + row['city'] + '</td>';
					data_content += '<td>' + row['post_code'] + '</td>';
					data_content += '<td>' + row['address'] + '</td>';
	
					data_content += '<td><button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>';
					data_content += '<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>';
					data_content += '</td></tr>';
				 }
					data_content += '</tbody>';
					data_content += '</table>';
					data_content += '</div>';
		    			
		    		$("#ajax_table_customer").html(data_content);
		    			
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

		 $('#search_customer').keyup(function(e){
		 	if (event.keyCode === 13) {
			  var search = $(this).val();
			  if(search != '')
			  {
			   load_data_customer(search);
			  }
			  else
			  {
//			   load_data_customer();
				alert("Please enter search terms.");
			  }
			}
		 });
		 
		 $('#btn_search_customer').click(function(){
		 	var search = $("#search_customer").val();
		 	  if(search != '')
			  {
			   load_data_customer(search);
			  }
			  else
			  {
//			   load_data();
				alert("Please enter search terms.");
			  }
		 });

});
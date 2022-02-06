$(document).ready(function() {	
    //$(document).on("click", "#btn-new", function(e){
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
   // });


    function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
    }

    function isNumeric(value) {
        return /^-?\d+$/.test(value);
    }


    var base_url = $('#base_url').val();
    
    var modal = document.getElementById("myModal");



    $(document).on("click", "#btn-new-customer", function(e){
        $('#mdl-new-customer').modal('show');
    });

    $(document).on("click", "#btn-customer-save", function(e){
        //var username	    = $('#username').val();
        var email	        = $('#email').val();
        //var password	    = $('#password').val();
        var name	        = $('#name').val();
        // var custom_id	    = $('#custom_id').val();
        var contact_number	= $('#contact_number').val();
        var company	        = $('#company').val();
        var country	        = $('#country').val();
        var state	        = $('#state').val();
        var city	        = $('#city').val();
        var post_code	    = $('#post_code').val();
        var address         = $('#address').val();
        
       /* if(username == ''){
            $("#div-customer-alert").removeAttr('style');
			$("#alert-customer-message").html("Please input username!");
			$('#username').focus();
			return;
        }*/

        if(!validateEmail(email)){
            $("#div-customer-alert").removeAttr('style');
			$("#alert-customer-message").html("Please input valid email address!");
			$('#email').focus();
			return;
        }

        /*if(password == ''){
            $("#div-customer-alert").removeAttr('style');
			$("#alert-customer-message").html("Please input password!");
			$('#password').focus();
			return;
        }*/

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
			url: base_url + "customer/Customers/create", 
			async:false,
			type: "POST",
			dataType: 'json',
			
			data: {// username: username, 
					email: email, 
					//password: password, 
					name: name, 
					contact_number: contact_number, 
					company: company, 
					country: country, 
					state: state, 
					city: city, 
					post_code: post_code, 
					address: address },
			success: function(response){
				if(response.success == 1){
                    $('#mdl-new-customer').modal('hide');
                    $("#div-customer-alert").css("display","none");
                    $("#form-customer").trigger('reset');

                    var html = '<option value="'+response.id+'">'+name+'-'+email+'</option>';
                    //$('#sender_id').prepend(html);
                    $('#receiver_id').prepend(html);
                    //$('#sender_id').select2();
                    $('#receiver_id').select2();
                    alert("Added new customer successfully.");
                }else if(response.success == 0){
					$("#div-customer-alert").removeAttr('style');
			        $("#alert-customer-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-customer-alert").removeAttr('style');
                    $("#alert-customer-message").html("Duplicated username!");
                    $('#username').focus();
				}
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
    });

    $(document).on("click", "#btn-save", function(e){
        var tracking_number	    = $('#tracking_number').val();
        var date_stamp	        = $('#date_stamp').val();
        var size	            = $('#size').val();
        var weight	            = $('#weight').val();
        var no_of_pieces	    = $('#no_of_pieces').val();
        var parcel_type	        = $('#parcel_type').val();
       // var special_notes	    = $('#special_notes').val();
        var content_description = $('#content_description').val();
        var sender_id           = $('#sender_id').val();
        var receiver_id         = $('#receiver_id').val();
  
      //  var sender_station_txt  = $('#sender_station option:selected').text();

        var receiver_station_txt= $('#receiver_station option:selected').text();

        if(tracking_number == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input tracking number!");
			$('#tracking_number').focus();
			return;
        }
        
        if(tracking_number == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input tracking number!");
			$('#tracking_number').focus();
			return;
        }

        if(date_stamp == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input date!");
			$('#date_stamp').focus();
			return;
        }

/*        if(sender_id == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please select sender!");
			$('#sender_id').focus();
			return;
        }
*/
        if(receiver_id == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please select receiver!");
			$('#receiver_id').focus();
			return;
        }

        if(content_description.length > 180) {
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("The count of characters should not exceed 180!");
			$('#content_description').focus();
			return;
        }


        var formdata = new FormData();

        formdata.append('tracking_number', tracking_number);
        formdata.append('date_stamp', date_stamp);
        formdata.append('size', size);
        formdata.append('weight', weight);
        formdata.append('no_of_pieces', no_of_pieces);
        formdata.append('parcel_type', parcel_type);
        formdata.append('content_description', content_description);
        formdata.append('sender_id', sender_id);
        formdata.append('receiver_id', receiver_id);

        $.ajax({
			//url: "trackingnumbers/create", 
			url: "pickup_request/create", 
			type: "POST",
			dataType: 'json',
            data: formdata,
            processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(response){
				if(response.success == 1){
//                    $('#mdl-trackingnumber').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-trackingnumber").trigger('reset');
					
					alert("Pickup Request is successful!");
					$('#tracking_number').val('');
			        $('#date_stamp').val('');
			        $('#size').val('');
			        $('#weight').val('');
			        $('#no_of_pieces').val('');
			        $('#parcel_type').val('');
			        $('#content_description').val('');
			        $('#sender_id').val('');
			        $('#receiver_id').val('');
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

  	$(document).on("click", "#btn-cancel", function(e){
        $('#tracking_number').val('');
        $('#date_stamp').val('');
        $('#size').val('');
        $('#weight').val('');
        $('#no_of_pieces').val('');
        $('#parcel_type').val('');
        $('#content_description').val('');
        $('#sender_id').val('');
        $('#receiver_id').val('');
        
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
    });

});
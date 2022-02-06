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
        $('#mdl-station').modal('show');
        $('.modal-title').html('Add new station');
        $("#btn-save").removeAttr('style');
        $("#btn-update").css("display","none");
        $('#edit_id').val('');
        $('#edit_index').val('');
    });

    $(document).on("click", "#btn-save", function(e){
        var username	    = $('#username').val();
        var primary_email   = $('#primary_email').val();
        var secondary_email = $('#secondary_email').val();
        var password	    = $('#password').val();
        var name	        = $('#name').val();
        var contact_number	= $('#contact_number').val();
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
        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input station name!");
			$('#name').focus();
			return;
        }
        if(!validateEmail(primary_email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid primary email address!");
			$('#primary_email').focus();
			return;
        }
        if(!validateEmail(secondary_email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid secondary email address!");
			$('#secondary_email').focus();
			return;
        }
        if(password == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input password!");
			$('#password').focus();
			return;
        }
        if(!isNumeric(contact_number)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Contact number should be numeric!");
			$('#contact_number').focus();
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
			url: "stations/create", 
			type: "POST",
			dataType: 'json',
			data: { username: username, primary_email: primary_email, secondary_email: secondary_email, password: password, name: name, contact_number: contact_number, country: country, state: state, city: city, post_code: post_code, address: address },
			success: function(response){
				if(response.success == 1){
                    $('#mdl-station').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-station").trigger('reset');
                    
                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    table.row.add([ response.id, username, name, primary_email, contact_number, country, state, city, address, action ]).draw();
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
			url: "stations/get_station", 
			type: "POST",
			dataType: 'json',
			data: { id: id },
			success: function(response){
				if(response !== false){
                    $('#mdl-station').modal('show');
                    $('.modal-title').html('Edit station');
                    $("#btn-update").removeAttr('style');
                    $("#btn-save").css("display","none");
                    $('#edit_id').val(id);
                    $('#edit_index').val(index);
                    $('#username').val(response[0].username);
                    $('#primary_email').val(response[0].primary_email);
                    $('#secondary_email').val(response[0].secondary_email);
                    $('#password').val('**********');
                    $('#name').val(response[0].name);
                    $('#contact_number').val(response[0].contact_number);
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
        var primary_email	= $('#primary_email').val();
        var secondary_email	= $('#secondary_email').val();
        var password	    = $('#password').val();
        var name	        = $('#name').val();
        var contact_number	= $('#contact_number').val();
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
        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input station name!");
			$('#name').focus();
			return;
        }
        if(!validateEmail(primary_email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid primary email address!");
			$('#primary_email').focus();
			return;
        }
        if(!validateEmail(secondary_email)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input valid secondary email address!");
			$('#secondary_email').focus();
			return;
        }
        if(password == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input password!");
			$('#password').focus();
			return;
        }
        if(!isNumeric(contact_number)){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Contact number should be numeric!");
			$('#contact_number').focus();
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
			url: "stations/update", 
			type: "POST",
			dataType: 'json',
			data: { id: id, username: username, primary_email: primary_email, secondary_email: secondary_email, password: password, name: name, contact_number: contact_number, country: country, state: state, city: city, post_code: post_code, address: address },
			success: function(response){
				if(response.success == 1){
                    $('#mdl-station').modal('hide');
                    $("#div-alert").css("display","none");
                    $("#form-station").trigger('reset');
                    
                    var table = $('#datatable').DataTable();
                    var action	= '<td>\n<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>\n<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>\n</td>';
                    table.row(index).data([ id, username, name, primary_email, contact_number, country, state, city, address, action ]).draw();
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
            content: 'Are you sure you want to delete this station?',
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
                            url: "stations/delete", 
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
});
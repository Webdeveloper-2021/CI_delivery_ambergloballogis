$(document).ready(function() {

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    $(document).on("click", "#btn-save", function(e){
		var oldpwd	    = $('#oldpwd').val();
		var newpwd	    = $('#newpwd').val();
		var confirmpwd  = $('#confirmpwd').val();

		if(oldpwd == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input old password!");
			$('#oldpwd').focus();
			return;
		}
		if(newpwd == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input new password!");
			$('#newpwd').focus();
			return;
		}
		if(newpwd != confirmpwd){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please confirm your password!");
			$('#confirmpwd').focus();
			return;
        }
        $.ajax({
			url: "profile/update_pass",
			type: "POST",
			dataType: 'json',
			data: {oldpwd: oldpwd, newpwd: newpwd},
			success: function(response){
				if(response.success == 1){
					$.alert('Successfully Updated!');
					$("#div-alert").css("display","none");
					$("#form-password").trigger('reset');
                }else if(response.success == 2){
					$("#div-alert").removeAttr('style');
					$("#alert-message").html("Update Failed!");
                }else if(response.success == 3){
					$("#div-alert").removeAttr('style');
					$("#alert-message").html("Old password is incorrect!");
					$('#oldpwd').focus();
                }else{
					$("#div-alert").removeAttr('style');
					$("#alert-message").html("No exist the user!");
				}
			}
		});
        
	});
	
	$(document).on("click", "#btn-update", function(e){
		var username	    = $('#username').val();
		var name	    	= $('#name').val();
		var email			= $('#email').val();
		var contact_number	= $('#contact_number').val();
		var vehicle_number	= $('#vehicle_number').val();
		var vehicle_type	= $('#vehicle_type').val();
		var zone			= $('#zone').val();
		var country			= $('#country').val();
		var state			= $('#state').val();
		var city			= $('#city').val();
		var post_code		= $('#post_code').val();
		var address			= $('#address').val();

		if(username == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input user name!");
			$('#username').focus();
			return;
		}
		if(name == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input name!");
			$('#name').focus();
			return;
		}
		if(!validateEmail(email)){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please confirm your email!");
			$('#email').focus();
			return;
		}
		if(contact_number == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input contact number!");
			$('#contact_number').focus();
			return;
		}
		if(vehicle_number == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input vehicle number!");
			$('#vehicle_number').focus();
			return;
		}
		if(vehicle_type == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input vehicle type!");
			$('#vehicle_type').focus();
			return;
		}
		if(zone == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input zone!");
			$('#zone').focus();
			return;
		}
		if(country == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input country!");
			$('#country').focus();
			return;
		}
		if(state == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input state!");
			$('#state').focus();
			return;
		}
		if(city == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input city!");
			$('#city').focus();
			return;
		}
		if(post_code == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input post_code!");
			$('#post_code').focus();
			return;
		}
		if(address == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input address!");
			$('#address').focus();
			return;
		}
        $.ajax({
			url: "profile/update_profile",
			type: "POST",
			dataType: 'json',
			data: {username: username, name: name, email: email, contact_number: contact_number, vehicle_number: vehicle_number, vehicle_type: vehicle_type, zone: zone, country: country, state: state, city: city, post_code: post_code, address: address},
			success: function(response){
				if(response === true){
					$.alert('Successfully Updated!');
					$("#div-alert1").css("display","none");
                }else{
					$("#div-alert1").removeAttr('style');
					$("#alert-message1").html("Update Failed!");
                }
			}
		});
        
    });
});
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
		var name	    = $('#name').val();
		var email  = $('#email').val();

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
        $.ajax({
			url: "profile/update_profile",
			type: "POST",
			dataType: 'json',
			data: {username: username, name: name, email: email},
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
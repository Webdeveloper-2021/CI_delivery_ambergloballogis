$(document).ready(function() {
	
	$('#form-import1').on('submit', function(event){
		event.preventDefault();
		if($('#file1').val() == ''){
			$("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please select excel file!");
		}else{
			$.ajax({
				url:"uploadexcel/import1",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					
					$('#file1').val('');
					if(data === false){
						$("#div-alert1").removeAttr('style');
			        	$("#alert-messag1e").html("Some errors happens! Please try again!");
					}else{
						$.alert('Successfully Imported!');
						$("#div-alert1").css("display","none");
					}
				}
			});
		}
	});

	$('#form-import').on('submit', function(event){
		event.preventDefault();
		if($('#file').val() == ''){
			$("#div-alert").removeAttr('style');
			$("#alert-message").html("Please select excel file!");
		}else{
			$.ajax({
				url:"uploadexcel/import",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					
					$('#file').val('');
					if(data === false){
						$("#div-alert").removeAttr('style');
			        	$("#alert-message").html("Some errors happens! Please try again!");
					}else{
						$.alert('Successfully Imported!');
						$("#div-alert").css("display","none");
					}
				}
			});
		}
	});
});
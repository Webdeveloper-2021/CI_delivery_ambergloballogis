$(document).ready(function() {

    $(document).on("click", "#btn-save", function(e){
        e.preventDefault();
        var formData = $('#form-precedence').serialize();

        $.ajax({
			url: "precedence/save", 
			type: "POST",
			dataType: 'json',
			data: formData,
			success: function(response){
				if(response === true){
                    $.alert('Successfully Updated!');
                }else{
                    $.alert('Some errors happened! Please try again!');
				}
			}
		});
        
    });
});
$(document).ready(function() {
	$(document).on("click", "#btn-search", function(e){
		e.preventDefault();
		var tracking_number = $('#tracking_number').val();
		if(tracking_number == ''){
            alert('Please input tracking number!');
			$('#tracking_number').focus();
			return;
		}
		location.href="tracking?tracking_number="+tracking_number;
	});

});
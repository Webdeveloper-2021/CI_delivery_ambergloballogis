$(document).ready(function() {
    $(document).on("click", "#btn-generate", function(e){
        var report_type = $('#report_type').val();
        var custom_ranges = $('#custom-ranges').val();
        var custom_ranges = $('#custom-ranges').val();
        console.log(custom_ranges);
        if(report_type == ''){
            $.alert('Please select report type!');
			$('#report_type').focus();
			return;
        }

        location.href = 'dashboard/output?report_type='+report_type+'&custom_ranges='+custom_ranges;
        
    });
   
});
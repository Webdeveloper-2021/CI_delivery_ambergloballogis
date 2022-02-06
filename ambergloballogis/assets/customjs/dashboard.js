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

    $(document).on("click", "#btn-save", function(e){
        var editor = $('#editor').val();
        $.ajax({
			url: "dashboard/update_board", 
			type: "POST",
			dataType: 'json',
			data: { editor: editor },
			success: function(response){
				if(response.success == 1){
                    $.alert('Successfully saved!');
                    $('#div-editor').empty();
                    $('#btn-save').css('display', 'none');
                    $('#board').removeAttr('style');
                    $('#board').html(editor);
                    $('#btn-edit').removeAttr('style');
				}else{
                    $.alert('Some errors happened! Please try again!');
				}
			}
		});
        
    });

    $(document).on("click", "#btn-edit", function(e){
        $('#board').css('display', 'none');
        $('#btn-edit').css('display', 'none');
        $('#btn-save').removeAttr('style');
        $.ajax({
			url: "dashboard/get_board",
			type: "POST",
			dataType: 'json',
			success: function(response){
                var html = '<textarea id="editor" name="editor">'+response+'</textarea>';
                $('#div-editor').html(html);
                var editor = new Jodit('#editor', {});
			}
		});
        
    });
   
});
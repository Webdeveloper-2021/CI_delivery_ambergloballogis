$(document).ready(function() {
    var _self;
    $(document).on("click", "#btn-new", function(e){
        $('#mdl-station').modal('show');
        $('.modal-title').html('Add new station');
        $("#btn-save").removeAttr('style');
        $("#btn-update").css("display","none");
        $('#edit_id').val('');
        $('#edit_index').val('');
    });

    $(document).on("click", "#btn-save", function(e){
        var name	    = $('#name').val();

        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input status name!");
			$('#name').focus();
			return;
        }

        $.ajax({
			url: "trackingstatus/create", 
			type: "POST",
			dataType: 'json',
			data: { name: name },
			success: function(response){
				if(response.success == 1){
                    $("#div-alert").css("display","none");
                    $("#form-status").trigger('reset');
                    
                    var html = '';
                    html += '<tr data-id="'+response.id+'">';
                    html += '   <td><span class="font-semibold">'+response.id+'</span></td>';
                    html += '   <td><span class="font-semibold">'+name+'</span></td>';
                    html += '   <td><span class="font-semibold"></span></td>';
                    html += '   <td class="text-center">';
                    html += '       <button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>';
                    html += '       <button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>';
                    html += '   </td>';
                    html += '</tr>';

                    $('#list-status').prepend(html);
                }else if(response.success == 0){
					$("#div-alert").removeAttr('style');
			        $("#alert-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert").removeAttr('style');
                    $("#alert-message").html("Duplicated status name!");
                    $('#name').focus();
				}
			}
		});
        
    });

    $(document).on("click", ".remove-row", function(e){
        var id = $(this).closest('tr').attr('data-id');
        var station_name = $(this).closest('tr').find('td:eq(0)').text();
        var _self = $(this);
        $.alert({
            title: 'Are you sure?',
            content: 'Are you sure you want to delete this tracking status?',
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
                            url: "trackingstatus/delete", 
                            type: "POST",
                            dataType: 'json',
                            data: { id: id },
                            success: function(response){
                                if(response === true){
                                    _self.closest('tr').remove();
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

    $(document).on("click", ".edit-row", function(e){
        _self = $(this);
        var id = $(this).closest('tr').attr('data-id');
        var name = $(this).closest('tr').find('td:eq(1)').text();
        $('#mdl-trackingstatus').modal('show');
        $('#edit_id').val(id);
        $('#e_name').val(name);
    });

    $(document).on("click", "#btn-update", function(e){
        var name    = $('#e_name').val();
        var id	    = $('#edit_id').val();

        if(name == ''){
            $("#div-alert1").removeAttr('style');
			$("#alert-message1").html("Please input status name!");
			$('#e_name').focus();
			return;
        }

        $.ajax({
			url: "trackingstatus/update", 
			type: "POST",
			dataType: 'json',
			data: { id: id, name: name },
			success: function(response){
				if(response.success == 1){
                    $("#div-alert1").css("display","none");
                    $("#form-status1").trigger('reset');
                    $('#mdl-trackingstatus').modal('hide');
                    _self.closest('tr').find('td:eq(1)').html(name);
                }else if(response.success == 0){
					$("#div-alert1").removeAttr('style');
			        $("#alert-message1").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert1").removeAttr('style');
                    $("#alert-message1").html("Duplicated status name!");
                    $('#e_name').focus();
				}
			}
		});
        
    });
});
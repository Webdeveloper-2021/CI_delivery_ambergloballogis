$(document).ready(function() {
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
        var name	    = $('#name').val();
        var station_id  = $('#station_id').val();
        var _self       = $(this);

        if(name == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please input station name!");
			$('#name').focus();
			return;
        }
        if(station_id == ''){
            $("#div-alert").removeAttr('style');
			$("#alert-message").html("Please select station name!");
			$('#station_id').focus();
			return;
        }

        $.ajax({
			url: "prefixset/create", 
			type: "POST",
			dataType: 'json',
			data: { name: name, station_id: station_id },
			success: function(response){
				if(response.success == 1){
                    $("#div-alert").css("display","none");
                    $("#form-prefixset").trigger('reset');
                    
                    var html = '';
                    $.each(response.data, function(index, value){
                        html += '<tr data-id="'+value.id+'">';
                        html += '<td><span class="font-semibold">'+value.station_name+'</span></td>';
                        
                        if(value.prefix_name === null){
                            html += '<td><span class="font-semibold"></span></td>';
                            html += '<td class="text-center"></td>';
                        }else{
                            html += '<td><span class="font-semibold">'+value.prefix_name+'</span></td>';
                            html += '<td class="text-center"><button class="btn btn-danger remove-row" type="button">Delete</button></td>';
                        }
                        html += '</tr>';
                    });

                    $('#list-prefixset').empty();
                    $('#list-prefixset').append(html);
                    $('#station_id option[value='+station_id+']').remove();
                }else if(response.success == 0){
					$("#div-alert").removeAttr('style');
			        $("#alert-message").html("Some errors happens! Please try again!");
				}else{
                    $("#div-alert").removeAttr('style');
                    $("#alert-message").html("Duplicated prefix set name!");
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
            content: 'Are you sure you want to delete this prefix?',
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
                            url: "prefixset/delete", 
                            type: "POST",
                            dataType: 'json',
                            data: { id: id },
                            success: function(response){
                                if(response === true){
                                    _self.closest('tr').find('td:eq(1)').text('');
                                    _self.closest('tr').find('td:eq(2)').empty();
                                    var html = '<option value="'+id+'">'+station_name+'</option>';
                                    $('#station_id').append(html);
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
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
    
    var base_url = $('#base_url').val();

    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var modalImg = document.getElementById("img01");
    $(document).on("click", ".btn-view-image", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var id		= data[0];

        $.ajax({
			url: "drivers/get_deliveryrequest", 
			type: "POST",
			dataType: 'json',
			data: { id: id },
			success: function(response){
				modal.style.display = "block";
                modalImg.src = base_url+'uploads/delivery/'+response;
			}
		});
    });

    // When the user clicks on <span> (x), close the modal
    $(document).on("click", ".close1", function(e){
        modal.style.display = "none";
    });

    $(document).on("click", ".confirm-row", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        var id		= data[0];

        $.ajax({
			url: "drivers/update_status", 
			type: "POST",
			dataType: 'json',
			data: { id: id, status: 'confirm' },
			success: function(response){
				if(response === true){
                    var action	= '<td>\n<button class="btn btn-danger btn-sm mb-2 mr-3 reject-row" type="button">Reject</button>\n</td>';
                    table.cell({row: index, column: 5}).data('Confirmed');
                    table.cell({row: index, column: 8}).data(action);
                    $('#mdl-success').modal('show');
                    $('.custom-modal__body-desc').html('New Tracking status created successfully!');
                }else{
                    $('.custom-modal__body-desc').html('Some errors happened! Please try again.');
                    $('#mdl-error').modal('show');
                }
			}
		});
        
    });

    $(document).on("click", ".reject-row", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        var id		= data[0];

        $.ajax({
			url: "drivers/update_status", 
			type: "POST",
			dataType: 'json',
			data: { id: id, status: 'reject' },
			success: function(response){
				if(response === true){
                    var action	= '<td>\n<button class="btn btn-info btn-sm mb-2 mr-3 confirm-row" type="button">Confirm</button>\n</td>';
                    table.cell({row: index, column: 5}).data('Rejected');
                    table.cell({row: index, column: 8}).data(action);
                    $('#mdl-success').modal('show');
                    $('.custom-modal__body-desc').html('Requested Info rejected.');
                }else{
                    $('#mdl-error').modal('show');
                    $('.custom-modal__body-desc').html('Some errors happened! Please try again.');
                }
			}
		});
        
    });
        
});
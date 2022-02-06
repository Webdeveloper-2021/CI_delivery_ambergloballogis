$(document).ready(function() {
    $.fn.dataTable.moment( 'DD MMM YYYY' );
    var table = $('#datatable').DataTable({
        lengthChange: false,
        buttons: [
          'print', 'excel', 'pdf', 'colvis'
        ],
        select: true,
        //lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "All"]],
        
        order: [],
      
    });  
    
    table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
    
    function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
    }

    function isNumeric(value) {
        return /^-?\d+$/.test(value);
    }

    var base_url = $('#base_url').val();


    // When the user clicks on <span> (x), close the modal

    $(document).on("click", ".close1", function(e){
        modal.style.display = "none";
    });

    $(document).on("click", ".btn-remove", function(e){
        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        //var id		= data[0];
        var title		= data[1];
        
        var url = path + "customer/Notifications/delete_notice_track";

        $.alert({
            title: 'Are you sure?',
            content: 'Are you sure you want to delete this notification of tracking number?',
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
                            url: url, 
                            async:false,
                            type: "POST",
                            dataType: 'json',
                            data: { title: title },
                            success: function(response){
                                if(response === true){
                                    var table = $('#datatable').DataTable();
                                    table.row(index).remove().draw();
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


    $(document).on("click", ".btn-view", function(e){

        var table = $('#datatable').DataTable();
        var $row = $(this).closest( 'tr' );
        var data	= table.row($row).data();
        var index	= table.row($row).index();
        //var id		= data[0];
 		var title		= data[1];
        
        var url = path + "customer/Notifications/getNoticeByTitle";

        $.ajax({
			url: url, 
			type: "POST",
			dataType: 'json',
			data: { title: title},
			success: function(response){
				if(response !== false){
					
					var data = response.arr_data;
                    /*$('#mdl-detail').modal('show');

                    $('#title').html(data['title']);
                    $('#content').html(data['content']);
                    $('#track_num_id').html(data['track_num_id']);
                    $('#datetime').html(data['created_at']);*/
                
        	$("#pick_title").html(data['title']);
	      	
			$('#pick_name').html(data['sender_name']);
			$('#pick_email').html(data['sender_email']);
			$('#pick_contact_num').html(data['sender_contact_num']);
			$('#pick_up_address_type').html(data['sender_address_type']);
			$('#pick_up_office').html(data['sender_office']);
			$('#pick_up_address').html(data['sender_address']);
			$('#pick_up_post').html(data['sender_postcode']);
			$('#pick_up_city').html(data['sender_city']);
			$('#pick_up_state').html(data['sender_state']);
			$('#pick_up_country').html(data['sender_country']);
			
			$('#pick_rec_name').html(data['receiver_name']);
			$('#pick_rec_company').html(data['receiver_company']);
			$('#pick_deliver_address').html(data['receiver_address']);
			$('#pick_deliver_post').html(data['receiver_postcode']);
			$('#pick_deliver_city').html(data['receiver_city']);
			$('#pick_deliver_state').html(data['receiver_state']);
			$('#pick_deliver_country').html(data['receiver_country']);
			
			$('#pick_parcel').html(data['parcel_type']);
			$('#pick_content').html(data['content_description']);
			
			
			$('#mdl-pickup').modal('show');


                 	
                }
			}
		});      

    });


});
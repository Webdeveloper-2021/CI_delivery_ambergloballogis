<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Notifications</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		
		
		<div class="row">
			<!--<div class="col-lg-12">-->
			<div class="col-lg-12">
				<div class="m-datatable">
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Content</th>
								<th>Datetime</th>
								<th>Read status</th>            
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i = 0;
								foreach($notice_tracks as $notice_track) {
									$i++;
							?>
							<tr>
								<td width="5%"><?php echo $i; ?></td>
								<td><?php echo $notice_track['title']; ?></td>
								<td><?php echo $notice_track['content']; ?></td>
								<td><?php echo $notice_track['created_at']; ?></td>	
								 <td>
								 	<?php $read_status=($notice_track['read_status'] > 0) ? 'checked':'';?>
                					<input type="checkbox" <?php echo $read_status;?> disabled></a>
            					</td>							
								<td>
									<button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>
									<button class="btn btn-danger mb-2 mr-1 btn-remove" type="button"><span class="btn-icon ua-icon-trash"></button>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="mdl-detail" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h1 class="modal-title" id="title"></h1>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body" style="line-space: 1rem; font-size:1.2rem;">
				<div class="row">
					<div class="col-md-12" id="content"></div>
				</div>
				  
				<div class="row" style="padding-top: 1.5rem;">
					<div class="col-md-4">Tracking Number:</div>
					<div class="col-md-8" id="track_num_id"></div>
				</div>
				<div class="row">
					<div class="col-md-4">Received at:</div>
					<div class="col-md-8" id="datetime"></div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	var path = '<?php echo base_url();?>';
	
</script>

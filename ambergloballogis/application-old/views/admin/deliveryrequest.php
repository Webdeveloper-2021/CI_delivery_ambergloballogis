<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Drivers</h2>
				<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="m-datatable">
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Driver Name</th>
								<th>Tracking Number</th>
								<th>Status</th>
								<th>Date</th>
								<th>Delivery Status</th>
								<th>Image</th>
								<th>Remark</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($deliveryrequests as $deliveryrequest) {
								if($deliveryrequest->deliver_status == 1){
									$deliver_status = 'Pending';
								}elseif($deliveryrequest->deliver_status == 2){
									$deliver_status = 'Confirmed';
								}else{
									$deliver_status = 'Rejected';
								}
							?>
							<tr>
								<td><?php echo $deliveryrequest->id; ?></td>
								<td><?php echo $deliveryrequest->driver_name; ?></td>
								<td><?php echo $deliveryrequest->tracking_number; ?></td>
								<td><?php echo $deliveryrequest->status_name; ?></td>
								<td><?php echo date('d M Y', $deliveryrequest->date_stamp); ?></td>
								<td><?php echo $deliver_status; ?></td>
								<td>
								<?php if(is_null($deliveryrequest->image_path) || $deliveryrequest->image_path == ''){ ?>
									<button class="btn btn-danger" type="button">No Image</button>
								<?php }else{ ?>
									<button class="btn btn-info btn-view-image" type="button">View Image</button>
								<?php } ?>
								</td>
								<td><?php echo $deliveryrequest->remark; ?></td>
								<td>
									<?php if($deliveryrequest->deliver_status == 1) { ?>
										<button class="btn btn-info btn-sm mb-2 mr-3 confirm-row" type="button">Confirm</button>
										<button class="btn btn-danger btn-sm mb-2 mr-3 reject-row" type="button">Reject</button>
									<?php }elseif($deliveryrequest->deliver_status == 2) { ?>
										<button class="btn btn-danger btn-sm mb-2 mr-3 reject-row" type="button">Reject</button>
									<?php }elseif($deliveryrequest->deliver_status == 3) { ?>
										<button class="btn btn-info btn-sm mb-2 mr-3 confirm-row" type="button">Confirm</button>
									<?php }?>
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

<div id="mdl-success" class="modal fade custom-modal custom-modal-success">
	<div class="modal-dialog" role="document">
		<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true" class="ua-icon-modal-close"></span>
		</button>
		<div class="modal-content">
			<div class="modal-header custom-modal__image">
				<img src="<?php echo base_url(); ?>assets/img/modal/2.png" alt="" class="">
			</div>
			<div class="modal-body custom-modal__body">
				<h4 class="custom-modal__body-heading">Success!</h4>
				<div class="custom-modal__body-desc"></div>
			</div>
			<div class="modal-footer">
				<div class="custom-modal__buttons">
					<button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="mdl-error" class="modal fade custom-modal custom-modal-error">
	<div class="modal-dialog" role="document">
		<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true" class="ua-icon-modal-close"></span>
		</button>
		<div class="modal-content">
			<div class="modal-header custom-modal__image">
				<img src="<?php echo base_url(); ?>assets/img/modal/3.png" alt="" class="">
			</div>
			<div class="modal-body custom-modal__body">
				<h4 class="custom-modal__body-heading">Oh snap!</h4>
				<div class="custom-modal__body-desc">Some errors happened! Please try again.</div>
			</div>
			<div class="modal-footer">
				<div class="custom-modal__buttons">
					<button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal mdl">
	<span class="close1">&times;</span>
	<img class="mdl-content" id="img01">
</div>
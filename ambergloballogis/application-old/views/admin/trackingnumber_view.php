<style>
	img {
		max-width: 100%;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Number Status View</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<h3>Tracking Number: <?php echo $tracking_number; ?></h3>
		<div class="form-group row">
			<button id="btn-new" class="btn btn-info mb-2 ml-3" type="button">Add New Status</button>
			<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			<input type="hidden" id="tracking_number_id" value="<?php echo $tracking_number_id; ?>">
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="main-container table-container table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Status</th>
								<th>Date Stamp</th>
								<th>Remark</th>
								<th>Location</th>
								<th>Image</th>
								<th>Updated</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="status_list">
							<?php foreach($trackings as $key => $tracking){ ?>
							<tr>
        						<td><?php echo $tracking['status_name']; ?></td>
        						<td><?php echo $tracking['date_stamp']; ?></td>
								<td class="remark-content"><?php echo $tracking['remark']; ?></td>
								<td><?php echo $tracking['location']; ?></td>
        						<?php if(is_null($tracking['image_path']) || $tracking['image_path'] == ''){ ?>
        							<td><button class="btn btn-danger" type="button">No Image</button></td>
       							<?php }else{ ?>
      								<td><button class="btn btn-info btn-view-image" type="button">View Image</button></td>
        						<?php } ?>
								<td><?php echo $tracking['creator_name']; ?></td>
        						<td>
        							<input type="hidden" class="statusid" value="<?php echo $tracking['id']; ?>">
        							<input type="hidden" class="image_path" value="<?php echo $tracking['image_path']; ?>">
       								<button class="btn btn-purple mb-2 mr-1 btn-edit" type="button"><span class="btn-icon ua-icon-pencil"></button>
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

<div id="mdl-trackingstatus" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title">Add new Tracking Status</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-trackingstatus">
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="status_id">Status</label>
										<select id="status_id" name="status_id" class="form-control">
											<option></option>
											<?php foreach($statuses as $status) { ?>
											<option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="date_stamp">Date</label>
										<input type="text" class="flatpickr form-control" name="date_stamp" id="date_stamp" placeholder="Enter Date">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="location">Location</label>
										<input type="text" class="form-control" name="location" id="location" placeholder="Enter Location">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="image_path">Select Image</label>
										<input type="file" class="form-control" accept=".jpg, .jpeg" name="image_path" id="image_path">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="remark" class="col-lg-12">Remark</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<input type="hidden" id="edit_id" value="">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-save">Save</button>
				<button class="btn btn-info" type="button" id="btn-update">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal mdl">
	<span class="close1">&times;</span>
	<img class="mdl-content" id="img01">
</div>
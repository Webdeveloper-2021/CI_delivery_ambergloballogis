<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Status</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-lg-12">
				<div class="widget">
					<div class="widget-controls__header">
						<h2>Add Tracking Status</h2>
					</div>
					<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
						<span class="alert-icon ua-icon-info"></span>
						<strong id="alert-message"></strong>
						<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
					</div>
					<div>
						<form id="form-status">
							<div class="form-group">
								<label for="name">Tracking Status Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter status name">
							</div>
							<div class="form-group">
								<button class="btn btn-info" type="button" id="btn-save">Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__header">
						<div>
							<span class="widget-controls__header-icon ua-icon-wallet"></span> Tracking Status List
						</div>
					</div>
					<div class="widget-controls__content" style="height: auto;">
						<table class="table table-no-border table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Status Name</th>
									<th>Status Precedence</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody id="list-status">
								<?php foreach($statuses as $status) { ?>
								<tr data-id="<?php echo $status->id; ?>">
									<td><span class="font-semibold"><?php echo $status->id; ?></span></td>
									<td><span class="font-semibold"><?php echo $status->name; ?></span></td>
									<td><span class="font-semibold"><?php echo $status->precedence; ?></span></td>
									<td class="text-center">
										<button class="btn btn-purple mb-2 mr-1 edit-row" type="button"><span class="btn-icon ua-icon-pencil"></button>
										<button class="btn btn-danger mb-2 mr-1 remove-row" type="button"><span class="btn-icon ua-icon-trash"></button>
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
</div>

<div id="mdl-trackingstatus" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title">Edit Tracking Status</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-status1">
							<div class="alert alert-danger" role="alert" id="div-alert1" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message1"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="form-group">
								<label for="e_name">Tracking Status Name</label>
								<input type="text" class="form-control" name="e_name" id="e_name">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<input type="hidden" id="edit_id" value="">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-update">Update</button>
			</div>
		</div>
	</div>
</div>
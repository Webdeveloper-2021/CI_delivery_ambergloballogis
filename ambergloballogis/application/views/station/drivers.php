<style>
	img {
		max-width: 100%;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Drivers</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="form-group row">
			<button id="btn-new" class="btn btn-info mb-2 ml-3" type="button">Add New</button>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="m-datatable">
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Driver<br>Name</th>
								<th>Email</th>
								<th>Contact<br>Number</th>
								<th>Vehicle<br>Number</th>
								<th>Vehicle<br>Type</th>
								<th>Zone</th>
								<th>Country</th>
								<th>State</th>
								<th>City</th>
								<th>Address</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($drivers as $driver) {
								if($driver->vehicle_type == '1'){
									$vehicle_type = 'Lorry/Truck';
								}elseif($driver->vehicle_type == '2'){
									$vehicle_type = 'Motorcycle';
								}else{
									$vehicle_type = '';
								}
							?>
							<tr>
								<td><?php echo $driver->id; ?></td>
								<td><?php echo $driver->username; ?></td>
								<td><?php echo $driver->email; ?></td>
								<td><?php echo $driver->contact_number; ?></td>
								<td><?php echo $driver->vehicle_number; ?></td>
								<td><?php echo $vehicle_type; ?></td>
								<td><?php echo $driver->zone; ?></td>
								<td><?php echo $driver->country; ?></td>
								<td><?php echo $driver->state; ?></td>
								<td><?php echo $driver->city; ?></td>
								<td><?php echo $driver->address; ?></td>
								<td>
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

<div id="mdl-driver" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title"></h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-driver">
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" name="username" id="username" placeholder="Enter driver's name">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="email">Email address</label>
										<input type="email" class="form-control" name="email" id="email" placeholder="Enter driver's email">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" class="form-control" name="password" id="password" placeholder="Password" required title="6 characters minimum">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control" name="name" id="name" placeholder="Enter driver's name">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="contact_number">Contact number</label>
										<input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter driver's contact number">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="zone">Zone</label>
										<input type="text" class="form-control" name="zone" id="zone" placeholder="Enter zone name">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="vehicle_number">Vehicle Number</label>
										<input type="text" class="form-control" name="vehicle_number" id="vehicle_number" placeholder="Enter vehicle number">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="vehicle_type">Vehicle Type</label>
										<select class="form-control" name="vehicle_type" id="vehicle_type" data-placeholder="Select Vehicle Type">
											<option value=""></option>
											<option value="1">Lorry/Truck</option>
											<option value="2">Motorcycle</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="image_path">Select Driver's Image</label>
										<input type="file" class="form-control" accept=".jpg, .jpeg" name="image_path" id="image_path">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="country">Country</label>
										<input type="text" class="form-control" name="country" id="country" placeholder="country">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="state">State</label>
										<input type="text" class="form-control" name="state" id="state" placeholder="state">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="city">City</label>
										<input type="text" class="form-control" name="city" id="city" placeholder="city">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="post_code">Post code</label>
										<input type="text" class="form-control" name="post_code" id="post_code" placeholder="postal code">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="address">Address</label>
										<input type="text" class="form-control" name="address" id="address" placeholder="address">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<input type="hidden" id="edit_id" value="">
				<input type="hidden" id="edit_index" value="">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-save">Save</button>
				<button class="btn btn-info" type="button" id="btn-update">Update</button>
			</div>
		</div>
	</div>
</div>
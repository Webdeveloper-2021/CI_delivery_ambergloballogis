<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Numbers</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="form-group row">
			<!--<button id="btn-new" class="btn btn-info mb-2 ml-3" type="button">Add New</button>
			<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">-->
			<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			<!--<div class="form-group col-8">
                <button id="btn-new" class="btn btn-info mb-2 ml-3" type="button">Add New</button>
				<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
            </div>-->
             <style>
				.btn:hover {
				    color: #fff
				}
				.input-text {
					height: auto;
				}
				.input-text:focus {
					height: auto;
				    box-shadow: 0px 0px 0px;
				    border-color: #f8c146;
				    outline: 0px
				}
				.form-control {
				    border: 1px solid #f8c146
				}
		  	</style>		 
	        <div class="col-md-4">
	            <div class="input-group mb-3"> 
	            	<input type="text" class="form-control input-text" name="search_text" id="search_text" placeholder="Search ...">
	                <div class="input-group-append"> 
	                	<button class="btn btn-outline-warning btn-lg" id="btn_search" type="button"><i class="fa fa-search"></i></button> 
	                </div>
	            </div>
	        </div>
		</div>
		<div class="row">
			<!--<div class="col-lg-12">-->
			<div class="col-lg-12" id="ajax_table">
				<div class="m-datatable">
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Tracking Number</th>
								<th>Sender Station</th>
								<th>Receiver Station</th>
								<th>Status</th>
								<th>Date</th>
								<th>Remark</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($trackingnumbers as $trackingnumber) {
							?>
							<tr>
								<td><?php echo $trackingnumber->id; ?></td>
								<td><?php echo $trackingnumber->tracking_number; ?></td>
								<td><?php echo $trackingnumber->sender_station; ?></td>
								<td><?php echo $trackingnumber->receiver_station; ?></td>
								<td><?php echo $trackingnumber->status_name; ?></td>
								
								<td><?php date_default_timezone_set('Asia/Kuala_Lumpur'); echo date('d M Y', $trackingnumber->date_stamp); ?></td>
								
								<td class="remark-content"><?php echo $trackingnumber->remark; ?></td>
								<td>
								<?php if(!is_null($trackingnumber->image_path) && $trackingnumber->image_path != '') { ?>
									<button class="btn btn-info btn-view-image" type="button">View Image</button>
								<?php } else {?>
									<button class="btn btn-danger" type="button">No Image</button>
								<?php }?>
								</td>
								<td>
									
									<button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>
									<button class="btn btn-warning mb-2 mr-1 btn-pdf" type="button" title="A4 format"><span class="btn-icon ua-icon-pages"></button>
									<button class="btn btn-success mb-2 mr-1 btn-pdf1" type="button" title="sticker format"><span class="btn-icon ua-icon-pages"></button>
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

<div id="mdl-trackingnumber" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header has-border">
				<h5 class="modal-title">Add new Tracking Number</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-trackingnumber">
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="docket">Docket#</label>
										<input type="text" class="form-control" name="docket" id="docket" placeholder="Enter Docket#">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="sender_station">Sender Station</label>
										<select id="sender_station" name="sender_station" class="form-control">
											<option selected><?php echo $name; ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="tracking_number">Tracking Number</label>
										<div class="input-group mb-3"> 
							            	<input type="text" class="form-control input-text" name="tracking_number" id="tracking_number" placeholder="Tracking number">
							                <div class="input-group-append"> 
							                	<button class="btn btn-outline-warning btn-lg" id="btn_edit_track_num" type="button"><i class="fa fa-edit"></i></button> 
							                </div>
							            </div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="receiver_station">Receiver Station</label>
										<select id="receiver_station" name="receiver_station" class="form-control">
											<option></option>
											<?php foreach($stations as $station) { ?>
											<option value="<?php echo $station->id; ?>"><?php echo $station->name; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="status_id">Status</label>
										<select id="status_id" name="status_id" class="form-control">
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
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="size">Size</label>
										<input type="text" class="form-control" name="size" id="size" placeholder="Enter Product Size">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="weight">Weight</label>
										<input type="text" class="form-control" name="weight" id="weight" placeholder="Enter Product Weight">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="no_of_pieces">No. of Pieces</label>
										<input type="text" class="form-control" name="no_of_pieces" id="no_of_pieces" placeholder="Enter No of Pieces">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="parcel_type">Parcel Type</label>
										<select id="parcel_type" name="parcel_type" class="form-control">
											<option value="1">Parcel</option>
                                            <option value="2">Document</option>
                                            <option value="3">Heavy Shipment</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="special_notes" class="col-lg-12">Special Notes</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="special_notes" id="special_notes" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="content_description" class="col-lg-12">Content Description</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="content_description" id="content_description" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<button class="btn btn-info" type="button" id="btn-new-customer">Add a new customer</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="sender_id">Sender</label>
										<select id="sender_id" name="sender_id" class="form-control">
											<option></option>
											<?php foreach($customers as $customer) { ?>
											<option value="<?php echo $customer->id; ?>"><?php echo $customer->name.' - '.$customer->email; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="receiver_id">Receiver</label>
										<select id="receiver_id" name="receiver_id" class="form-control">
											<option></option>
											<?php foreach($customers as $customer) { ?>
											<option value="<?php echo $customer->id; ?>"><?php echo $customer->name.' - '.$customer->email; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-save">Save</button>
			</div>
		</div>
	</div>
</div>

<div id="mdl-edit-trackingnumber" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title">Edit Tracking Number</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-edit-trackingnumber">
							<div class="alert alert-danger" role="alert" id="div-edit-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-edit-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_docket">Docket#</label>
										<input type="text" class="form-control" name="e_docket" id="e_docket" placeholder="Enter Docket#">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_sender_station">Sender Station</label>
										<select id="e_sender_station" name="e_sender_station" class="form-control">
											<!--<option selected><?php echo $name; ?></option>-->
											<option></option>
											<?php foreach($stations as $station) { ?>
											<option value="<?php echo $station->id; ?>"><?php echo $station->name; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_tracking_number">Tracking Number</label>
										<input type="text" class="form-control" name="e_tracking_number" id="e_tracking_number" placeholder="Enter Tracking Number">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_receiver_station">Receiver Station</label>
										<select id="e_receiver_station" name="e_receiver_station" class="form-control">
											<option></option>
											<?php foreach($stations as $station) { ?>
											<option value="<?php echo $station->id; ?>"><?php echo $station->name; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_size">Size</label>
										<input type="text" class="form-control" name="e_size" id="e_size" placeholder="Enter Product Size">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_weight">Weight</label>
										<input type="text" class="form-control" name="e_weight" id="e_weight" placeholder="Enter Product Weight">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_no_of_pieces">No. of Pieces</label>
										<input type="text" class="form-control" name="e_no_of_pieces" id="e_no_of_pieces" placeholder="Enter No of Pieces">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_parcel_type">Parcel Type</label>
										<select id="e_parcel_type" name="e_parcel_type" class="form-control">
											<option value="1">Parcel</option>
                                            <option value="2">Document</option>
                                            <option value="3">Heavy Shipment</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="e_special_notes" class="col-lg-12">Special Notes</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="e_special_notes" id="e_special_notes" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="e_content_description" class="col-lg-12">Content Description</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="e_content_description" id="e_content_description" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_sender_id">Sender</label>
										<select id="e_sender_id" name="e_sender_id" class="form-control">
											<option></option>
											<?php foreach($customers as $customer) { ?>
											<option value="<?php echo $customer->id; ?>"><?php echo $customer->name.' - '.$customer->email; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="e_receiver_id">Receiver</label>
										<select id="e_receiver_id" name="e_receiver_id" class="form-control">
											<option></option>
											<?php foreach($customers as $customer) { ?>
											<option value="<?php echo $customer->id; ?>"><?php echo $customer->name.' - '.$customer->email; ?></option>
											<?php }?>
										</select>
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
				<button class="btn btn-info" type="button" id="btn-update">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="mdl-trackingnumberstatus" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header has-border">
				<h5 class="modal-title">Status List</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<div class="row">
							<div class="col-lg-12">
								<div class="alert action-alert action-alert--purple has-btn mt-4" role="alert">
									<span class="action-alert__message">
										Tracking Number: <span class="action-alert__action-message">343434343</span>
									</span>
									<button type="button" class="btn btn-info ml-5" id="btn-new">Add New Status</button>
									<input type="hidden" id="tracking_number_id" value="">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="main-container table-container">
									<table class="table">
										<thead>
											<tr>
												<th>Status</th>
												<th>Date Stamp</th>
												<th>Remark</th>
												<th>Image</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="status_list">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div id="mdl-trackingstatus" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title1">Add new Tracking Status</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-trackingstatus">
							<div class="alert alert-danger" role="alert" id="div-alert1" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message1"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="status_id1">Status</label>
										<select id="status_id1" name="status_id1" class="form-control">
											<option></option>
											<?php foreach($statuses as $status) { ?>
											<option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="date_stamp1">Date</label>
										<input type="text" class="flatpickr form-control" name="date_stamp1" id="date_stamp1" placeholder="Enter Date">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="image_path1">Select Image</label>
										<input type="file" class="form-control" accept=".jpg, .jpeg" name="image_path1" id="image_path1">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="remark1" class="col-lg-12">Remark</label>
										<div class="col-lg-12">
											<textarea class="form-control" name="remark1" id="remark1" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer modal-footer--center">
				<input type="hidden" id="edit_id1" value="">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-save1">Save</button>
				<button class="btn btn-info" type="button" id="btn-update1">Update</button>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal mdl">
	<span class="close1">&times;</span>
	<img class="mdl-content" id="img01">
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

<div id="mdl-image" class="modal fade custom-modal custom-modal-error">
	<div class="modal-dialog" role="document">
		<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true" class="ua-icon-modal-close"></span>
		</button>
		<div class="modal-content">
			<div class="modal-body custom-modal__body">
				<img src="" id="image_path" alt="" class="">
			</div>
			<div class="modal-footer">
				<div class="custom-modal__buttons">
					<button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
</div>



<div id="mdl-new-customer" class="modal fade custom-modal-tabs">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header has-border">
				<h5 class="modal-title">Add New Customer</h5>
				<button type="button" class="close custom-modal__close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="ua-icon-modal-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="modal-settings-notifications">
						<form id="form-customer">
							<div class="alert alert-danger" role="alert" id="div-customer-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-customer-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" name="username" id="username" placeholder="Enter user's name">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="email">Email address</label>
										<input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" pattern=".{6,}" class="form-control" name="password" id="password" placeholder="Password" required title="6 characters minimum">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control" name="name" id="name" placeholder="Enter user's name">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="contact_number">Contact number</label>
										<input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter user's contact number">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="company">Company Name</label>
										<input type="text" class="form-control" name="company" id="company" placeholder="Enter company's name">
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
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-customer-save">Save</button>
			</div>
		</div>
	</div>
</div>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Pickup Request</h2>
				<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="form-group container">
						<form id="form-trackingnumber">
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>					
	
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="tracking_number">Tracking Number</label>
										<!--<input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Enter Tracking Number">-->
									
										<div class="input-group mb-3"> 
							            	<input type="text" class="form-control input-text" name="tracking_number" id="tracking_number" readonly>
							              
							            </div>
									</div>									
								</div>
														
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="date_stamp">Date</label>
										<input type="text" class="flatpickr form-control" name="date_stamp" id="date_stamp" placeholder="Enter Date">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="size">Size</label>
										<input type="text" class="form-control" name="size" id="size" placeholder="Enter Product Size">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="weight">Weight</label>
										<input type="text" class="form-control" name="weight" id="weight" placeholder="Enter Product Weight">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="no_of_pieces">No. of Pieces</label>
										<input type="text" class="form-control" name="no_of_pieces" id="no_of_pieces" placeholder="Enter No of Pieces">
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
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
										<label for="content_description">Content Description</label>
										<textarea class="form-control" name="content_description" id="content_description" rows="3"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<button class="btn btn-info" type="button" id="btn-new-customer">Add a new customer</button><br/>
										<label style="color: grey;">Please look up the receiver in the customer list and add him(her) if he(she) doesn't exist.</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="sender_id">Sender</label>
										<input type="hidden" class="form-control" name="sender_id" id="sender_id" value='<?php echo $user_info->id;?>' readonly>
										<input type="text" class="form-control" name="sender_name" id="sender_name" value='<?php echo $user_info->name.' - '.$user_info->email;?>' readonly>
										<!--<select id="sender_id" name="sender_id" class="form-control">																			
										</select>-->
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
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
						<button class="btn btn-info" type="button" id="btn-save">Send Request</button>
						<button type="button" class="btn btn-outline-info" id="btn-cancel">Cancel</button>					
			
   		</div>
		
	</div>
</div>

<div id="myModal" class="modal mdl">
	<span class="close1">&times;</span>
	<img class="mdl-content" id="img01">
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
								<!--<div class="col-lg-6">
									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" name="username" id="username" placeholder="Enter user's name">
									</div>
								</div>-->
							    <div class="col-lg-6">
									<div class="form-group">
										<label for="email">Email address</label>
										<input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
									</div>
								</div>
							<!--</div>
							<div class="row">-->
								<!--<div class="col-lg-6">
									<div class="form-group">
										<label for="password">Password</label>
										<input type="password" pattern=".{6,}" class="form-control" name="password" id="password" placeholder="Password" required title="6 characters minimum">
									</div>
								</div>-->
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

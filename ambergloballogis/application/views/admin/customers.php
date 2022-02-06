<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div class="col-md-8, col-xs-6">
				<h2 class="page-content__header-heading">Customers</h2>
			</div>
			 <!--<div class="col-md-4, col-xs-6">
	            <div class="input-group mb-3"> 
	            	<input type="text" class="form-control input-text" name="search_customer" id="search_customer" placeholder="Search ...">
	                <div class="input-group-append"> 
	                	<button class="btn btn-outline-warning btn-lg" id="btn_search_customer" type="button"><i class="fa fa-search"></i></button> 
	                </div>
	            </div>
	        </div>-->
			<!--<div class="page-content__header-meta"></div>-->
		</div>
		<div class="form-group row">
		<!--<div class="form-group row" style="margin-bottom:-4rem;">-->
			<!--<button id="btn-new" class="btn btn-info mb-2 ml-3" type="button">Add New</button>-->
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
			.dataTables_wrapper .dt-buttons {
			 /* float:right;  
			  text-align:center;*/
			}
		  </style>		 
	        <div class="col-md-4 col-xs-6">
	            <div class="input-group mb-3"> 
	            	<input type="text" class="form-control input-text" name="search_customer" id="search_customer" placeholder="Search ...">
	                <div class="input-group-append"> 
	                	<button class="btn btn-outline-warning btn-lg" id="btn_search_customer" type="button"><i class="fa fa-search"></i></button> 
	                </div>
	            </div>
	        </div>
		</div>
		<div class="row">
			<!--<div class="col-lg-12">-->
			<div class="col-lg-12"  id="ajax_table_customer">
				<div class="m-datatable">
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Customer<br>Name</th>																
								<th>Customer<br>Username</th>
								<th>Email</th>
								<th>Contact<br>Number</th>
								<th>Country</th>
								<th>State</th>
								<th>City</th>
								<th>Postal<br>Code</th>
								<th>Address</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($customers as $customer) { ?>
							<tr>
								<td><?php echo $customer->id; ?></td>																
								<td><?php echo $customer->name; ?></td>																
								<td><?php echo $customer->username; ?></td>
								<td><?php echo $customer->email; ?></td>
								<td><?php echo $customer->contact_number; ?></td>
								<td><?php echo $customer->country; ?></td>
								<td><?php echo $customer->state; ?></td>
								<td><?php echo $customer->city; ?></td>
								<td><?php echo $customer->post_code; ?></td>
								<td><?php echo $customer->address; ?></td>
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
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
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
				<input type="hidden" id="edit_id" value="">
				<input type="hidden" id="edit_index" value="">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
				<button class="btn btn-info" type="button" id="btn-save">Save</button>
				<button class="btn btn-info" type="button" id="btn-update">Update</button>
			</div>
		</div>
	</div>
</div>
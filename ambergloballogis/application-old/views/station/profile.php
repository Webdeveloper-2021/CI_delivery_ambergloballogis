<style>
	.form-group {
		margin: 10px 20px 10px 20px;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Profile</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-lg-12">
				<div class="widget">
					<div class="widget-controls__header">
						<h2>Change Password</h2>
					</div>
					<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
						<span class="alert-icon ua-icon-info"></span>
						<strong id="alert-message"></strong>
						<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
					</div>
					<div>
						<form id="form-password">
							<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="form-group">
								<label for="oldpwd">Old Password</label>
								<input type="password" class="form-control" name="oldpwd" id="oldpwd">
							</div>
							<div class="form-group">
								<label for="newpwd">New Password</label>
								<input type="password" class="form-control" name="newpwd" id="newpwd">
							</div>
							<div class="form-group">
								<label for="confirmpwd">Confirm Password</label>
								<input type="password" class="form-control" name="confirmpwd" id="confirmpwd">
							</div>
							<div class="form-group">
								<button class="btn btn-info" type="button" id="btn-save">Change Password</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__header">
						<div>
							<span class="widget-controls__header-icon ua-icon-wallet"></span> User Profile
						</div>
					</div>
					<div class="widget-controls__content" style="height: auto;">
						<form id="form-profile">
							<div class="alert alert-danger" role="alert" id="div-alert1" style="display:none;">
								<span class="alert-icon ua-icon-info"></span>
								<strong id="alert-message1"></strong>
								<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
							</div>
							<div class="form-group row">
								<label for="username" class="col-sm-4 col-form-label">Username:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="username" name="username" value="<?php echo $userinfo[0]->username; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="col-sm-4 col-form-label">Name:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="name" name="name" value="<?php echo $userinfo[0]->name; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="primary_email" class="col-sm-4 col-form-label">Primary Email:</label>
								<div class="col-sm-8">
									<input type="email" class="form-control" id="primary_email" name="primary_email" value="<?php echo $userinfo[0]->primary_email; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="secondary_email" class="col-sm-4 col-form-label">Secondary Email:</label>
								<div class="col-sm-8">
									<input type="email" class="form-control" id="secondary_email" name="secondary_email" value="<?php echo $userinfo[0]->secondary_email; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="contact_number" class="col-sm-4 col-form-label">Contact Number:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $userinfo[0]->contact_number; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="country" class="col-sm-4 col-form-label">Country:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="country" name="country" value="<?php echo $userinfo[0]->country; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="state" class="col-sm-4 col-form-label">State:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="state" name="state" value="<?php echo $userinfo[0]->state; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="city" class="col-sm-4 col-form-label">City:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="city" name="city" value="<?php echo $userinfo[0]->city; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="post_code" class="col-sm-4 col-form-label">Post Code:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="post_code" name="post_code" value="<?php echo $userinfo[0]->post_code; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="address" class="col-sm-4 col-form-label">Address:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="address" name="address" value="<?php echo $userinfo[0]->address; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<button class="btn btn-info" type="button" id="btn-update">Update Profile</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
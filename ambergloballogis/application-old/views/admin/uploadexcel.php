<style>
	.form-group, h3 {
		margin: 20px 20px 0px 20px;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Upload Excel File</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__header">
					</div>
					<div class="widget-controls__content" style="height: auto;">
						<div class="row">
							<div class="col-lg-6">
								<h3>Add New Tracking Number</h3>
								<div class="form-group">
									<a class="btn btn-success btn-sm mb-2 mr-3" href="<?php echo base_url().'assets/download/sample_addnewtrackingnumber.xlsx'; ?>" type="button">Sample Worksheet Download</a>
								
									
									<div class="alert alert-warning" role="alert">
									<h3>Important Note</h3>
									<p>Be sure to follow the correct format with the given template sample before uploading, else the data will be ignored and won't get entered into the system.</p>
						</div>
								</div>
								<form method="post" id="form-import1" enctype="multipart/form-data">
									<div class="alert alert-danger" role="alert" id="div-alert1" style="display:none;">
										<span class="alert-icon ua-icon-info"></span>
										<strong id="alert-message1">Successfully Imported</strong>
										<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
									</div>
									<div class="form-group">
										<label for="file1">Select Excel file</label>
										<input type="file" class="form-control" accept=".xlsx, .xls" name="file1" id="file1">
									</div>
									<div class="form-group">
										<button class="btn btn-info mb-2 mr-3" type="submit" id="btn-upload1">Upload</button>
									</div>
								</form>
							</div>
							<div class="col-lg-6">
								<h3>Update Existing Tracking Status</h3>
								<div class="form-group">
									<a class="btn btn-success btn-sm mb-2 mr-3" href="<?php echo base_url().'assets/download/sample_existingtrackingstatus.xlsx'; ?>" type="button">Sample Worksheet Download</a>
									
								</div>
								
								<form method="post" id="form-import" enctype="multipart/form-data">
									<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
										<span class="alert-icon ua-icon-info"></span>
										<strong id="alert-message">Successfully Imported</strong>
										<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
									</div>
									<div class="form-group">
										<label for="file">Select Excel file</label>
										<input type="file" class="form-control" accept=".xlsx, .xls" name="file" id="file">
									</div>
									<div class="form-group">
										<button class="btn btn-info mb-2 mr-3" type="submit" id="btn-upload">Upload</button>
									</div>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.form-group, h3 {
		margin: 20px 20px 0px 20px;
	}
	.board {
		padding: 20px 20px 20px 20px;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Announcement Board</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__content" style="height: auto;">
						<div class="m-content">
							<div class="row">
								<div class="col-lg-12" id="board">
									<?php echo $board; ?>
								</div>
							</div>
							<div id="div-editor"></div>
							<div class="form-group">
								<button class="btn btn-info mb-2 mr-3" type="button" id="btn-save" style="display: none;">Save</button>
								<button class="btn btn-info mb-2 mr-3" type="button" id="btn-edit">Edit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Generate Report</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__content" style="height: auto;">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="custom-ranges">Date Custom Ranges (Month-Day-Year)</label>									
									<input id="custom-ranges" type="text" placeholder="Select Date" class="js-date-custom-ranges form-control">
								</div>
								<div class="form-group">
									<label for="report_type">Select Report Type</label>
									<select id="report_type" name="report_type" class="form-control">
										<option value="">Template List</option>
										<option value="1">Manifest Report</option>
										<option value="2">Arrived at Hub & NON-OFD / POD Report</option>
										<option value="3">Shortlanded Report(Inbound Non Arrived Hub & OFD)</option>
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-info mb-2 mr-3" type="button" id="btn-generate">Generate Report</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
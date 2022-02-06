<style>
	.form-group {
		margin: 20px 20px 0px 20px;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Status</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__header">
						<div>
							<span class="widget-controls__header-icon ua-icon-wallet"></span> Tracking Status List
						</div>
					</div>
					<div class="widget-controls__content" style="height: auto;">
						<form id="form-precedence">
							<div class="row">
								<?php foreach($statuses as $status) { ?>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="name"><?php echo $status->name; ?></label>
										<input type="number" class="form-control" name="precedence[]" value="<?php echo $status->precedence; ?>">
										<input type="hidden" name="id[]" value="<?php echo $status->id; ?>">
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="form-group row">
								<button class="btn btn-info mb-2 mr-3" type="button" id="btn-save">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
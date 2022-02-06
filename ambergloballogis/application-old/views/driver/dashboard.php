<style>
	.board {
		padding: 20px 20px 20px 20px;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="mb-4">Announcement Board</h2>
			</div>
			<div class="col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__content" style="height: auto;">
						<div class="row">
							<div class="col-lg-12 board">
								<?php echo $board; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="widget widget-table widget-controls widget-payouts widget-controls--dark">
					<div class="widget-controls__content" style="height: auto;">
						<div class="row">
							<div class="col-lg-12">
								<div class="widget widget-alpha widget-alpha--color-amaranth">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label for="tracking_number">Tracking Number</label>
												<input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Enter your tracking number here">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<button class="btn btn-info" type="button" id="btn-submit">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12" id="div-update">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
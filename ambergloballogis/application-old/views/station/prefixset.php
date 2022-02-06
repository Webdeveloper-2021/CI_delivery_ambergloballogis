<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Stations</h2>
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-lg-12">
				<div class="widget">
					<div class="widget-controls__header">
						<h2>Station Prefix Set</h2>
					</div>
					<div class="alert alert-danger" role="alert" id="div-alert" style="display:none;">
						<span class="alert-icon ua-icon-info"></span>
						<strong id="alert-message"></strong>
						<span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
					</div>
					<div>
						<form id="form-prefixset">
							<div class="form-group">
								<label for="name">Prefix Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter prefix name">
							</div>
							<div class="form-group">
								<label for="station_id">Station Name</label>
								<select class="form-control" id="station_id" data-placeholder="Select station name">
									<option></option>
									<?php foreach($stations as $station) { ?>
									<option value="<?php echo $station->id; ?>"><?php echo $station->name; ?></option>
									<?php } ?>
								</select>
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
							<span class="widget-controls__header-icon ua-icon-wallet"></span> Prefix Set List
						</div>
					</div>
					<div class="widget-controls__content" style="height: auto;">
						<table class="table table-no-border table-striped">
							<thead>
								<tr>
									<th>Station Name</th>
									<th>Prefix</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody id="list-prefixset">
								<?php foreach($prefixsets as $prefixset) { ?>
								<tr data-id="<?php echo $prefixset->id; ?>">
									<td><span class="font-semibold"><?php echo $prefixset->station_name; ?></span></td>
									<td><span class="font-semibold"><?php echo $prefixset->prefix_name; ?></span></td>
									<?php if(is_null($prefixset->prefix_name)) { ?>
										<td class="text-center"></td>
									<?php }else{ ?>
										<td class="text-center"><button class="btn btn-danger remove-row" type="button">Delete</button></td>
									<?php } ?>
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
<style>
	img {
		max-width: 100%;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Number Status View</h2>
				<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<h3>Tracking Number: <?php echo $tracking_number; ?></h3>
		<div class="row">
			<div class="col-lg-12">
				<div class="main-container table-container table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Status</th>
								<th>Date Stamp</th>
								<th>Remark</th>
								<th>Location</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody id="status_list">
							<?php foreach($trackings as $key => $tracking){ ?>
							<tr>
        						<td><?php echo $tracking['status_name']; ?></td>
        						<td><?php echo $tracking['date_stamp']; ?></td>
								<td class="remark-content"><?php echo $tracking['remark']; ?></td>
								<td><?php echo $tracking['location']; ?></td>
								<td>
									<input type="hidden" class="image_path" value="<?php echo $tracking['image_path']; ?>">
									<?php if(is_null($tracking['image_path']) || $tracking['image_path'] == ''){ ?>
										<button class="btn btn-danger" type="button">No Image</button>
									<?php }else{ ?>
										<button class="btn btn-info btn-view-image" type="button">View Image</button>
									<?php } ?>
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

<div id="myModal" class="modal mdl">
	<span class="close1">&times;</span>
	<img class="mdl-content" id="img01">
</div>
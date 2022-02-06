<div class="page-content">
	<div class="container-fluid">
		<div class="page-content__header">
			<div>
				<h2 class="page-content__header-heading">Tracking Numbers List</h2>
				<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
			</div>
			<div class="page-content__header-meta"></div>
		</div>
		<div class="row">
			<div class="col-lg-12">
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
								<th>Image Path</th>
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
								<td><?php echo date('d M Y', $trackingnumber->date_stamp); ?></td>
								<td class="remark-content"><?php echo $trackingnumber->remark; ?></td>
								<td><?php echo $trackingnumber->image_path; ?></td>
								<td>
								<?php if(!is_null($trackingnumber->image_path) && $trackingnumber->image_path != '') { ?>
									<button class="btn btn-info btn-view-image" type="button">View Image</button>
								<?php } else {?>
									<button class="btn btn-danger" type="button">No Image</button>
								<?php }?>
								</td>
								<td>
									<button class="btn btn-info mb-2 mr-1 btn-view" type="button"><span class="btn-icon ua-icon-eye"></button>
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
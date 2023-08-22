<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

<div class="row">
	<div class="col">
		<div class="card sb-card-shadow">
			<div class="card-body">
				<form id="myForm" method="post">

					<div class="row">
						<div class="col">

							<?php if ($action != null): ?>
							<input type="hidden" name="id" value="<?php echo $station['station_id'] ?>">
							<?php endif; ?>

							<select class="form-control" name="plant_id" id="plant_id" required>
								<option value="">Select Plant</option>
								<?php foreach($plants as $plant): ?>
									<option
										<?php
										if($action != null)
										{
											if ($station['plant_id'] == $plant['plant_id'])
											{
												echo "selected";
											}
											else
											{
												echo "";
											}
										}
										?>
									value="<?php echo $plant['plant_id'] ?>"><?php echo $plant["plant_name"] ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col">
							<select class="form-control" name="line_id" id="line_id" required>
								<option value="">Select Line</option>



								<?php
								if ($action != null):
									foreach ($lines as $line):
								?>
										<option value="<?php echo $line['line_id'] ?>" <?php if ($line['line_id'] == $station['line_id']){echo"selected";}else{echo"";} ?>><?php echo $line["line_name"] ?></option>
								<?php
									endforeach;
								endif;
								?>


							</select>
						</div>

					</div>

					<div class="row mt-5">
						<div class="col">
							<input type="text" class="form-control" name="station_name" value="<?php echo ($action != null) ? $station['station_name'] : ""; ?>" placeholder="Work Station Name">
						</div>
					</div>

					<div class="row mt-5">
						<div class="col">
							<input type="text" class="form-control" name="station_control_number" value="<?php echo ($action != null) ? $station['station_control_number'] : ""; ?>" placeholder="Control No.">
						</div>
						<div class="col">
							<input type="text" class="form-control" name="station_serial" value="<?php echo ($action != null) ? $station['station_serial'] : ""; ?>" placeholder="Serial no." >
						</div>
					</div>

					<div class="row mt-5">
						<div class="col">
							<input type="text" class="form-control" name="station_location" value="<?php echo ($action != null) ? $station['station_location'] : ""; ?>" placeholder="Location" >
						</div>
					</div>

					<div class="row mt-5">
						<div class="col">
							<button type="submit" id="btn" class="btn btn-submit">Save</button>
						</div>
					</div>



				</form>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card sb-card-shadow">
			<div class="card-body">
				<table style="width: 100%"  id='empTable' class='display dataTable'>
					<thead>
						<tr>
							<th>Station</th>
							<th>Control #</th>
							<th>Serial #</th>
							<th>Line</th>
							<th>Action</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
	</div>

</div>
<!-- Notification toast -->
<div class="notification-toast bottom-middle" id="notification-toast"></div>




<div id="details-modal" class="modal fade bd-example-modal-xl">
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title h4 font-weight-bolder"><span id="modal-title"></span>&nbsp; Details</h5>
			<button type="button" class="close" data-dismiss="modal">
				<i class="anticon anticon-close"></i>
			</button>
		</div>
		<div class="modal-body">
			<p>Station name: <span id="station_name"></span></p>
			<p>Station Control Number: <span id="station_control_number"></span></p>
			<p>Station Serial Number: <span id="station_serial"></span></p>
			<p>Station Location: <span id="station_location"></span></p>
			<p>Plant: <span id="station_plant"></span></p>
			<p>Line: <span id="station_line"></span></p>
		</div>
	</div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

<script>
	<?php if ($action == "update"):?>
	$(document).ready(function() {
		// Handle form submission
		$('#myForm').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>stations/update_station',
				method: 'POST',
				data: formData,
				success: function(response)
				{
					console.log(response);
					const data = JSON.parse(response);
					showToast(data.status, data.message);
					if (data.status === "error") {
						return;
					}

					$('#empTable').DataTable().ajax.reload();
				},
				error: function(error) {
					console.error(error);
					showToast("fail")
				}
			});
		});
	});

	<?php elseif($action == "delete"): ?>

	//change button text
	$('#btn').text('Delete');
	//remove class from button
	$('#btn').removeClass('btn-submit');
	//add class to button
	$('#btn').addClass('btn-delete');

	$(document).ready(function() {
		// Handle form submission
		$('#myForm').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>stations/delete_station',
				method: 'POST',
				data: formData,
				success: function(response)
				{
					console.log(response);
					const data = JSON.parse(response);

					showToast(data.status, data.message);
					if (data.status === "error") {
						return;
					}
					//wait 3 seconds before redirecting
					setTimeout(function(){
						window.location.href = '<?php echo base_url() ?>locations/lines';
					}, 1500);
				},
				error: function(error) {
					console.error(error);
					showToast("fail")
				}
			});
		});
	});

	<?php else: ?>

	$(document).ready(function() {
		// Handle form submission
		$('#myForm').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>stations/save_station',
				method: 'POST',
				data: formData,
				success: function(response)
				{
					console.log(response);
					const data = JSON.parse(response);

					showToast(data.status, data.message);
					if (data.status === "error") {
						return;
					}

					//clear form
					$('#myForm')[0].reset();
					$('#empTable').DataTable().ajax.reload();

				},
				error: function(error) {
					console.error(error);
					showToast("fail")
				}
			});
		});
	});

	<?php endif; ?>

</script>

<!-- Script -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#empTable').DataTable({
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url':'<?=base_url()?>stations/station_list'
			},
			'columns': [

				{ data: 'station_name' },
				{ data: 'station_control_number'},
				{ data: 'station_serial' },
				{ data: 'station_line_id' },
				{ data: 'actions' }
			]
		});
	});
</script>


<script>
	//dependant dropdown
	$(document).ready(function(){
		$('#plant_id').change(function(){
			var plant_id = $('#plant_id').val();
			if(plant_id != '')
			{
				$.ajax({
					url:"<?php echo base_url(); ?>locations/get_lines_by_plant_id",
					method:"POST",
					data:{plant_id:plant_id},
					success:function(data)
					{
						//parse the returned json data
						var opts = $.parseJSON(data);
						//use the returned data to fill our select box
						$('#line_id').html('<option value="">Select Line</option>');
						$.each(opts,function(i,d){
							$('#line_id').append('<option value="' + d.line_id + '">' + d.line_name + '</option>');
						});

						//$('#line_id').html(data);
					}
				});
			}
			else
			{
				$('#line_id').html('<option value="">Select Line</option>');
			}
		});
	});
</script>



<script>
	//open modal after clicking details button.
	$(document).ready(function(){
		$('#empTable').on('click', '.details', function(){

			const id = $(this).data('plant_id');

			$.ajax({
				url:"<?php echo base_url(); ?>stations/get_stations",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					console.log(data);

					//returned data format:
					//[{"station_id":"25","station_name":"BOY01","station_control_number":"MXBO01","station_serial":"14904SN-1","station_location":"Molding Stations plant 1","station_line_id":"18","created_at":"2023-06-20 14:55:27","station_company_id":"11"}]

					const response = JSON.parse(data);
					$('#station_name').text(response.station_name);
					$('#modal-title').text(response.station_name);
					$('#station_control_number').text(response.station_control_number);
					$('#station_serial').text(response.station_serial);
					$('#station_line_id').text(response.station_line_id);
					$('#station_id').text(response.station_id);
					$('#station_location').text(response.station_location);
					$('#station_plant').text(response.plant_name);
					$('#station_line').text(response.line_name);

					$('#details-modal').modal('show');
				},
				error: function(error) {
					console.log("error.")
				}
			});
		});
	});
</script>

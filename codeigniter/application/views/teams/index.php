<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

<div class="row">
	<div class="col">
		<div class="card sb-card-shadow">
			<div class="card-body">
				<form id="myForm" method="post">

					<div class="row mb-5">
						<div class="col">
							<input type="text" class="form-control" id="team_name" name="team_name" value="<?php echo ($action != null) ? $line['team_name'] : ""; ?>" >
							<small>Your teams name should be something descriptive like: maintenance team, setup techs, etc.</small>
						</div>
					</div>

					<div class="row">
						<?php if ($action != null): ?>
							<input type="hidden" name="id" value="<?php echo $line['line_id'] ?>">
						<?php endif; ?>


						<div class="col">
							<select style="width: 100%;" class="select2" name="users[]" multiple="multiple" required>
								<option value="">Select Users</option>
								<?php foreach($users as $user): ?>
									<option value="<?php echo $user['user_id'] ?>"><?php echo $user["user_email"] ?></option>
								<?php endforeach; ?>
							</select>
							<small>Select team members.</small>
						</div>

						<div class="col">

							<select style="width: 100%;" class="select2" name="users[]" multiple="multiple" required>
								<option value="">Select Alerts</option>
								<?php foreach($alerts as $alert): ?>
									<option value="<?php echo $alert['main_id'] ?>"><?php echo $alert["main_name"] ?></option>
								<?php endforeach; ?>
							</select>
							<small>Select responsibilities.</small>

						</div>
					</div>

					<div class="row mt-5">
						<div class="col">
							<!--bootstrap toggle-->
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="customSwitch1">
								<label class="custom-control-label" for="customSwitch1">1st Escalation</label>
							</div>
						</div>
						<div class="col">
							<!--bootstrap toggle-->
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="customSwitch2">
								<label class="custom-control-label" for="customSwitch2">2nd Escalation</label>
							</div>
						</div>
						<div class="col">
							<!--bootstrap toggle-->
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="customSwitch3">
								<label class="custom-control-label" for="customSwitch3">3rd Escalation</label>
							</div>
						</div>
						<div class="col">
							<!--bootstrap toggle-->
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="customSwitch4">
								<label class="custom-control-label" for="customSwitch4">4th Escalation</label>
							</div>
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
						<th>Line/Cell</th>
						<th>Plant</th>
						<th>Actions</th>
					</tr>
					</thead>

				</table>
			</div>
		</div>
	</div>

</div>
<!-- Notification toast -->
<div class="notification-toast bottom-middle" id="notification-toast"></div>




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
				url: '<?php echo base_url() ?>locations/update_line',
				method: 'POST',
				data: formData,
				success: function(response)
				{
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
				url: '<?php echo base_url() ?>locations/delete_line',
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
				url: '<?php echo base_url() ?>teams/save_team',
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
				'url':'<?=base_url()?>locations/line_list'
			},
			'columns': [
				{ data: 'line_name' },
				{ data: 'plant_name' },
				{ data: 'actions' }
			]
		});
	});
</script>


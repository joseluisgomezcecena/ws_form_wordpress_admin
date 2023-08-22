<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

<div class="row">
	<div class="col">

		<div class="card sb-card-shadow">
			<div class="card-body">
				<form id="myForm" method="post">

					<div class="row">
						<div class="col">

							<?php if ($action != null): ?>
							<input type="hidden" name="alert_id" value="<?php echo $alert['alert_id'] ?>">
							<?php endif; ?>

							<select class="form-control" name="main_alert" id="main_alert" required>
								<option value="">Select Main Alert</option>
								<?php foreach($main_alerts as $main): ?>
									<option
										<?php
										if($action != null)
										{
											if ($main['main_id'] == $alert['main_id'])
											{
												echo "selected";
											}
											else
											{
												echo "";
											}
										}
										?>
									value="<?php echo $main['main_id'] ?>"><?php echo $main["main_name"] ?></option>
								<?php endforeach; ?>
							</select>
							<small>Only alerts that have been registered with sub alerts are displayed. For more check
								<a href="<?php echo base_url()  ?>alerts/">Main Alerts</a></small>

						</div>
						<div class="col">
							<input type="text" class="form-control" name="alert_name" id="alert" value="<?php echo ($action != null) ? $alert['alert_name'] : ""; ?>"  required>
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
	<?php if ($action == null): ?>
	<div class="col">
		<div class="card sb-card-shadow">
			<div class="card-body">
				<table style="width: 100%"  id='empTable' class='display dataTable'>
					<thead>
						<tr>
							<th>Main Alert</th>
							<th>Sub Alert</th>
							<th>Actions</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>

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
				url: '<?php echo base_url() ?>subalerts/update_alert',
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

					//wait 3 seconds before redirecting.
					setTimeout(function(){
						window.location.href = '<?php echo base_url() ?>alerts/subalerts';
					}, 3000);

				},
				error: function(error) {
					console.error(error);
					showToast("fail")
				}
			});
		});
	});

	<?php elseif($action == "delete"): ?>
	//disable form fields.
	$('#main_alert').prop('disabled', true);
	$('#alert').prop('disabled', true);

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
				url: '<?php echo base_url() ?>subalerts/delete_alert',
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
					//wait 3 seconds before redirecting.
					setTimeout(function(){
						window.location.href = '<?php echo base_url() ?>subalerts';
					}, 3000);
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
				url: '<?php echo base_url() ?>subalerts/save_alert',
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
					$('#alert').val('');
					//$('#myForm')[0].reset();
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
				'url':'<?=base_url()?>subalerts/alert_list'
			},
			'columns': [
				{ data: 'main_name' },
				{ data: 'alert_name' },
				{ data: 'actions' }
			]
		});
	});
</script>



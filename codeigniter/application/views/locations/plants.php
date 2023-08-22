<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

<div class="row">
	<div class="col">
		<div class="card sb-card-shadow">
			<div class="card-body">

				<div class="mb-5">
					<?php if ($action == "update"): ?>
						<a href="<?php echo base_url() ?>plants" class="btn btn-more float-right mb-5">Add New</a><br>

						<h5 class="card-title font-weight-bolder">Updating <?php echo $plant['plant_name']; ?></h5>
					<?php elseif ($action == "delete"): ?>
						<h5 class="card-title font-weight-bolder">Deleting <?php echo $plant['plant_name']; ?></h5>
					<?php else: ?>
						<h5 class="card-title font-weight-bolder">Add a Plant</h5>
					<?php endif; ?>
				</div>


				<form id="myForm" method="post">

					<?php if ($action != null): ?>
						<input type="hidden" name="id" value="<?php echo $plant['plant_id'] ?>">
					<?php endif; ?>

					<input type="text" class="form-control mb-5" id="plant_name" name="plant_name" value="<?php echo ($action != null) ? $plant['plant_name'] : ""; ?>">
					<button class="btn-submit  d-sm-block" id="btn" type="submit">Save</button>
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
							<th>ID</th>
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
					url: '<?php echo base_url() ?>locations/update_plant',
					method: 'POST',
					data: formData,
					success: function(response)
					{
						console.log(response);

						const data = JSON.parse(response);

						showToast(data.status, data.message);
						if (data.status === "error")
						{
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

	$('#plant_name').prop('disabled', true);

	$(document).ready(function() {
		// Handle form submission
		$('#myForm').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>locations/delete_plant',
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
						window.location.href = '<?php echo base_url() ?>locations/plants';
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
					url: '<?php echo base_url() ?>locations/save_plant',
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
				'url':'<?=base_url()?>locations/plant_list'
			},
			'columns': [
				{ data: 'plant_id' },
				{ data: 'plant_name' },
				{ data: 'actions' }
			]
		});
	});
</script>



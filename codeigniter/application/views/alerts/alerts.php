<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

<div class="row">
	<div class="col">

		<div class="card sb-card-shadow">
			<div class="card-body">
				<form id="myFormOpt" method="post">

					<div class="row">
						<div class="col">
							<input type="hidden" name="main_id" value="<?php echo ($action != null) ? $alert['main_id'] : ""; ?>">
							<input type="text" class="form-control" name="main_name" id="main_name" value="<?php echo ($action != null) ? $alert['main_name'] : ""; ?>" placeholder="Parent or Main Alert" >
							<small><span class="text-danger">*</span>These alert names will appear in the client application.</small>
						</div>
					</div>
					<div class="row mt-5">
						<div class="col">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="has_children" id="subalerts" <?php if($action != null){echo ($alert['has_children'] != 0) ? "checked" : ""; } ?>>
								<label class="form-check-label" for="subalerts">Has Sub-alerts</label>
							</div>
							<small><span class="text-danger">*</span>Select this to enable subcategories you can add specific sub-alerts for all alerts, if not this alert won't have subcategories.</small>
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
							<th>Has Sub-Alerts</th>
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

	<?php if ($action == null): ?>

	$(document).ready(function() {
		// Handle form submission
		$('#myFormOpt').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>alerts/save_main',
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
					$('#myFormOpt')[0].reset();
					$('#empTable').DataTable().ajax.reload();

					//reload select with new data.
					$.ajax({
						url: '<?php echo base_url() ?>alerts/get_main_selectbox',
						method: 'GET',
						dataType: 'json',
						success: function(response)
						{
							$('#main_alert').empty();
							$('#main_alert').append('<option value="">Select Main Alert</option>');
							$.each(response, function(index, item) {
								$('#main_alert').append('<option value="'+item.main_id+'">'+item.main_name+'</option>');
							});
						},
						error: function(error) {
							console.error(error);
							showToast("fail", "Error loading main alerts");
						}
					});


				},
				error: function(error) {
					console.error(error);
					showToast("fail",error)
				}
			});
		});
	});

	<?php elseif ($action == "update"): ?>

	$(document).ready(function() {
		// Handle form submission
		$('#myFormOpt').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>alerts/update_main',
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
						window.location.href = '<?php echo base_url() ?>alerts/';
					}, 1500);

					//reload select with new data.
					/*
					$.ajax({
						url: '<?php echo base_url() ?>alerts/get_main_selectbox',
						method: 'GET',
						dataType: 'json',
						success: function(response)
						{
							$('#main_alert').empty();
							$('#main_alert').append('<option value="">Select Main Alert</option>');
							$.each(response, function(index, item) {
								$('#main_alert').append('<option value="'+item.main_id+'">'+item.main_name+'</option>');
							});
						},
						error: function(error) {
							console.error(error);
							showToast("fail", "Error loading main alerts");
						}
					});
					*/

				},
				error: function(error) {
					console.error(error);
					showToast("fail",error)
				}
			});
		});
	});

	<?php elseif ($action == "delete"): ?>


	$(document).ready(function() {

		//disable form fields
		$('#main_name').prop('disabled', true);
		$('#subalerts').prop('disabled', true);

		//change button text
		$('#btn').text('Delete');
		//remove class from button
		$('#btn').removeClass('btn-submit');
		//add class to button
		$('#btn').addClass('btn-delete');

		// Handle form submission
		$('#myFormOpt').submit(function(event) {
			event.preventDefault();
			// Get form data
			const formData = $(this).serialize();

			// Send AJAX request to controller
			$.ajax({
				url: '<?php echo base_url() ?>alerts/delete_main',
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
						window.location.href = '<?php echo base_url() ?>alerts/';
					}, 1500);

				},
				error: function(error) {
					console.error(error);
					showToast("fail",error)
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
				'url':'<?=base_url()?>alerts/main_list'
			},
			'columns': [
				{ data: 'main_name' },
				{ data: 'has_children' },
				{ data: 'actions' }
			]
		});
	});
</script>

<script>
	$(document).ready(function(){

		//if id #alert has value then remove disabled attribute from button
		if($('#alert').val() != ''){
			$('#alert').removeAttr('disabled');
			$('#main_alert').removeAttr('disabled');
		}


		//on checked checkbox remove disabled attribute from button
		$('#myFormOpt input[type=checkbox]').change(function(){
			if($(this).is(':checked')){
				$('#alert').removeAttr('disabled');
				$('#main_alert').removeAttr('disabled');
			}else{
				$('#alert').attr('disabled', 'disabled');
				$('#main_alert').attr('disabled', 'disabled');
			}
		});
	});
</script>



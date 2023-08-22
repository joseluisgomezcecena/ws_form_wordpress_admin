<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/socketio/socket_io_v2.js"></script>

<div style="margin-top: 150px !important; color: #282828 !important;" class="mt-5 mb-5 text-dark">
	<div class="row">

		<div id="messages">
			ireo
		</div>

		<div class="col-md-6 col-lg-4">
			<a href="<?php echo base_url() ?>clientapp">
				<div data-tippy-content="Click to open the client application." class="card sb-card-shadow card-hover">
					<div class="card-header">
						<h4 class="card-title font-weight-bolder">Client Application</h4>
					</div>
					<div class="card-body text-justify text-dark">
						This application is for production to report any issues or problems they encounter during production.
						This application could be used on mobile devices or desktops on the production floor.
					</div>
				</div>
			</a>
		</div>

		<div  class="col-md-6 col-lg-4">
			<a href="<?php echo base_url() ?>dashboard">
				<div data-tippy-content="Click to open the admin application." class="card sb-card-shadow card-hover">
					<div class="card-header">
						<h4 class="card-title font-weight-bolder">Admin Application</h4>
					</div>
					<div class="card-body text-justify text-dark">
						This application is for Andon event responders to view the reports submitted by the production team.
						You can also add new users and assign them roles and assign them to a department.
					</div>
				</div>
			</a>
		</div>


		<div class="col-md-6 col-lg-4">
			<a  href="<?php echo base_url() ?>clients">
				<div data-tippy-content="Click to open the production screens application." class="card sb-card-shadow card-hover">
					<div class="card-header">
						<h4 class="card-title font-weight-bolder">Production Screen App</h4>
					</div>
					<div class="card-body text-justify text-dark">
						This application is for the production team to view the current status of the production floor.
						This app could be used on monitors or tvs placed on the production floor.
					</div>
				</div>
			</a>
		</div>

	</div>
</div>

<!--
<div style="margin-top: 100px;" class="card sb-card-shadow">
	<div class="card-body">
		<div class="m-t-25">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">

						<div class="col-lg-4 col-md-6 col-sm-12 text-center">
							<a style="text-decoration: none;" href="<?php echo base_url() ?>client-screens">

								<div class="card shadow card-hover bg-gradient-one">
									<div class="card-body">
										<h3 class="card-title text-white bold">
											Screen App
										</h3>
									</div>
								</div>

							</a>
						</div>

						<div class="col-lg-4 col-md-6 col-sm-12 text-center">
							<a style="text-decoration: none;" href="<?php echo base_url() ?>clients">
								<div class="card shadow card-hover">
									<div class="card-body">
										<h3 class="card-title">
											Client App
										</h3>
									</div>
								</div>
							</a>
						</div>




						<div class="col-lg-4 col-md-6 col-sm-12 text-center">
							<a style="text-decoration: none;" href="<?php echo base_url() ?>andon">
								<div class="card shadow card-hover">
									<div class="card-body">
										<h3 class="card-title">
											Response Team App
										</h3>
									</div>
								</div>
							</a>
						</div>



						<div class="col-lg-4 col-md-6 col-sm-12 text-center">
							<a style="text-decoration: none;" href="<?php echo base_url() ?>dashboard">
								<div class="card shadow card-hover">
									<div class="card-body">
										<h3 class="card-title">
											Admin App
										</h3>
									</div>
								</div>
							</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
-->
<script>
	var socket = io.connect('http://localhost:3001');

	socket.on('newOrder', function(data) {
		alert(data.alert_id);
		console.log("conntected:" + data);
		$("#messages").append("data: " + data.message + " alert_id: " + data.alert_id + " company_id: " + data.company_id + "");
	});
</script>

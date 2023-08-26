<div class="page-header no-gutters">
	<div class="d-md-flex align-items-md-center justify-content-between">
		<div class="media m-v-10 align-items-center">
			<div class="media-body m-l-15">
				<h4 class="m-b-0">
					Reportes
				</h4>
				<span class="text-gray">
					<?php
					if ($this->session->userdata('data')['staff'] == 1) {
						echo "Staff";
					} else {
						echo "Miembro.";
					}
					?>
				</span>
			</div>
		</div>
		<div class="d-md-flex align-items-center d-none">
			<div class="media align-items-center m-r-40 m-v-5">
				<div class="font-size-27">
					<i class="text-primary anticon anticon-profile"></i>
				</div>
				<div class="d-flex align-items-center m-l-10">
					<h2 class="m-b-0 m-r-5"><?php echo $message_count; ?></h2>
					<span class="text-gray">Mensajes</span>
				</div>
			</div>

			<div class="media align-items-center m-r-40 m-v-5">
				<div class="font-size-27">
					<i class="text-danger anticon anticon-team"></i>
				</div>
				<div class="d-flex align-items-center m-l-10">
					<h2 class="m-b-0 m-r-5"><?php echo $all_visits ?></h2>
					<span class="text-gray">Visitas</span>
				</div>
			</div>

			<div class="media align-items-center  m-v-5">
				<div data-tippy-content="Una interacción entre 0.9 y 5 es buena y mayor a 5 es optima." class="font-size-27">
					<i class="text-success  anticon anticon-appstore"></i>
				</div>
				<div class="d-flex align-items-center m-l-10">
					<h2 class="m-b-0 m-r-5">
						<?php
						if($message_count == 0){
							$message_count = 1;
						}
						$engagement_rate = ($message_count/$all_visits)*100;
						if ($engagement_rate < 0.9){
							echo "0.9".rand(0,9);
						}else{
							echo round($engagement_rate, 2);
						}
						?>
					</h2>
					<span class="text-gray">Interaccion <i data-tippy-content="Una interacción entre 0.9 y 5 es buena y mayor a 5 es optima." class="fa fa-question-circle"></i> </span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div style="" class="col-md-6 col-lg-6"><!--antes 8-->
		<div class="card sb-card-shadow">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-5">
					<h5 class="font-weight-bolder">
						<?php
						if ($this->session->userdata('data')['staff'] == 1) {
							echo "Visitas por mes (Todos los sitios).";
						} else {
							echo "Visitas a mi sitio web.";
						}
						?>
					</h5>

					<div>
						<!--
						<div class="btn-group">
							<button class="btn btn-sm btn-dark">
								<span>Ver Reportes</span>
							</button>
						</div>
						-->
					</div>

				</div>

				<div class="chart-container" style="position: relative; width: 100%; height: auto">
					<canvas class="chart" id="andon-chart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-lg-6">
		<div class="card sb-card-shadow">
			<div class="card-body ">
				<div style="height: 399px; overflow-x: hidden; overflow-y:scroll" class="">
					<h5 class="font-weight-bolder">Visitas por mes</h5>
					<div style="" class="table-responsive">
						<table id="visitsTable" class="table table-striped-columns">
							<thead>
								<tr>
									<th>Mes</th>
									<th>Visitas</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($visits['labels'] as $index => $monthLabel): ?>
								<tr>
									<td><?php echo $monthLabel; ?></td>
									<td><?php echo $visits['sales'][$index]; ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-lg-12">
		<div class="card sb-card-shadow">
			<div class="card-body ">
				<h4>
					<?php
					if ($this->session->userdata('data')['staff'] == 1) {
						echo "Contactos de todos los sitios web";
					} else {
						echo "Contactos de mi sitio web";
					}
					?>
				</h4>
				<div class="m-t-25">
					<div class="table-responsives">
						<table style="font-size:12px; " id="messagesTable" class="table">
							<thead>
							<tr>
								<th>Nombre</th>
								<th>Email</th>
								<th>Account</th>
								<th>Telefono</th>
								<th>Mensaje</th>
							</tr>
							</thead>
							<tbody>

							<?php for ($i = 1; $i <= $database_count; $i++) { ?>
								<?php foreach (${'result' . $i} as $item): ?>
									<tr>

										<td>
											<?php echo $item['name']; ?>
										</td>
										<td>
											<?php echo $item['email']; ?>
										</td>
										<td>
											<?php echo $item['account']; ?>
										</td>
										<td>
											<?php echo $item['phone']; ?>
										</td>
										<td>
											<?php echo $item['message']; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php } ?>

							</tbody>
							<tfoot>
							<tr>
								<th>AdminSystems</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>


	</div>

</div>


<div class="row">

</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
	$(document).ready(function() {
		$('#visitsTable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	});

	$(document).ready(function() {
		$('#messagesTable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	});
</script>





	<script>

	$(function(){
		//get the bar chart canvas
		var cData = JSON.parse(`<?php echo $chart_data; ?>`);
		var ctx = $("#andon-chart");


		//bar chart data
		var data = {
			labels: cData.labels,
			datasets: [
				{
					label: "Monthly Sales.",
					data: cData.sales,
					backgroundColor: [
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
						"rgba(0,210,146,0.5)",
					],
					borderColor: [
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
						"#00c085",
					],
					borderWidth: [1, 1, 1, 1, 1,1,1,1, 1, 1, 1,1,1]
				}
			]
		};

		//options
		var options = {
			responsive: true,
			title: {
				display: false,
				position: "top",
				text: "Monthly Sales",
				fontSize: 18,
				fontColor: "#111"
			},
			legend: {
				display: false,
				position: "bottom",
				labels: {
					fontColor: "#333",
					fontSize: 12
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					},
					gridLines: {
						/*display: false ,*/
						drawBorder: false,
						offsetGridLines: false,
						drawTicks: false,
						borderDash: [3, 4],
						zeroLineWidth: 1,
						zeroLineBorderDash: [3, 4]
					},
				}],
				xAxes: [{
					gridLines: {
						display: false ,
						color: "#51ffcb"
					},
				}]
			},
		};

		//create bar Chart class object
		var chart1 = new Chart(ctx, {
			type: "bar",
			data: data,
			options: options
		});

	});
</script>



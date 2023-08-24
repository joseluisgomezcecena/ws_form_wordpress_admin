<div class="page-header no-gutters">
	<div class="d-md-flex align-items-md-center justify-content-between">
		<div class="media m-v-10 align-items-center">
			<div class="media-body m-l-15">
				<h4 class="m-b-0">Registro de administradores o miembros de staff.</h4>
			</div>
		</div>
	</div>
</div>

<div class="row">


	<div class="col-md-6 col-lg-6"><!--antes 8-->
		<div class="card sb-card-shadow">
			<div class="card-body">

				<?php if (validation_errors()) : ?>
					<div class="alert alert-danger alert-dismissible fade show">
						<strong>Error!</strong> <?php echo validation_errors(); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>

				<?php if ($this->session->flashdata('message')) : ?>
					<div class="alert alert-success alert-dismissible fade show">
						<strong>Mensaje:</strong> <?php echo $this->session->flashdata('message') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>


				<div class="d-flex justify-content-between align-items-center mb-5">
					<h5 class="font-weight-bolder">
						Registrar nuevo
					</h5>
				</div>


				<div class="mt-5">

					<form action="<?php echo base_url() ?>accounts/admins" method="post">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
								<input type="email" name="user_email" class="form-control" id="inputEmail3" placeholder="Email">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Contraseña</label>
							<div class="col-sm-9">
								<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Contraseña">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Telefono</label>
							<div class="col-sm-9">
								<input type="tel" name="user_phone" class="form-control" id="inputPassword3" placeholder="Numero de telefono">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-dark float-right">Registrar</button>
							</div>
						</div>
					</form>

				</div>


			</div>
		</div>
	</div>

	<div class="col-md-6 col-lg-6">
		<div class="card sb-card-shadow">
			<div class="card-body ">
				<h4>Admins/Staff</h4>
				<div class="m-t-25">
					<div class="table-responsives">
						<table style="font-size:12px; " id="data-table" class="table">
							<thead>
							<tr>

								<th>Email</th>
								<th>Cuenta</th>
								<th>Opciones</th>

							</tr>
							</thead>
							<tbody>

							<?php foreach ($admins as $admin): ?>

								<tr>
									<td><?php echo $admin['user_email'] ?></td>
									<td><?php echo "https://adminsystems.mx" ?></td>
									<td><a class="btn btn-outline-dark" href="<?php echo base_url() ?>admins/edit/<?php echo $admin['user_id'] ?>">Editar</a></td>
								</tr>

							<?php endforeach; ?>

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


<!--
is staff: <?php echo $staff; ?>
<br><br/>
database count: <?php echo $database_count; ?>
<br><br/>
-->

<?php
/*
for ($i = 1; $i <= $database_count; $i++) { ?>
	<?php echo "result" . $i; ?>
	<br><br/>
	<?php print_r(${'result' . $i}); ?>
	<br><br/>
<?php
}*/
?>



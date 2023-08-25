<div class="page-header no-gutters">
	<div class="d-md-flex align-items-md-center justify-content-between">
		<div class="media m-v-10 align-items-center">
			<div class="media-body m-l-15">
				<h4 class="m-b-0">Registro de clientes.</h4>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-success alert-dismissible fade show">
			<h4 class="alert-heading">Recuerda!</h4>
			<p class="m-b-0">Para conectar esta plataforma a la pagina del cliente debes de llenar todos los campos de registro de usuario, ademas debes admitir una conexión remota por parte de MySql en el panel de administración del sitio web.</p>
			<hr class="m-v-20">
			<p class="m-b-0">Si tienes problemas ponte en contacto con soporte.</p>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>

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

					<form action="<?php echo base_url() ?>accounts/clients" method="post">
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
							<label for="inputPassword3" class="col-sm-3 col-form-label">URL de Sitio Web</label>
							<div class="col-sm-9">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://</div>
									</div>
									<input type="text" name="company_site" class="form-control" id="inlineFormInputGroup" placeholder="Url de sitio web, ej. google.com">
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Compañia</label>
							<div class="col-sm-9">
								<input type="text" name="company_name" class="form-control" id="inputPassword3" placeholder="Nombre de la compañia o cliente">
							</div>
						</div>

						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Base de datos de WP</label>
							<div class="col-sm-3">
								<input type="text" name="company_db" class="form-control" id="inputPassword3" placeholder="Base de datos de WordPress">
							</div>
							<label for="inputPassword3" class="col-sm-3 col-form-label">Prefijo de WP</label>
							<div class="col-sm-3">
								<input type="text" name="db_prefix" class="form-control" id="inputPassword3" placeholder="Prefijo de la base de datos.">
							</div>
						</div>

						<!--
						<fieldset class="form-group">
							<div class="row">
								<label class="col-form-label col-sm-2 pt-0">Radios</label>
								<div class="col-sm-10">
									<div class="radio">
										<input type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
										<label for="gridRadios1">
											First radio
										</label>
									</div>
									<div class="radio">
										<input type="radio" name="gridRadios" id="gridRadios2" value="option2">
										<label for="gridRadios2">
											Second radio
										</label>
									</div>
									<div class="radio">
										<input type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
										<label for="gridRadios3">
											Third disabled radio
										</label>
									</div>
								</div>
							</div>
						</fieldset>
						<div class="form-group row">
							<div class="col-sm-2">Checkbox</div>
							<div class="col-sm-10">
								<div class="checkbox">
									<input type="checkbox" id="gridCheck1">
									<label for="gridCheck1">
										Example checkbox
									</label>
								</div>
							</div>
						</div>
						-->
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
				<h4>Usuarios</h4>
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

							<?php foreach ($clients as $client): ?>

								<tr>
									<td><?php echo $client['user_email'] ?></td>
									<td><?php echo $client['company_site'] ?></td>
									<td><a class="btn btn-outline-dark" href="<?php echo base_url() ?>accounts/clients/<?php echo $client['id'] ?>">Editar</a></td>
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



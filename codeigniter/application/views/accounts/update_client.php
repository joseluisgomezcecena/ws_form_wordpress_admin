<div class="page-header no-gutters">
	<div class="d-md-flex align-items-md-center justify-content-between">
		<div class="media m-v-10 align-items-center">
			<div class="media-body m-l-15">
				<h4 class="m-b-0">Actualizar cliente.</h4>
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
						Actualizar
					</h5>
				</div>


				<div class="mt-5">

					<form action="<?php echo base_url() ?>accounts/updateclient/<?php echo $client["id"] ?>" method="post">
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
								<input type="email" name="user_email" class="form-control" id="inputEmail3" value="<?php echo $client['user_email'] ?>" placeholder="Email">
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
								<input type="tel" name="user_phone" class="form-control" id="inputPassword3" value="<?php echo $client['user_phone'] ?>" placeholder="Numero de telefono">
							</div>
						</div>

						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">URL de Sitio Web</label>
							<div class="col-sm-9">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">https://</div>
									</div>
									<input type="text" name="company_site" class="form-control" id="inlineFormInputGroup" value="<?php echo $client['company_site'] ?>" placeholder="Url de sitio web, ej. google.com">
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Compañia</label>
							<div class="col-sm-9">
								<input type="text" name="company_name" class="form-control" id="inputPassword3" value="<?php echo $client['company_name'] ?>" placeholder="Nombre de la compañia o cliente">
							</div>
						</div>

						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 col-form-label">Base de datos de WP</label>
							<div class="col-sm-3">
								<input type="text" name="company_db" class="form-control" id="inputPassword3" value="<?php echo $client['company_db'] ?>" placeholder="Base de datos de WordPress">
							</div>
							<label for="inputPassword3" class="col-sm-3 col-form-label">Prefijo de WP</label>
							<div class="col-sm-3">
								<input type="text" name="db_prefix" class="form-control" id="inputPassword3" value="<?php echo $client['db_prefix'] ?>" placeholder="Prefijo de la base de datos.">
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
								<button type="submit" class="btn btn-dark float-right">Actualizar</button>
							</div>
						</div>
					</form>

				</div>


			</div>
		</div>
	</div>

</div>


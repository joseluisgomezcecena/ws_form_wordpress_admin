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
									<td><a class="btn btn-outline-dark" href="<?php echo base_url() ?>accounts/admins/<?php echo $admin['user_id'] ?>">Editar</a></td>
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


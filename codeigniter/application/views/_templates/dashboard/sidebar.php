<!-- Side Nav START -->
<div style="font-size: 16px;"  class="side-nav dark-nav" >
	<div class="side-nav-inner">
		<ul class="side-nav-menu scrollable">

			<li style="margin-left: 5px; margin-right: 5px;" class="nav-item dropdown card sb-card-shadow mt-3">
				<a class="dropdown-toggle" href="javascript:void(0);">
					<span class="icon-holder">
						<i class="anticon anticon-appstore"></i>
					</span>
					<span class="title">Mi Panel</span>
					<span class="arrow">
                        <i class="arrow-icon"></i>
					</span>
				</a>
				<ul class="dropdown-menu">
					<li class="active">
						<a href="<?php echo base_url() ?>dashboard">Inicio</a>
					</li>
				</ul>
			</li>







			<li style="margin-left: 5px; margin-right: 5px;" class="nav-item dropdown card sb-card-shadow">
				<a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-pie-chart"></i>
                                </span>
					<span class="title">Analytics (Reportes)</span>
					<span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url() ?>reports">
							<span class="icon-holder">
                                    <i class="anticon anticon-file-excel"></i>
                            </span>
							<span>Generar Reportes</span>
						</a>
					</li>
				</ul>
			</li>



			<?php if ($this->session->userdata('data') ['staff'] == 1): ?>
			<li style="margin-left: 5px; margin-right: 5px;" class="nav-item dropdown card sb-card-shadow">
				<a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-control"></i>
                                </span>
					<span class="title">Configuración</span>
					<span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
				</a>
				<ul class="dropdown-menu">
					<li class="nav-item dropdown">
						<a href="javascript:void(0);">
							<span class="icon-holder">
                                    <i class="anticon anticon-usergroup-add"></i>
                            </span>
							<span>Usuarios</span>
							<span class="arrow">
                                            <i class="arrow-icon"></i>
                                        </span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo base_url() ?>accounts/clients">Administrar Clientes</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>accounts/admins">Administrar Staff</a>
							</li>
						</ul>
					</li>

					<!--
					<li>
						<a href="<?php echo base_url() ?>teams">
							<span class="icon-holder">
                                    <i class="anticon anticon-message"></i>
                            </span>
							<span>
								Correos electronicos
							</span>

						</a>
					</li>
					-->
				</ul>
			</li>
			<?php endif; ?>
			<!--
			<li class="nav-item dropdown">
				<a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-lock"></i>
                                </span>
					<span class="title">Authentication</span>
					<span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="login-1.html">Login 1</a>
					</li>
					<li>
						<a href="login-2.html">Login 2</a>
					</li>
					<li>
						<a href="login-3.html">Login 3</a>
					</li>
					<li>
						<a href="sign-up-1.html">Sign Up 1</a>
					</li>
					<li>
						<a href="sign-up-2.html">Sign Up 2</a>
					</li>
					<li>
						<a href="sign-up-3.html">Sign Up 3</a>
					</li>
					<li>
						<a href="error-1.html">Error 1</a>
					</li>
					<li>
						<a href="error-2.html">Error 2</a>
					</li>
				</ul>
			</li>
			-->
		</ul>
	</div>
</div>
<!-- Side Nav END -->

<!-- Page Container START -->
<div class="page-container">


	<!-- Content Wrapper START content-bg -->
	<div style="background-color: white;" class="main-content ">

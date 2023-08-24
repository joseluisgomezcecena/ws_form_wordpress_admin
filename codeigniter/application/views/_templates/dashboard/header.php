<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Andon - Admin Dashboard</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/logo/adminlogo.png">

	<!-- page css -->

	<!-- Core css -->
	<link href="<?php echo base_url() ?>assets/css/app.min.css" rel="stylesheet">

	<link href="<?php echo base_url() ?>assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">


	<link href="<?php echo base_url() ?>assets/vendors/select2/select2.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/nexus.css">

	<style>
		/*
		.page-container .main-content{
			background-color: rgba(220, 220, 220, 0.27);
		}

		.my-shadow{
			box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.1);
			border: 1px solid #e5e5e5;
		}

		.card{
			border-radius: .75rem;
			box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.1);
			border: 1px solid #e5e5e5;
		}

		.card-hover:hover{
			transform: scale(1.05);
			box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
		}

		.btn{
			border-radius: .5rem !important;
			/*height:3rem;*//*
		}

		.btn-primary{
			background-color: rgba(14 165 233 / 1);
		}

		.text-primary{
			color: rgba(14 165 233 / 1) !important;
		}

		.preload    {
			position: fixed;
			top: 0;
			width: 100%;
			height: 100vh;
			background-color: rgb(255, 255, 255);
			display: flex;
			justify-content: center;
			align-items: center;
			transition: opacity 0.5s ease;
			z-index: 99999;
		}

		.preload h3 {
			position: absolute;
			top: 75%;
			transform: translateY(-75%);
			color: white;
			font-size: 40px;
			font-family: sans-serif;
		}

		.preload-finish {
			opacity: 0;
			pointer-events: none;
		}

		.preload image {
			width: 100%;
			height: 100%;
		}

		.bg-gradient-one{
			background-image: linear-gradient(117.63deg, rgb(8, 89, 255) -0.78%, rgb(0, 154, 231) 55.03%, rgb(221, 255, 84) 111.19%);
			background-color: rgb(22, 125, 255)
		}

		.bg-gradient-two{
			background-image: linear-gradient(130.93deg, rgb(105, 2, 154) 0%, rgb(135, 1, 199) 32.33%, rgb(107, 87, 255) 97.76%);
			background-color: rgb(135, 1, 199);
		}

		.bg-gradient-three{
			background-image: radial-gradient(89.53% 145.96% at .34% 100.79%,#ef4857 0,#de4970 17.58%,#b44db0 50.31%,#7f52ff 97.03%);
			background-color: #7f52ff;
		}
		*/
	</style>

</head>

<body>

<div class="app is-folded">
	<!--
	<div class="preload"><img src="<?php echo base_url() ?>assets/images/others/loader.gif" alt=""></div>
	-->
	<div class="layout">
		<!-- Header START -->
		<div class="header dark-header sb-globalnav">
			<div class="logo logo-dark">
				<a style="margin-top: 10px;" href="<?php echo base_url() ?>">
					<img  src="<?php echo base_url() ?>assets/images/logo/adminlogo.png" alt="Logo" width="60" height="45"><span class="text-white font-weight-bolder">Admin</span>
					<img style="margin-left: 12px;" class="logo-fold text-center" src="<?php echo base_url() ?>assets/images/logo/adminlogo.png" alt="Logo" width="50" height="36">
				</a>
			</div>
			<div class="logo logo-white">
				<a style="margin-top: 10px;" href="<?php echo base_url() ?>">
					<img src="<?php echo base_url() ?>assets/images/logo/adminlogo.png" alt="Logo" width="60" height="45"><span class="text-white font-weight-bolder">Admin</span>
					<img style="margin-left: 12px;" class="logo-fold text-center" src="<?php echo base_url() ?>assets/images/logo/adminlogo.png" alt="Logo" width="50" height="36">
				</a>
			</div>
			<div class="nav-wrap">


				<ul class="nav-left">
					<li class="desktop-toggle">
						<a href="javascript:void(0);">
							<i class="anticon"></i>
						</a>
					</li>
					<li class="mobile-toggle">
						<a href="javascript:void(0);">
							<i class="anticon"></i>
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" data-toggle="modal" data-target="#search-drawer">
							<i class="anticon anticon-search"></i>
						</a>
					</li>
				</ul>



				<ul class="nav-right">
					<!--
					<li class="dropdown dropdown-animated scale-left">
						<a href="javascript:void(0);" data-toggle="dropdown">
							<i class="anticon anticon-bell notification-badge"></i>
						</a>
						<div class="dropdown-menu pop-notification">
							<div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
								<p class="text-dark font-weight-semibold m-b-0">
									<i class="anticon anticon-bell"></i>
									<span class="m-l-10">Notification</span>
								</p>
								<a class="btn-sm btn-default btn" href="javascript:void(0);">
									<small>View All</small>
								</a>
							</div>
							<div class="relative">
								<div class="overflow-y-auto relative scrollable" style="max-height: 300px">
									<a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
										<div class="d-flex">
											<div class="avatar avatar-blue avatar-icon">
												<i class="anticon anticon-mail"></i>
											</div>
											<div class="m-l-15">
												<p class="m-b-0 text-dark">You received a new message</p>
												<p class="m-b-0"><small>8 min ago</small></p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
										<div class="d-flex">
											<div class="avatar avatar-cyan avatar-icon">
												<i class="anticon anticon-user-add"></i>
											</div>
											<div class="m-l-15">
												<p class="m-b-0 text-dark">New user registered</p>
												<p class="m-b-0"><small>7 hours ago</small></p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
										<div class="d-flex">
											<div class="avatar avatar-red avatar-icon">
												<i class="anticon anticon-user-add"></i>
											</div>
											<div class="m-l-15">
												<p class="m-b-0 text-dark">System Alert</p>
												<p class="m-b-0"><small>8 hours ago</small></p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0);" class="dropdown-item d-block p-15 ">
										<div class="d-flex">
											<div class="avatar avatar-gold avatar-icon">
												<i class="anticon anticon-user-add"></i>
											</div>
											<div class="m-l-15">
												<p class="m-b-0 text-dark">You have a new update</p>
												<p class="m-b-0"><small>2 days ago</small></p>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</li>
					-->
					<li class="dropdown dropdown-animated scale-left">
						<div class="pointer" data-toggle="dropdown">
							<div class="avatar avatar-image bg-dark  m-h-10 m-r-15">
								<?php
									//get first letter of email
									echo strtoupper(substr($this->session->userdata('user_email'),0,1));
								?>
								<!--
								<img src="assets/images/avatars/thumb-3.jpg"  alt="">
								-->
							</div>
						</div>
						<div class="p-b-15 p-t-20 dropdown-menu pop-profile">
							<div class="p-h-20 p-b-15 m-b-10 border-bottom">
								<div class="d-flex m-r-50">
									<div class="avatar avatar-lg avatar-image">
										<img src="assets/images/avatars/thumb-3.jpg" alt="">
									</div>
									<div class="m-l-10">
										<p class="m-b-0 text-dark font-weight-semibold">
											<?php
											if($this->session->userdata('logged_in'))
											{
												$user_id = $this->session->userdata('user_id');
												echo substr($this->session->userdata('user_email'),0,24) . '...';
											}
											?>
										</p>

										<p class="m-b-0 opacity-07">
											<?php
											if	($this->session->userdata('data')['staff'] == 1)
											{
												echo 'Staff';
											}
											else
											{
												echo 'Miembro.';
											}
											?>
										</p>
									</div>
								</div>
							</div>
							<a href="<?php echo base_url() ?>accounts/profile" class="dropdown-item d-block p-h-15 p-v-10">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<i class="anticon opacity-04 font-size-16 anticon-user"></i>
										<span class="m-l-10">Actualizar Mi Perfil</span>
									</div>
									<i class="anticon font-size-10 anticon-right"></i>
								</div>
							</a>
							<!--
							<a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<i class="anticon opacity-04 font-size-16 anticon-lock"></i>
										<span class="m-l-10">Account Setting</span>
									</div>
									<i class="anticon font-size-10 anticon-right"></i>
								</div>
							</a>
							<a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<i class="anticon opacity-04 font-size-16 anticon-project"></i>
										<span class="m-l-10">Projects</span>
									</div>
									<i class="anticon font-size-10 anticon-right"></i>
								</div>
							</a>
							-->
							<a href="<?php echo base_url() ?>auth/logout" class="dropdown-item d-block p-h-15 p-v-10">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<i class="anticon opacity-04 font-size-16 anticon-logout"></i>
										<span class="m-l-10">Cerrar Sesión</span>
									</div>
									<i class="anticon font-size-10 anticon-right"></i>
								</div>
							</a>
						</div>
					</li>
					<li>
						<a style="font-size: 16px !important;" href="#"  class="text-white" onclick="history.back()"> <i class="anticon anticon-arrow-left"></i> Back</a>
					</li>
				</ul>

			</div>
		</div>
		<!-- Header END -->

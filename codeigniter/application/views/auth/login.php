<div class="app mt-5">
	<div class="container-fluid">
		<div class="d-flex full-height p-v-15 flex-column justify-content-between">

			<div class="container">
				<div class="row align-items-center">
					<div class="col-sm-12 col-md-8 offset-md-2  col-lg-6 offset-lg-3">

						<?php echo validation_errors(); ?>

						<?php if($this->session->flashdata('login_failed')): ?>
							<div class="alert alert-danger alert-dismissible bg-white fade show" role="alert">
								<div class="d-flex justify-content-start">
									<span class="alert-icon m-r-20 font-size-30">
										<i class="anticon anticon-close-circle"></i>
									</span>
									<div>
										<h5 class="alert-heading">Error.</h5>
										<p><?php echo $this->session->flashdata('login_failed'); ?></p>
									</div>
								</div>
							</div>
						<?php endif; ?>


						<div class="card card2">
							<div class="card-body">
								<h2 class="m-t-20">Login</h2>
								<p class="m-b-30">Please enter your credentials.</p>
								<?php echo form_open(base_url() . 'auth/login') ?>
								<div class="form-group">
									<label class="font-weight-semibold" for="userName">E-mail:</label>
									<div class="input-affix">
										<i class="prefix-icon anticon anticon-user"></i>
										<input type="email" class="form-control" name="email" id="userName" placeholder="Your e-mail">
									</div>
								</div>
								<div class="form-group">
									<label class="font-weight-semibold" for="password">Password:</label>
									<a class="float-right font-size-13 text-muted" href="<?php echo base_url() ?>users/forgot">I forgot my password</a>
									<div class="input-affix m-b-10">
										<i class="prefix-icon anticon anticon-lock"></i>
										<input type="password" class="form-control" name="password" id="password" placeholder="Password">
									</div>
								</div>
								<div class="form-group">
									<div class="d-flex align-items-center justify-content-between">
                                                <span class="font-size-13 text-muted">
                                                    Dont have an account?
                                                    <a class="small" href="<?php echo base_url() ?>auth/register"> Register here.</a>
                                                </span>
										<button type="submit" class="btn-submit d-none d-sm-block">&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;</button>
									</div>
								</div>

								<!--mobile-->
								<div class="form-group">
									<div class="d-flex align-items-center justify-content-between">
										<button style="width: 100%" type="submit" class="btn-submit d-sm-none btn-block">&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;</button>
									</div>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<div class="offset-md-1 col-md-6 d-none d-md-block">
						<!--image-->
						<!--image end-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

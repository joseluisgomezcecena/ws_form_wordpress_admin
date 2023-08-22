<div class="app mt-5">
	<div class="container-fluid">
		<div class="d-flex full-height p-v-15 flex-column justify-content-between">

			<div class="container">
				<div class="row align-items-center">
					<div class="col-sm-12 col-md-8 offset-md-2  col-lg-6 offset-lg-3">

						<?php if($this->session->flashdata('created')): ?>
							<div class="alert alert-danger alert-dismissible fade show bg-dark card2 text-white" role="alert">
								<strong class="text-success">Account created</strong>
								<?php echo $this->session->flashdata('created'); ?>
								<br>
								Click here to login
								<a href="<?php echo base_url() ?>users/login" class="text-success">Login</a>
								<button type="button" class="close text-success" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif; ?>

						<?php echo validation_errors(); ?>

						<div class="card mobile-card">
							<div class="card-body">
								<h2 class="m-t-20">Sign-Up For A Master Account</h2>
								<p class="m-b-30">After you sign up you'll be able to register more users.</p>


								<?php echo form_open(base_url() . 'auth/register') ?>


								<div class="form-group">
									<label class="font-weight-semibold" for="userName">Company Name:</label>
									<div class="input-affix">
										<i class="prefix-icon anticon anticon-home"></i>
										<input type="text" class="form-control" name="company_name" id="companyName" placeholder="Company Name">
									</div>
								</div>

								<div class="form-group">
									<label class="font-weight-semibold" for="userName">E-mail:</label>
									<div class="input-affix">
										<i class="prefix-icon anticon anticon-mail"></i>
										<input type="email" class="form-control" name="email" id="userName" placeholder="Your e-mail">
									</div>
								</div>

								<div class="form-group">
									<label class="font-weight-semibold" for="password">Password:</label>
									<div class="input-affix m-b-10">
										<i class="prefix-icon anticon anticon-lock"></i>
										<input type="password" class="form-control" name="password" id="password" placeholder="Password">
									</div>
								</div>

								<div class="form-group">
									<label class="font-weight-semibold" for="password">Repeat Password:</label>
									<div class="input-affix m-b-10">
										<i class="prefix-icon anticon anticon-lock"></i>
										<input type="password" class="form-control" name="password2" id="password2" placeholder="Password">
									</div>
								</div>

								<div class="form-group row">
									<div class="col-lg-4">
										<label class="font-weight-semibold" for="area">Area Code:</label>
										<div class="input-affix m-b-10">
											<i class="prefix-icon anticon anticon-plus-circle"></i>
											<select  class="form-control" name="area" id="area" required>
												<option value="">Select</option>
												<option value="+1">CAN (+1)</option>
												<option value="+1">USA (+1)</option>
												<option value="+52">MEX (+52)</option>
												<option value="+44">UK (+44)</option>
												<option value="+61">AUS (+61)</option>
											</select>
										</div>
									</div>
									<div class="col-lg-8">
										<label class="font-weight-semibold" for="mobile">Mobile Number:</label>
										<div class="input-affix m-b-10">
											<i class="prefix-icon anticon anticon-phone"></i>
											<input type="tel" class="form-control" name="phone" id="mobile" placeholder="Password">
										</div>
									</div>

								</div>


								<div class="form-group row">
									<div class="col-lg-6 mt-4 text-center">
                                         <span class="font-size-13 text-muted">
                                              Already have an account?
											<a class="small" href="<?php echo base_url() ?>users/login"> Log in here.</a>
										</span>
									</div>
									<div class="col-lg-6 mt-4">
										<button style="width: 100%;" type="submit" class="btn-submit">&nbsp;&nbsp;&nbsp;Register&nbsp;&nbsp;&nbsp;</button>
									</div>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<div class="offset-md-1 col-md-6 d-none d-md-block">
						<img class="img-fluid" src="assets/images/others/login-2.png" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

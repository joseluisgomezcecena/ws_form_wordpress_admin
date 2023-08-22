<div class="page-header no-gutters">
	<div class="d-md-flex align-items-md-center justify-content-between">
		<div class="media m-v-10 align-items-center">
			<!--
			<div class="avatar avatar-image avatar-lg">
				<img src="assets/images/avatars/thumb-3.jpg" alt="">
			</div>
			-->
			<div class="media-body m-l-15">
				<h4 class="m-b-0">
					Welcome back,
					<?php
					//check if session is set and if it is echo the username
					if($this->session->userdata('logged_in')) {
						echo $this->session->userdata('data')['user_email'];
					}
					?>
				</h4>
				<span class="text-gray">
					<?php
					if ($this->session->userdata('data')['staff'] == 1) {
						echo "Staff";
					} else {
						echo "User";
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
					<h2 class="m-b-0 m-r-5">78</h2>
					<span class="text-gray">Tasks</span>
				</div>
			</div>
			<div class="media align-items-center m-r-40 m-v-5">
				<div class="font-size-27">
					<i class="text-success  anticon anticon-appstore"></i>
				</div>
				<div class="d-flex align-items-center m-l-10">
					<h2 class="m-b-0 m-r-5">21</h2>
					<span class="text-gray">Projects</span>
				</div>
			</div>
			<div class="media align-items-center m-v-5">
				<div class="font-size-27">
					<i class="text-danger anticon anticon-team"></i>
				</div>
				<div class="d-flex align-items-center m-l-10">
					<h2 class="m-b-0 m-r-5">39</h2>
					<span class="text-gray">Members</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card sb-card-shadow">
	<div class="card-body ">
		<h4>Card with Footer</h4>
		<div class="m-t-25">
			<table id="data-table" class="table">
				<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Account</th>
					<th>DOB</th>
					<th>Message</th>
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





is staff: <?php echo $staff; ?>
<br><br/>
database count: <?php echo $database_count; ?>
<br><br/>


<?php for ($i = 1; $i <= $database_count; $i++) { ?>
	<?php echo "result" . $i; ?>
	<br><br/>
	<?php print_r(${'result' . $i}); ?>
	<br><br/>
<?php } ?>



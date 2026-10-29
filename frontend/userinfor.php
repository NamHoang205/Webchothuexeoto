
<!-- User infor	 -->
<section style="background-color: #eee;">
	<div class="container py-5">
		<div class="row">
			<div class="col">
				<nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
						<li class="breadcrumb-item active" aria-current="page">Tài khoản</li>

					</ol>
				</nav>
			</div>
		</div>
		<?php
		$user_id = $_SESSION['login_id'];
		$sql_select_user = mysqli_query($mysqli, "SELECT * FROM quanli_user WHERE user_id = '$user_id'");
		$row_user = mysqli_fetch_array($sql_select_user);
		?>
		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<img src="./images/avatar1.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
						<h5 class="my-3 font-weight-bold"><?php echo $row_user['user_name'] ?></h5>
						<?php 
							if(($_SESSION['login_id'] ==1) && ($_SESSION['login_name'] === 'admin') ) {
						?>
							<p class="mb-1 form-control-lg text-danger">Quản trị viên</p>
						<?php
							}else {

						?>
							<p class="text-muted mb-1">Thành viên bạc</p>
							<p class="text-muted mb-1">Đơn đã mua: 0</p>
							
							<div class="d-flex justify-content-center mb-2">
							<!-- <button type="button" class="btn btn-outline-danger ms-1">Kho Voucher</button> -->
						</div>
						<?php
							}

						?>
					</div>
				</div>
				
			</div>
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Họ tên</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?php echo $row_user['user_name'] ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Email</p>
							</div>
							<div class="col-sm-5">
								<p class="text-muted mb-0"><?php echo $row_user['user_email'] ?></p>
							</div>
							
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Số điện thoại</p>
							</div>
							<div class="col-sm-5">
								<?php
									$fullPhoneNumber = $row_user['user_phone'];
									$maskedPhoneNumber = substr($fullPhoneNumber, 0, -7) . '*******';
								?>
								<p class="text-muted mb-0"><?php echo $maskedPhoneNumber ?></p>
							</div>
							
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Tên tài khoản</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?php echo $row_user['user_name'] ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Mật khẩu</p>
							</div>
							<div class="col-sm-5">
								<?php
									$userPassword = $row_user['user_password'];
									$maskedPassword = str_repeat('*', strlen($userPassword));
								?>
								<p class="text-muted mb-0"><?php echo $maskedPassword ?></p>
							</div>
							<?php
								if(!isset($_SESSION['admin_home'])) {
							?>
							<div class="col-sm-3">
								<a href="index.php?quanli=doimatkhau" class="text-primary mb-0">Thay đổi</a>
							</div>
							<?php
								}
							?>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Đia chỉ</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?php echo $row_user['user_address'] ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4 d-flex">
								<?php
									if(!isset($_SESSION['admin_home'])) {
								?>
								<a href="index.php?quanli=suathongtin" class="btn btn-outline-secondary btn-rounded mb-4" >Sửa hồ sơ</a>
								<a href="index.php?quanli=dondamua" class="btn btn-danger btn-rounded mb-4 ml-2" >Đơn mua</a>
								<?php
									}
								?>		

								<?php 
									if(($_SESSION['login_id'] ==1) && ($_SESSION['login_name'] === 'admin') ) {
								?>
								<a href="./admin/index.php" target="_blank" class="btn btn-success btn-rounded mb-4 ml-2">
									Trang quản trị
								</a>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="my-2 text-right">
					<a href="index.php" class="btn btn-secondary ">Trở về trang chủ</a>
				</div>
			</div>

		</div>

	</div>

</section>


<!-- Modal user -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 text-dark">Sửa hồ sơ</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body mx-3">
				<div class="md-form mb-2">
					<label data-error="wrong" data-success="right" for="orangeForm-name">Họ tên</label>
					<input type="text" id="orangeForm-name" class="form-control validate">

				</div>

				<div class="md-form mb-2">
					<label data-error="wrong" data-success="right" for="orangeForm-pass">Số điện thoại</label>
					<input type="phone_user" id="orangeForm-pass" class="form-control validate">
				</div>
				<div class="md-form mb-2">
					<label data-error="wrong" data-success="right" for="orangeForm-pass">Địa chỉ</label>
					<input type="address_user" id="orangeForm-pass" class="form-control validate">
				</div>
				


			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-danger">Lưu lại</button>
				<button class="btn btn-warning">Reset</button>
			</div>
		</div>
	</div>
</div>
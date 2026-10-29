<?php

//Đăng nhập
if (isset($_POST['login_home'])) {
	$taikhoan = $_POST['email_login'];
	$matkhau = $_POST['password_login'];

	//Lấy dữ liệu từ bảng quan li user
	$select_admin = mysqli_query($mysqli, "SELECT * FROM quanli_user WHERE role='1' ");
	$row_admin = mysqli_fetch_array($select_admin);
	$row_email = $row_admin['user_email'];
	$row_password = $row_admin['user_password'];

	//Lấy dữ liệu từ bảng customer

	if ($taikhoan == '' || $matkhau  == '') {
		echo "<script> alert('Vui lòng nhập đầy đủ tài khoản và password')  </script>";
	} else {
		if (($taikhoan == $row_email) && ($matkhau == $row_password)) {
			$_SESSION['admin_home'] = $row_admin['role'];
			$_SESSION['login_email'] = $row_admin['user_email'];
			$_SESSION['login_name'] = $row_admin['user_name'];
			$_SESSION['login_id'] = $row_admin['user_id'];
			echo "<script> alert('Xin chào Admin bạn đã đăng nhập thành công.'); </script>";
			// window.location.href = './backend/donhang.php';
			
		} else {
			$sql_select_user = mysqli_query($mysqli, "SELECT * FROM quanli_user 
				WHERE user_email= '$taikhoan' AND user_password ='$matkhau' LIMIT 1");
			$count = mysqli_num_rows($sql_select_user);
			$row_dangnhap = mysqli_fetch_array($sql_select_user);
			if ($count > 0) {
				$_SESSION['login_home'] = $row_dangnhap['user_email'];
				$_SESSION['login_name'] = $row_dangnhap['user_name'];
				$_SESSION['login_id'] = $row_dangnhap['user_id'];
				$_SESSION['user_code'] = $row_dangnhap['user_code'];

				$login_name = $_SESSION['login_name'];
				echo "<script> alert('Xin chào $login_name bạn đã đăng nhập thành công.'); window.location.href = 'index.php'; </script>";
			} else {
				echo "<script> alert('Tài khoản hoặc mật khẩu sai') </script>";
			}
		}
	}
}
// Đang ký
elseif (isset($_POST['register'])) {
	$name = $_POST['register_name'];
	$email = $_POST['register_email'];
	$phone = $_POST['register_phone'];
	$address = $_POST['register_address'];
	$password = $_POST['register_password'];
	$user_code = 0;

	if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
		echo "<script> alert('Vui lòng nhập đầy đủ thông tin đăng ký') </script>";
	} else {
		// Nếu dữ liệu hợp lệ, thực hiện câu truy vấn để thêm vào cơ sở dữ liệu
		$sql_user_insert = mysqli_query($mysqli, "INSERT INTO quanli_user(user_name, user_code, user_email, user_phone, user_address, user_password) 
			values ('$name', $user_code, '$email', '$phone', '$address', '$password')");


		if ($sql_user_insert) {
			echo "<script> alert('Đăng ký thành công \n Mời bạn đăng nhập'); window.location.href = 'index.php'; </script>";
		} else {
			echo "<script> alert('Đăng ký thất bại.') </script>";
		}
	}
}

// Đăng xuất
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    // Xóa session
	unset($_SESSION['login_home']);
	unset($_SESSION['login_name']);
	unset($_SESSION['login_id']);
	unset($_SESSION['user_code']);
	unset($_SESSION['admin_home']);
	echo "<script> alert('Đăng xuất thành công.'); window.location.href = 'index.php'; </script>";

    // Dừng thực thi mã PHP sau khi chuyển hướng
    exit;
}
// Phần tìm kiếm tích hợp Ai gợi ý
if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT product_name FROM product WHERE product_name LIKE '%$query%' LIMIT 10";
    $result = mysqli_query($mysqli,$sql);
    while($row = mysqli_fetch_assoc($result)){
        echo "<a href='index.php?quanli=timkiem&seach_product=".urlencode($row['product_name'])."' class='list-group-item list-group-item-action'>".$row['product_name']."</a>";
    }
    exit;
}
?>

<div class="agile-main-top">
    <div class="container-fluid">
        <div class="row main-top-w3l py-2">
            <div class="col-lg-4 header-most-top d-flex align-items-center gap-2">
                <img src="images/logo1.jpg" style="width:40px; height:40px; border-radius:50%;" alt="">
                <p class="text-white text-lg-left text-center mb-0">Đặt thuê xe Online</p>
            </div>
            <div class="col-lg-8 header-right mt-lg-0 mt-2">
                <ul>
                    <li class="text-center border-right text-white">
                        <a href="index.php?quanli=dondamua" class="text-white">
                            <i class="fas fa-file-alt mr-2"></i>Đơn đặt thuê xe</a>
                    </li>
                    <li class="text-center border-right text-white">
                        <i class="fas fa-phone mr-2"></i> 0123456789
                    </li>
                   <?php if (!isset($_SESSION['login_home']) && !isset($_SESSION['admin_home'])): ?>
            <!-- Show login and register only if the user is not logged in -->
            <li class="text-center border-right text-white">
                <a href="#" data-toggle="modal" data-target="#loginModal" class="text-white">
                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập </a>
            </li>
            <li class="text-center text-white">
                <a href="#" data-toggle="modal" data-target="#registerModal" class="text-white">
                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng ký </a>
            </li>
        <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- log in -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center">Đăng nhập</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post">
					<div class="form-group">
						<label class="col-form-label">Email</label>
						<input type="text" class="form-control" placeholder=" " name="email_login" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Mật khẩu</label>
						<input type="password" class="form-control" placeholder=" " name="password_login" required="">
					</div>
					<div class="form-group">
						<a href="index.php?quanli=quenmatkhau" class="text-danger">Quên mật khẩu?</a>
					</div>
					<div class="right-w3l">
						<input type="submit" class="form-control" name="login_home" value="Đăng nhập">
					</div>
					
					<p class="text-center dont-do mt-3">Bạn chưa có tài khoản?
						<a href="#" data-toggle="modal" data-target="#registerModal">
							Đăng ký</a>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Đăng ký</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<div class="form-group">
						<label class="col-form-label">Họ tên</label>
						<input type="text" class="form-control" placeholder=" " name="register_name" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Email</label>
						<input type="email" class="form-control" placeholder=" " name="register_email" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Số điện thoại</label>
						<input type="text" class="form-control" placeholder=" " name="register_phone" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Địa chỉ</label>
						<input type="text" class="form-control" placeholder=" " name="register_address" required="">
					</div>
					<div class="form-group">
						<label class="col-form-label">Mật khẩu</label>
						<input type="password" class="form-control" placeholder=" " name="register_password" required="">
					</div>

					<div class="right-w3l">
						<input type="submit" name="register" class="form-control" value="Đăng ký">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="header-bot">
    <div class="container">
        <div class="row header-bot_inner_wthreeinfo_header_mid d-flex align-items-center justify-content-between">
            <div class="col-md-3 logo_agile">
                <a class="text-center" href="index.php">
                    <img src="images/logo1.jpg" style="z-index: 1000; border-radius:50%;" class="img-fluid" alt="">
                </a>
            </div>
            <div class="col-md-9 header mt-4 mb-md-0 mb-5">
                <div class="row d-flex align-items-center">
                    <div class="col-9">
                        <form class="form-inline position-relative" action="index.php?quanli=timkiem" method="post">
                            <input type="search" id="searchInput" name="seach_product" placeholder="Tìm kiếm sản phẩm..." autocomplete="off" required style="width:100%; padding:10px 15px; border-radius:999px; border:1px solid #ccc; box-shadow:0 2px 5px rgba(0,0,0,0.05); font-size:16px;">
                            <button type="submit" style="position:absolute; right:5px; top:50%; transform:translateY(-50%); background:#007bff; color:#fff; border:none; padding:8px 15px; border-radius:999px; cursor:pointer;">
                                <i class="fas fa-search"></i>
                            </button>
                            <div id="suggestionBox" style="max-height:200px; overflow-y:auto; display:none; position:absolute; top:100%; left:0; width:100%; background:#fff; border:1px solid #ccc; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1); z-index:2000;"></div>
                        </form>
                    </div>
                    <?php 
                        $sql_cart = mysqli_query($mysqli, "SELECT * FROM cart");
                        $countCart = mysqli_num_rows($sql_cart);
                    ?>
                    <div class="col-1 text-center">
                        <form action="?quanli=giohang" method="post">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="display" value="1">
                            <button style="background:none; border:none; position:relative; font-size:18px;" type="submit" name="submit">
                                <i class="fas fa-shopping-cart"></i>
                                <span style="position:absolute; top:-5px; right:-10px; background:red; color:#fff; border-radius:50%; padding:2px 6px; font-size:12px;"><?php echo $countCart ?></span>
                            </button>
                        </form>
                    </div>
                    <div class="col-1 text-center">
                        <?php if (isset($_SESSION['login_home']) || isset($_SESSION['admin_home'])) : ?>
                            <div class="dropdown" style="position:relative;">
                                <button class="btn-user" style="background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:5px;">
                                    <img src="./images/user1.png" width="32px" style="border-radius:50%;">
                                    <?php 
                                    if(isset($_SESSION['login_home'])) {
                                        $username = strstr($_SESSION['login_home'], "@", true);
                                        echo $username ?: 'User';
                                    } else echo 'ADMIN';
                                    ?>
                                </button>
                                <div class="dropdown-menu" style="display:none; position:absolute; right:0; background:#fff; border:1px solid #ccc; border-radius:8px; padding:10px; z-index:2000;">
                                    <a class="dropdown-item" href="?quanli=userinfor">Hồ sơ</a>
                                    <a class="dropdown-item" href="?quanli=dondamua">Đơn đặt thuê xe</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="?logout=1">Đăng xuất</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <button onclick="alert('Vui lòng đăng nhập trước khi sử dụng chức năng này.');"><i class="fas fa-user"></i></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    var query = this.value;
    if(query.length > 0){
        var xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.href, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('suggestionBox').innerHTML = xhr.responseText;
                document.getElementById('suggestionBox').style.display = 'block';
            }
        }
        xhr.send("query=" + encodeURIComponent(query));
    } else {
        document.getElementById('suggestionBox').style.display = 'none';
    }
});
document.querySelectorAll('.btn-user').forEach(btn=>{
    btn.addEventListener('click', function(){
        var menu = this.nextElementSibling;
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });
});
document.addEventListener('click', function(e){
    if(!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
    }
});
</script>

<?php
	session_start();
	$mysqli = new mysqli("localhost","root","","webchothueoto");
	if ($mysqli -> connect_errno) {
		echo "Không thể kết nối với MySQL: " . $mysqli -> connect_error;
		exit();
	}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>SHOP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="SHOP" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="css/fontawesome-all.css">
	<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="css/about.css.css">
	<link rel="stylesheet" href="css/similarproduct.css">

	<link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	
	<style>
		.hero-welcome {
			text-align: center;
			padding: 100px 20px;
			background: linear-gradient(to right, #CD661D, #00c6ff);
			color: #fff;
			font-family: 'Lato', sans-serif;
			border-radius: 15px;
			box-shadow: 0 8px 20px rgba(0,0,0,0.3);
			margin: 30px 0;
		}
		.hero-welcome h1 {
			font-size: 60px;
			font-weight: 900;
			margin-bottom: 20px;
			text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
			animation: fadeInDown 1.5s ease-in-out;
		}
		.hero-welcome p {
			font-size: 24px;
			font-weight: 400;
			text-shadow: 1px 1px 6px rgba(0,0,0,0.2);
			animation: fadeInUp 1.5s ease-in-out;
		}
		@keyframes fadeInDown {
			from { opacity: 0; transform: translateY(-50px); }
			to { opacity: 1; transform: translateY(0); }
		}
		@keyframes fadeInUp {
			from { opacity: 0; transform: translateY(50px); }
			to { opacity: 1; transform: translateY(0); }
		}
	</style>
</head>

<body style="font-family: 'Roboto', sans-serif;">		
	<?php  
		include('./frontend/topbar.php');
		include('./frontend/menu.php');
		include('./frontend/slider.php');

		echo '<div class="hero-welcome">
				<h1>Chào mừng bạn đặt thuê xe của chúng tôi!</h1>
			  </div>';

		if(isset($_GET['quanli'])){
			$temp = $_GET['quanli'];
		}else {
			$temp = '';
		}

		if($temp =='danhmuc') {
			include('./frontend/danhmuc.php');
		}
		elseif($temp =='chitietsp') {
			include('./frontend/chitietsp.php');
			include('./frontend/similarproduct.php');
		}
		elseif($temp =='giohang'){
			include('./frontend/herobg.php');
			include('./frontend/cart.php');
		}
		elseif($temp =='dondamua'){
			include('./frontend/dondamua.php');
		}
		elseif($temp =='chitietdonmua'){
			include('./frontend/chitietdonmua.php');
		}
		elseif($temp =='userinfor'){
			include('./frontend/userinfor.php');
		}
		elseif($temp =='thanhtoan'){
			include('./frontend/thanhtoan.php');
		}
		elseif($temp =='lienhe'){
			include('./frontend/lienhe.php');
		}
		elseif($temp =='gioithieu'){
			include('./frontend/gioithieu.php');
		}
		elseif($temp =='timkiem'){
			include('./frontend/timkiem.php');
		}
		elseif($temp =='doimatkhau'){
			include('./frontend/handleuser/doimatkhau.php');
		}
		elseif($temp =='quenmatkhau'){
			include('./frontend/handleuser/quenmatkhau.php');
		}
		elseif($temp =='suathongtin'){
			include('./frontend/handleuser/edit_user.php');
		}
		elseif($temp =='nhapmaxacnhan'){
			include('./frontend/handleuser/reset_code.php');
		}
		else {
			include('./frontend/home.php');	
		}		
		include('./frontend/footer.php');
	?>

	<script src="js/jquery-2.2.3.min.js"></script>
	<script>
		$(document).ready(function () {
			$(".dropdown").hover(
				function () {
					$('.dropdown-menu', this).stop(true, true).slideDown("fast");
					$(this).toggleClass('open');
				},
				function () {
					$('.dropdown-menu', this).stop(true, true).slideUp("fast");
					$(this).toggleClass('open');
				}
			);
		});
	</script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script>
		$(document).ready(function () {
			$('.popup-with-zoom-anim').magnificPopup({
				type: 'inline',
				fixedContentPos: false,
				fixedBgPos: true,
				overflowY: 'auto',
				closeBtnInside: true,
				preloader: false,
				midClick: true,
				removalDelay: 300,
				mainClass: 'my-mfp-zoom-in'
			});
		});
	</script>
	<script src="js/imagezoom.js"></script>
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
	<script src="js/jquery.flexslider.js"></script>
	<script>
		$(window).load(function () {
			$('.flexslider').flexslider({
				animation: "slide",
				controlNav: "thumbnails"
			});
		});
	</script>
	<script>
		window.onload = function () {
			document.getElementById("password1").onchange = validatePassword;
			document.getElementById("password2").onchange = validatePassword;
		}
		function validatePassword() {
			var pass2 = document.getElementById("password2").value;
			var pass1 = document.getElementById("password1").value;
			if (pass1 != pass2)
				document.getElementById("password2").setCustomValidity("Passwords Don't Match");
			else
				document.getElementById("password2").setCustomValidity('');
		}
	</script>
	<script src="js/scroll.js"></script>
	<script src="js/SmoothScroll.min.js"></script>
	<script src="js/move-top.js"></script>
	<script src="js/easing.js"></script>
	<script>
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<script>
		$(document).ready(function () {
			$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
	<script src="js/bootstrap.js"></script>
</body>
</html>

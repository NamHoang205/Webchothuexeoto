<?php
$thongBao = '';

// Thanh toán và thông tin khách hàng
if (isset($_POST['thanhtoan'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $ngay_thue = $_POST['ngay_muon']; // Ngày bắt đầu thuê
    $ngay_tra = $_POST['ngay_tra'];   // Ngày kết thúc thuê

    if (isset($_SESSION['login_id'])) {
        $user_id = $_SESSION['login_id'];
        if (isset($_SESSION['user_code']) && ($_SESSION['user_code'] == 0)) {
            $user_code = rand(1000, 9999);
        } elseif (isset($_SESSION['user_code']) && ($_SESSION['user_code'] != 0)) {
            $user_code = $_SESSION['user_code'];
        }
    } else {
        $user_id = '';
        $user_code = '';
    }

    // Thêm dữ liệu vào bảng customer
    $sql_khachhang = mysqli_query($mysqli, "INSERT INTO customer(customer_name, user_code, customer_phone, customer_email, customer_address, customer_note) 
        VALUES ('$name', '$user_code', '$phone', '$email', '$address','$note')");

    $sql_quanli_user = mysqli_query($mysqli, "UPDATE quanli_user SET user_code = '$user_code' 
    WHERE user_id = '$user_id'");

    $sql_select_cart = mysqli_query($mysqli, "SELECT * FROM cart ORDER BY cart_id ASC");

    if ($sql_khachhang && $sql_quanli_user) {
        $sql_select = mysqli_query($mysqli, "SELECT * FROM customer ORDER BY customer_id DESC LIMIT 1");
        $row_khachhang = mysqli_fetch_array($sql_select);
        $ngayDatHang = date('Y-m-d');
        $khachhang_id = $row_khachhang['customer_id'];
        $mahang = rand(1000, 9999);

        while ($row_cart = mysqli_fetch_array($sql_select_cart)) {
            $sanpham_id = $row_cart['product_id'];
            
            // Thêm dữ liệu vào bảng donmuon với trạng thái "Đã thuê"
            $sql_donmuon = mysqli_query($mysqli, "INSERT INTO donmuon(product_id, customer_id, soluong, mahang, ngay_muon, ngay_tra, trangThai) 
                VALUES ('$sanpham_id', '$khachhang_id', 1, '$mahang', '$ngay_thue', '$ngay_tra', 'Đã thuê')");

            $sql_giaodich = mysqli_query($mysqli, "INSERT INTO giaodich(khachhang_id, sanpham_id, soluong , magiaodich, ngayThangNam) 
                VALUES ('$khachhang_id','$sanpham_id', 1, '$mahang', '$ngayDatHang')");

            $sql_delete_giohang = mysqli_query($mysqli, "DELETE FROM cart WHERE product_id = '$sanpham_id'");
            $thongBao = 'Thuê xe thành công';
        }

        if (isset($_SESSION['login_id'])) {
            $sql_select_user_code = mysqli_query($mysqli, "SELECT user_code FROM quanli_user WHERE user_id = '$user_id'");
            $row_user_code = mysqli_fetch_array($sql_select_user_code);
            $_SESSION['user_code'] = $row_user_code['user_code'];
        }
    } else {
        $thongBao = 'Thuê xe không thành công';
    }
}
?>

<script>
function validateDates() {
    var ngayThue = document.getElementById("ngay_muon").value;
    var ngayTra = document.getElementById("ngay_tra").value;
    var currentDate = new Date().toISOString().split('T')[0];

    if (ngayThue && ngayTra && ngayThue > ngayTra) {
        alert("Ngày bắt đầu thuê không thể lớn hơn ngày kết thúc");
        return false;
    }

    if (ngayThue && ngayThue < currentDate) {
        alert("Ngày bắt đầu thuê không thể là ngày trong quá khứ");
        return false;
    }
    return true;
}
</script>

<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <?php
            $id_user = $_SESSION['login_id'];
            $sql_select_user = mysqli_query($mysqli, "SELECT * FROM quanli_user WHERE user_id = '$id_user' ");
            $row_user = mysqli_fetch_array($sql_select_user);
            ?>
            <div class="card-body">
                <div class="row d-flex justify-content-center pb-5">
                    <div class="col-md-6 col-xl-5 mb-4 mb-md-0">
                        <div class="py-4 d-flex flex-row">
                            <h5><span class="far fa-check-square pe-2"></span> <b>Thuê xe ô tô</b> </h5>
                        </div>

                        <p class="text-left">
                            <span class="text-danger">Tên: </span><span class="text-dark"><?php echo $row_user['user_name'] ?></span><br>
                            <span class="text-danger">Địa chỉ:</span><span class="text-dark"> <?php echo $row_user['user_address'] ?></span><br>
                            <span class="text-danger">Phone: </span><span class="text-dark"><?php echo $row_user['user_phone'] ?></span>
                        </p>
                        <p class="text-left"><i class="fas fa-plus-circle text-primary pe-1"></i>
                            <a href="index.php?quanli=suathongtin">Thay đổi</a>
                        </p>

                        <hr />
                        <div class="pt-2">
                            <form action="" method="post" class="pb-3" onsubmit="return validateDates()">
                                <input type="hidden" name="name" value="<?php echo $row_user['user_name'] ?>">
                                <input type="hidden" name="phone" value="<?php echo $row_user['user_phone'] ?>">
                                <input type="hidden" name="email" value="<?php echo $row_user['user_email'] ?>">
                                <input type="hidden" name="address" value="<?php echo $row_user['user_address'] ?>">

                                <div class="input-group my-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ghi chú</span>
                                    </div>
                                    <input type="text" name="note" class="form-control" placeholder="Lưu ý với bên cho thuê">
                                </div>

                                <div class="input-group my-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ngày bắt đầu thuê</span>
                                    </div>
                                    <input type="date" name="ngay_muon" class="form-control" id="ngay_muon" required min="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="input-group my-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ngày kết thúc thuê</span>
                                    </div>
                                    <input type="date" name="ngay_tra" class="form-control" id="ngay_tra" required min="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <?php
                                $sql_lay_giohang = mysqli_query($mysqli, "SELECT * FROM cart ORDER BY cart_id DESC");
                                while ($row_thanhtoan = mysqli_fetch_array($sql_lay_giohang)) {
                                ?>
                                    <input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_thanhtoan['product_id'] ?>">
                                <?php
                                }
                                ?>

                                <?php if ($thongBao != '') { ?>
                                    <div class="alert alert-success p-2"> <?php echo $thongBao; ?> </div> 
                                <?php } ?>
                                
                                <?php
                                if ($thongBao != '') {
                                ?>
                                    <a href="index.php?quanli=dondamua" class="btn btn-danger">Đến trang đơn đã thuê</a>
                                <?php
                                } else {
                                ?>
                                    <input type="submit" onclick="return confirm('Bạn có chắc chắn xác nhận thuê xe không ?');" name="thanhtoan" value="Hoàn tất thuê xe" class="btn btn-primary btn-block btn-lg" />
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6 offset-xl-1 rounded">
                        <div class="py-4 d-flex justify-content-end">
                            <h6 class="f-family">
                                <a href="index.php?quanli=giohang">Quay lại lựa chọn xe</a>
                            </h6>
                        </div>

                        <div class="rounded d-flex flex-column p-2" style="background-color: #f8f9fa;">
                            <div class="p-2 me-3">
                                <h4 class="ml-3 f-family">Xe đã chọn</h4>
                            </div>
                            <div class="product-list-payment">
                                <?php
                                $sql_select_cart = mysqli_query($mysqli, "SELECT cart.*, product.price 
                                    FROM cart 
                                    JOIN product ON cart.product_id = product.product_id 
                                    ORDER BY cart.cart_id ASC");
                                while ($row_usercart = mysqli_fetch_array($sql_select_cart)) {
                                ?>
                                    <div class="p-2 border-bottom">
                                        <div><strong><?php echo $row_usercart['product_name'] ?></strong></div>
                                        <div class="text-muted small">
                                            Giá: <span class="text-danger"><?php echo number_format($row_usercart['price'],0,",",".") ?>₫</span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="py-4 d-flex justify-content-end">
                            <h6 class="f-family"><a href="index.php?quanli=giohang">Quay lại lựa chọn xe</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

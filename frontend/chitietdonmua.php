<?php
$thongBao = '';

// Trả xe
if (isset($_POST['tra_xe'])) {
    $maDonHang = $_GET['madonhang'] ?? '';
    $sql_update_donmuon = mysqli_query($mysqli, "UPDATE donmuon SET trangThai = 'Đã trả xe' WHERE mahang = '$maDonHang'");
    $thongBao = $sql_update_donmuon ? "Đã trả xe thành công" : "Trả xe thất bại";
}
?>

<?php
$maDonHang = $_GET['madonhang'] ?? '';

if (isset($_GET['quanli']) && $_GET['quanli'] === 'chitietdonmua') {
    // Lấy chi tiết đơn mượn theo mã đơn
    $sql_chitiet_donmuon = mysqli_query($mysqli, "
        SELECT product.*, customer.*, donmuon.* 
        FROM donmuon
        JOIN product ON donmuon.product_id = product.product_id
        JOIN customer ON donmuon.customer_id = customer.customer_id
        WHERE donmuon.mahang = '$maDonHang'
        ORDER BY donmuon.order_id ASC
    ");
?>
<div class="container py-xl-4 py-lg-2">
    <div class="d-flex justify-content-between">
        <a href="?quanli=dondamua" class="mr-auto">Trở lại</a>
        <h4 class="text-center mb-lg-5 mb-sm-4 mb-3 mr-auto">
            Chi tiết đơn thuê xe: <?php echo $maDonHang ?>
        </h4>
    </div>

    <?php if($thongBao != '') { ?>
        <div class="alert alert-success"><?php echo $thongBao; ?></div>
    <?php } ?>

    <div class="checkout-right">
        <div class="table-responsive">
            <table class="timetable_sub">
                <thead>
                    <tr>
                        <th>Thứ tự</th>
                        <th>Xe</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Ngày thuê</th>
                        <th>Ngày trả</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($row_chitiet = mysqli_fetch_array($sql_chitiet_donmuon)) {
                        $i++;
                    ?>
                    <tr class="rem1">
                        <td class="invert"><?php echo $i ?></td>
                        <td class="invert"><?php echo $row_chitiet['product_name'] ?></td>
                        <td class="invert text-danger"><?php echo number_format($row_chitiet['price'],0,",",".") ?>₫</td>
                        <td class="invert-image">
                            <a href="#1">
                                <img src="images/<?php echo $row_chitiet['product_image'] ?>" alt=" " class="img-responsive">
                            </a>
                        </td>
                        <td class="invert"><?php echo $row_chitiet['ngay_muon'] ?></td>
                        <td class="invert"><?php echo $row_chitiet['ngay_tra'] ?></td>
                        <td class="invert"><?php echo $row_chitiet['trangThai'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

                <?php
                $sql_ct_donmuon = mysqli_query($mysqli, "SELECT * FROM donmuon
                    WHERE mahang = '$maDonHang' GROUP BY mahang
                    ORDER BY order_id ASC");
                ?>
                <tfoot>
                    <tr>
                        <?php while ($row_total = mysqli_fetch_array($sql_ct_donmuon)) { ?>
                        <td colspan="7">
                            <form action="" method="post">
                                <?php
                                // Hiển thị nút Trả xe chỉ khi trạng thái là "Đã thuê"
                                if ($row_total['trangThai'] == 'Đã thuê') {
                                    echo '<input type="submit" onclick="return confirm(\'Bạn có chắc chắn muốn trả xe không?\');" name="tra_xe" class="btn btn-success mr-1" value="Trả xe">';
                                }

                                // Hiển thị trạng thái khác
                                if ($row_total['trangThai'] == 'Chờ duyệt') {
                                    echo '<input type="submit" class="btn btn-info mr-1" value="Chờ duyệt" disabled>';
                                } elseif ($row_total['trangThai'] == 'Đang dọn') {
                                    echo '<input type="submit" class="btn btn-warning mr-1" value="Đang dọn" disabled>';
                                } elseif ($row_total['trangThai'] == 'Còn trống') {
                                    echo '<input type="submit" class="btn btn-secondary mr-1" value="Còn trống" disabled>';
                                }
                                ?>
                                <input type="submit" class="btn btn-secondary" value="Liên hệ công ty" disabled>
                            </form>
                        </td>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php } ?>

<!-- Thông tin thuê xe khách hàng -->
<?php
if (isset($_SESSION['login_home'])) {
    $email = $_SESSION['login_home'];
    $maDonHang = $_GET['madonhang'] ?? '';

    $sql_select_donmuon = mysqli_query($mysqli, "
        SELECT product.*, customer.*, donmuon.*
        FROM donmuon
        JOIN product ON donmuon.product_id = product.product_id
        JOIN customer ON donmuon.customer_id = customer.customer_id
        WHERE customer.customer_email = '$email'
        AND donmuon.mahang = '$maDonHang'
        ORDER BY donmuon.order_id ASC
    ");
}
?>

<div class="container">
    <h4 class="text-center my-4">Thông tin thuê xe</h4>
    <div class="row">
        <?php while ($row_donmuon = mysqli_fetch_array($sql_select_donmuon)) { ?>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row"><div class="col-sm-4">Họ tên</div><div class="col-sm-7"><?php echo $row_donmuon['customer_name'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Số điện thoại</div><div class="col-sm-7"><?php echo $row_donmuon['customer_phone'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Địa chỉ</div><div class="col-sm-7"><?php echo $row_donmuon['customer_address'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Ghi chú</div><div class="col-sm-8"><?php echo $row_donmuon['customer_note'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Xe</div><div class="col-sm-7"><?php echo $row_donmuon['product_name'] ?></div></div>
                        <div class="row"><div class="col-sm-4">Giá thuê</div><div class="col-sm-7 text-danger"><?php echo number_format($row_donmuon['price'],0,",",".") ?>₫</div></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row"><div class="col-sm-4">Mã đơn</div><div class="col-sm-7"><?php echo $row_donmuon['mahang'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Ngày thuê</div><div class="col-sm-7"><?php echo $row_donmuon['ngay_muon'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Ngày trả</div><div class="col-sm-7"><?php echo $row_donmuon['ngay_tra'] ?></div></div><hr>
                        <div class="row"><div class="col-sm-4">Trạng thái</div><div class="col-sm-7"><?php echo $row_donmuon['trangThai'] ?></div></div>
                        <hr>
                        <?php if($row_donmuon['trangThai'] == 'Đã thuê') { ?>
                            <form method="post" onsubmit="return confirm('Bạn có chắc chắn muốn trả xe không?');">
                                <input type="submit" name="tra_xe" class="btn btn-success" value="Trả xe">
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

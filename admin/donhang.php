<?php 
include('../db/connect.php'); 
session_start(); 
include('./common/checkLogin.php'); 
?> 

<?php 
// Cập nhật trạng thái đơn mượn
if (isset($_GET['xac_madonmuon'])) {
    $maDonMuon = $_GET['xac_madonmuon'];
    mysqli_query($mysqli, "UPDATE donmuon SET trangThai = 'Đã đặt' WHERE mahang = '$maDonMuon'");
}

if (isset($_GET['huy_madonmuon'])) {
    $maDonMuon = $_GET['huy_madonmuon'];
    mysqli_query($mysqli, "UPDATE donmuon SET trangThai = 'Đang dọn' WHERE mahang = '$maDonMuon'");
}

if (isset($_GET['huy_xacnhan_madonmuon'])) {
    $maDonMuon = $_GET['huy_xacnhan_madonmuon'];
    mysqli_query($mysqli, "UPDATE donmuon SET trangThai = 'Còn trống' WHERE mahang = '$maDonMuon'");
}

if (isset($_GET['huy_dahuy_madonmuon'])) {
    $maDonMuon = $_GET['huy_dahuy_madonmuon'];
    mysqli_query($mysqli, "UPDATE donmuon SET trangThai = 'Còn trống' WHERE mahang = '$maDonMuon'");
}

// Tự động cập nhật trạng thái "Còn trống" cho các đơn đã hết hạn hoặc hủy
mysqli_query($mysqli, "
    UPDATE donmuon 
    SET trangThai = 'Còn trống' 
    WHERE trangThai NOT IN ('Đã đặt','Đang dọn') 
    OR ngay_tra < CURDATE()
");
?> 

<!DOCTYPE html>
<html lang="en">
<?php include('./common/head.php'); ?>
<body id="page-top">
<div id="wrapper">
    <?php include('./common/sidebar.php'); ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include('./common/topbar.php'); ?>
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <a href="index.php">Dashboard</a><span class="text-dark"> / Quản lí đơn mượn</span>
                        </h6>
                    </div>
                </div>

                <div class="row">
                <?php 
                // Xem chi tiết đơn mượn
                if (isset($_GET['quanli']) && $_GET['quanli'] == 'xemdonmuon') { 
                    $makhachhang = $_GET['makh']; 
                    $sql_chitiet = mysqli_query($mysqli, "SELECT * FROM donmuon
                        JOIN product ON donmuon.product_id = product.product_id
                        JOIN customer ON donmuon.customer_id = customer.customer_id
                        WHERE donmuon.customer_id='$makhachhang'"); 

                    $sql_thongtin = mysqli_query($mysqli, "SELECT * FROM donmuon
                        JOIN product ON donmuon.product_id = product.product_id
                        JOIN customer ON donmuon.customer_id = customer.customer_id
                        WHERE donmuon.customer_id='$makhachhang' LIMIT 1"); 

                    while ($row_thongtin = mysqli_fetch_array($sql_thongtin)) { 
                ?>
                <div class="col-md-12">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="donmuon.php" class="mr-auto">Trở lại</a>
                        <h4 class="py-1 mr-auto">Chi tiết đơn mượn</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row"><div class="col-sm-4"><b>Họ tên</b></div><div class="col-sm-7"><?php echo $row_thongtin['customer_name']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Số điện thoại</b></div><div class="col-sm-7"><?php echo $row_thongtin['customer_phone']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Địa chỉ</b></div><div class="col-sm-7"><?php echo $row_thongtin['customer_address']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Ngày mượn</b></div><div class="col-sm-7"><?php echo $row_thongtin['ngay_muon']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4 text-danger"><b>Ghi chú</b></div><div class="col-sm-8"><b><?php echo $row_thongtin['customer_note']; ?></b></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row"><div class="col-sm-4"><b>Mã đơn</b></div><div class="col-sm-7"><?php echo $row_thongtin['mahang']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Ngày mượn</b></div><div class="col-sm-7"><?php echo $row_thongtin['ngay_muon']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Ngày trả</b></div><div class="col-sm-7 text-danger"><?php echo $row_thongtin['ngay_tra']; ?></div></div><hr>
                                    <div class="row"><div class="col-sm-4"><b>Trạng thái</b></div>
                                        <div class="col-sm-7">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="?huy_xacnhan_madonmuon=<?php echo $row_thongtin['mahang']; ?>" class="btn <?php echo $row_thongtin['trangThai']=='Còn trống'?'btn-warning':'btn-secondary'; ?>">Còn trống</a>
                                                <a href="?xac_madonmuon=<?php echo $row_thongtin['mahang']; ?>" class="btn <?php echo $row_thongtin['trangThai']=='Đã đặt'?'btn-success':'btn-secondary'; ?>">Đã đặt</a>
                                                <a href="?huy_madonmuon=<?php echo $row_thongtin['mahang']; ?>" class="btn <?php echo $row_thongtin['trangThai']=='Đang dọn'?'btn-info':'btn-secondary'; ?>">Đang dọn</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center"><h4 class="py-1 text-center">Xe</h4></div>

                    <table class="table table-bordered text-center">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Hình ảnh</th>
                            <th>Tên xe</th>
                        </tr>
                        <?php 
                        $i = 0; 
                        while ($row_chitiet = mysqli_fetch_array($sql_chitiet)) { 
                            $i++; 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><img src="../images/<?php echo $row_chitiet['product_image']; ?>" alt="image" height="50px"></td>
                            <td><?php echo $row_chitiet['product_name']; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <?php 
                    } // end while thongtin
                } // end if xemdonmuon
                ?>

                <!-- Danh sách đơn mượn -->
                <div class="col-md-12">
                <h4 class="py-1 text-center">Danh sách đơn mượn</h4>

                <table class="table table-bordered text-center">
                <tr>
                    <th>Thứ tự</th>
                    <th>Mã đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày mượn</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>

                <?php
                $productsPerPage = 5; 
                $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1,$_GET['page']) : 1; 
                $begin = ($currentPage - 1) * $productsPerPage;

                $sql_select_donmuon = mysqli_query($mysqli, "SELECT * FROM donmuon
                    JOIN product ON donmuon.product_id = product.product_id
                    JOIN customer ON donmuon.customer_id = customer.customer_id
                    GROUP BY donmuon.mahang
                    ORDER BY donmuon.order_id DESC
                    LIMIT $begin, $productsPerPage");

                $i = 0;
                while ($row_donmuon = mysqli_fetch_array($sql_select_donmuon)) {
                    $i++;
                    $orderNumber = $begin + $i;
                ?>
                <tr>
                    <td><?php echo $orderNumber; ?></td>
                    <td><?php echo $row_donmuon['mahang']; ?></td>
                    <td><?php echo $row_donmuon['customer_name']; ?></td>
                    <td><?php echo $row_donmuon['ngay_muon']; ?></td>
                    <td><?php echo $row_donmuon['ngay_tra']; ?></td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="?huy_xacnhan_madonmuon=<?php echo $row_donmuon['mahang']; ?>" class="btn <?php echo $row_donmuon['trangThai']=='Còn trống'?'btn-warning':'btn-secondary'; ?>">Còn trống</a>
                            <a href="?xac_madonmuon=<?php echo $row_donmuon['mahang']; ?>" class="btn <?php echo $row_donmuon['trangThai']=='Đã đặt'?'btn-success':'btn-secondary'; ?>">Đã đặt</a>
                            <a href="?huy_madonmuon=<?php echo $row_donmuon['mahang']; ?>" class="btn <?php echo $row_donmuon['trangThai']=='Đang dọn'?'btn-info':'btn-secondary'; ?>">Đang dọn</a>
                        </div>
                    </td>
                    <td>
                        <a href="?quanli=xemdonmuon&makh=<?php echo $row_donmuon['customer_id']; ?>" class="btn btn-success btn-sm">Xem</a>
                    </td>
                </tr>
                <?php } ?>
                </table>

                <!-- Phân trang -->
                <?php
                $sql_page = mysqli_query($mysqli, "SELECT * FROM donmuon
                    JOIN product ON donmuon.product_id = product.product_id
                    JOIN customer ON donmuon.customer_id = customer.customer_id
                    GROUP BY donmuon.mahang
                    ORDER BY donmuon.order_id");
                $count_row_page = mysqli_num_rows($sql_page); 
                $page = ceil($count_row_page / $productsPerPage);
                ?>
                <div class="paging d-flex justify-content-center">
                <?php for ($i=1; $i<=$page; $i++) { ?>
                    <a href="?donmuon.php&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php } ?>
                </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container-fluid -->
    </div> <!-- content -->
</div> <!-- content-wrapper -->
</div> <!-- wrapper -->
</body>
</html>

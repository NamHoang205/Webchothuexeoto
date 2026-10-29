<?php
// Get ID from URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else{
    $id = '';
}

// Lấy thông tin sản phẩm (xe)
$sql_chitiet = mysqli_query($mysqli , "SELECT * FROM product WHERE product_id ='$id'" );

// Lấy trạng thái xe mới nhất từ bảng donmuon
$sql_status = mysqli_query($mysqli, "SELECT trangThai FROM donmuon WHERE product_id = '$id' ORDER BY order_id DESC LIMIT 1");
$row_status = mysqli_fetch_array($sql_status);
$trangThai = isset($row_status['trangThai']) ? $row_status['trangThai'] : 'Còn trống';
?>

<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="index.php">Trang chủ</a>
                    <i>|</i>
                </li>
                <li>Chi tiết xe</li>
            </ul>
        </div>
    </div>
</div>

<?php
while($row_chitiet = mysqli_fetch_array($sql_chitiet)) {
?>
<!-- Single Page -->
<div class="banner-bootom-w3-agileits py-5">
    <div class="container py-xl-4 py-lg-2">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-lg-5 col-md-8 single-right-left">
                <div class="grid images_3_of_2">
                    <div class="flexslider">     
                        <ul class="slides">
                            <li data-thumb="images/<?php echo $row_chitiet['product_image'] ?>">
                                <div class="thumb-image">
                                    <img src="images/<?php echo $row_chitiet['product_image'] ?>" data-imagezoom="true" class="img-fluid" alt=""/>
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-lg-7 single-right-left simpleCart_shelfItem">
                <h2 class="mb-1"><?php echo $row_chitiet['product_name'] ?></h2>

                <p class="my-2"><strong>Giá thuê:</strong> <?php echo number_format($row_chitiet['price'],0,",",".") ?> VND</p>
                <p class="my-2"><strong>Trạng thái xe:</strong> 
                    <span class="<?php 
                        echo $trangThai=='Còn trống'?'text-success':($trangThai=='Đã đặt'?'text-danger':'text-info'); 
                    ?>">
                        <?php echo $trangThai; ?>
                    </span>
                </p>

                <div class="product-single-w3l">
                    <p class="my-3"><?php echo $row_chitiet['product_details']; ?></p>
                </div>

                <div class="occasion-cart mt-3 d-flex">
                    <div class="snipcart-details top_brand_home_details item_add single-item d-flex w-100">
                        <form action="?quanli=giohang" method="post" class="d-flex w-100" onsubmit="return checkCarStatus('<?php echo $trangThai; ?>');">
                            <fieldset class="d-flex w-100">
                                <input type="hidden" name="tensanpham" value="<?php echo $row_chitiet['product_name'] ?>" />
                                <input type="hidden" name="sanpham_id" value="<?php echo $row_chitiet['product_id'] ?>" />
                                <input type="hidden" name="hinhanh" value="<?php echo $row_chitiet['product_image'] ?>" />
                                <input type="hidden" name="soluong" value="1"/>

                                <!-- Nút thuê xe -->
                                <?php if($trangThai == 'Còn trống') { ?>
                                    <input type="submit" name="themgiohang" value="Thuê xe" class="btn btn-outline-primary flex-fill mr-2" />
                                <?php } else { ?>
                                    <input type="button" value="Đã được thuê" class="btn btn-secondary flex-fill mr-2" disabled />
                                <?php } ?>
                                <input type="submit" name="themgiohang" value="Đặt thuê ngay" class="btn btn-success flex-fill" />
                            </fieldset>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
}
?>

<!-- CSS -->
<style>
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .btn-outline-primary {
        background-color: transparent;
        border: 2px solid #007bff;
        color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        color: white;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .mr-2 { margin-right: 10px; }
    .text-success { color: green; font-weight: bold; }
    .text-danger { color: red; font-weight: bold; }
    .text-info { color: #17a2b8; font-weight: bold; }
    .flex-fill { flex: 1; }
</style>

<!-- JS thông báo khi xe đã được thuê -->
<script>
function checkCarStatus(status) {
    if(status !== 'Còn trống') {
        alert('Xe này đã được thuê, vui lòng chọn xe khác!');
        return false;
    }
    return true;
}
</script>

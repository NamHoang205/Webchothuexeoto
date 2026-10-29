<?php
// ===== FIX CHÍNH: ĐÚNG TÊN DATABASE =====
$mysqli = new mysqli("localhost", "root", "", "webchothueoto");
if ($mysqli->connect_errno) {
    die("Kết nối thất bại: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Khởi tạo từ khóa tìm kiếm
$tukhoa = "";

// Nhận từ khóa từ form hoặc URL
if (isset($_POST['seach_btn']) && !empty($_POST['seach_product'])) {
    $tukhoa = trim($_POST['seach_product']);
} elseif (isset($_GET['seach_product']) && !empty($_GET['seach_product'])) {
    $tukhoa = trim($_GET['seach_product']);
}

// Nếu không có từ khóa → về trang chủ
if (empty($tukhoa)) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

// Bảo mật từ khóa tìm kiếm
$tukhoa = mysqli_real_escape_string($mysqli, $tukhoa);

// Query tìm kiếm xe
$sql_seach_product = mysqli_query($mysqli, "SELECT * FROM product 
    WHERE product_name LIKE '%$tukhoa%' 
       OR product_details LIKE '%$tukhoa%'
    ORDER BY product_id DESC");

$count_seach = mysqli_num_rows($sql_seach_product);
?>

<!-- Tìm kiếm xe  -->
<div class="ads-grid py-sm-5 py-4">
    <?php if ($count_seach > 0): ?>
        <div class="container py-xl-4 py-lg-2">
            <h3 class="tittle-w3l text-center mb-5 font-weight-bold text-uppercase" style="color:#2c3e50;">
                Kết quả tìm kiếm: <span class="text-danger">"<?php echo htmlspecialchars($tukhoa); ?>"</span>
                <small class="d-block text-muted mt-2">(Tìm thấy <?php echo $count_seach; ?> xe)</small>
            </h3>

            <div class="row">
                <div class="agileinfo-ads-display col-lg-9">
                    <div class="wrapper">
                        <div class="product-sec1 px-sm-4 px-3 py-sm-5 py-3 mb-4">
                            <div class="row">

                                <?php while ($row_product = mysqli_fetch_array($sql_seach_product)):
                                    $product_id = $row_product['product_id'];

                                    // Kiểm tra trạng thái xe mới nhất từ bảng donmuon
                                    $status_query = mysqli_query($mysqli, "SELECT trangThai FROM donmuon 
                                        WHERE product_id = '$product_id' 
                                        ORDER BY order_id DESC LIMIT 1");
                                    $trangThai = 'Còn trống';
                                    if ($status_query && mysqli_num_rows($status_query) > 0) {
                                        $status_row = mysqli_fetch_assoc($status_query);
                                        $trangThai = $status_row['trangThai'];
                                    }
                                    $isBooked = ($trangThai === 'Đã đặt');
                                ?>

                                    <div class="col-md-4 product-men mt-5">
                                        <div class="men-pro-item simpleCart_shelfItem">
                                            <div class="men-thumb-item text-center position-relative">
                                                <img src="images/<?php echo htmlspecialchars($row_product['product_image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($row_product['product_name']); ?>" 
                                                     class="img-fluid product-img-natural">

                                                <?php if($isBooked): ?>
                                                    <span class="badge badge-danger booked-badge">Đã đặt</span>
                                                <?php endif; ?>

                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id']; ?>" 
                                                           class="link-product-add-cart">Xem xe</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item-info-product text-center border-top mt-4 p-3">
                                                <h4 class="pt-1">
                                                    <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id']; ?>">
                                                        <?php echo htmlspecialchars($row_product['product_name']); ?>
                                                    </a>
                                                </h4>

                                                <p class="price-text">
                                                    Giá thuê: <strong><?php echo number_format($row_product['price'],0,",",".") ?> ₫</strong>/ngày
                                                </p>

                                                <p>Trạng thái: 
                                                    <span class="<?php echo $isBooked ? 'text-danger' : 'text-success'; ?> fw-bold">
                                                        <?php echo $trangThai; ?>
                                                    </span>
                                                </p>

                                                <div class="snipcart-details mt-3">
                                                    <form action="?quanli=giohang" method="post"
                                                        onsubmit="<?php if($isBooked) echo 'alert(\"Xe này đã được thuê!\"); return false;'; ?>">
                                                        <fieldset>
                                                            <input type="hidden" name="tensanpham" value="<?php echo $row_product['product_name']; ?>" />
                                                            <input type="hidden" name="sanpham_id" value="<?php echo $row_product['product_id']; ?>" />
                                                            <input type="hidden" name="hinhanh" value="<?php echo $row_product['product_image']; ?>" />
                                                            <input type="hidden" name="soluong" value="1" />
                                                            <input type="submit" name="themgiohang" value="Đặt thuê xe" 
                                                                   class="button btn-book <?php echo $isBooked ? 'disabled' : ''; ?>" 
                                                                   <?php echo $isBooked ? 'disabled' : ''; ?> />
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar tìm kiếm lại -->
                <div class="col-lg-3 mt-lg-0 mt-4">
                    <div class="side-bar p-sm-4 p-3 bg-white rounded shadow-sm">
                        <div class="search-hotel border-bottom py-3">
                            <h3 class="agileits-sear-head mb-3">Tìm kiếm xe</h3>
                            <form action="index.php?quanli=timkiem" method="post">
                                <input type="search" placeholder="Nhập tên xe, hãng xe..." 
                                       name="seach_product" value="<?php echo htmlspecialchars($tukhoa); ?>" 
                                       required class="form-control mb-2" />
                                <button type="submit" name="seach_btn" class="btn btn-danger w-100 rounded-pill">
                                    Tìm kiếm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Không tìm thấy -->
        <div class="container text-center py-5">
            <div class="py-5">
                <i class="fas fa-car-side fa-5x text-muted mb-4"></i>
                <h3 class="text-dark mb-3">Không tìm thấy xe nào</h3>
                <h4 class="text-danger">"<?php echo htmlspecialchars($tukhoa); ?>"</h4>
                <p class="text-muted mt-4">Gợi ý: thử tìm "Toyota", "Honda", "Vios", "Innova"...</p>
                <a href="index.php" class="btn btn-outline-danger btn-lg rounded-pill px-5 mt-3">
                    Về trang chủ
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- CSS ĐẸP - CHUẨN LAYOUT CHÍNH CHỦ -->
<style>
    .product-img-natural {
        max-width: 100%;
        height: auto;
        max-height: 320px;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        background: #fff;
        padding: 10px;
    }
    .product-img-natural:hover { transform: scale(1.05); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }

    .men-pro-item {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .men-pro-item:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        transform: translateY(-5px);
    }

    .price-text { font-size: 18px; color: #e74c3c; font-weight: 600; margin: 10px 0; }
    .btn-book {
        background: #27ae60; color: #fff; border: none; padding: 10px 15px;
        border-radius: 6px; font-weight: 500; width: 100%; transition: all 0.3s ease;
    }
    .btn-book:hover { background: #2ecc71; }
    .btn-book:disabled { background: #ccc; opacity: 0.6; cursor: not-allowed; }

    .booked-badge {
        position: absolute; top: 10px; left: 10px; background: #e74c3c; color: #fff;
        padding: 6px 12px; font-size: 14px; border-radius: 20px; font-weight: 600; z-index: 10;
    }
</style>
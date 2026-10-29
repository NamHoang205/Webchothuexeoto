<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}

// Lấy tên danh mục để hiển thị tiêu đề
$sql_title = mysqli_query($mysqli, "SELECT category_name FROM tbl_category WHERE category_id = '$id' LIMIT 1");
$row_title = mysqli_fetch_array($sql_title);
$title = $row_title ? $row_title['category_name'] : 'Danh mục xe';

// Lấy danh sách xe trong danh mục
$sql_cate = mysqli_query($mysqli, "SELECT * FROM product WHERE category_id = '$id' ORDER BY product_id DESC");
?>

<!-- top Products - Danh mục xe -->
<div class="ads-grid py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">

        <!-- Tiêu đề danh mục -->
        <h3 class="tittle-w3l text-center mb-5 font-weight-bold text-uppercase" style="color:#2c3e50; letter-spacing:1px;">
            <?php echo htmlspecialchars($title); ?>
        </h3>

        <div class="row">
            <!-- Danh sách xe -->
            <div class="agileinfo-ads-display col-lg-9">
                <div class="wrapper">
                    <div class="product-sec1 px-sm-4 px-3 py-sm-5 py-3 mb-4">
                        <div class="row">

                            <?php while ($row_product = mysqli_fetch_array($sql_cate)) { 
                                $product_id = $row_product['product_id'];

                                // Kiểm tra trạng thái thuê xe mới nhất
                                $sql_status = mysqli_query($mysqli, "SELECT trangThai FROM donmuon WHERE product_id = '$product_id' ORDER BY order_id DESC LIMIT 1");
                                $row_status = mysqli_fetch_array($sql_status);
                                $trangThai = isset($row_status['trangThai']) ? $row_status['trangThai'] : 'Còn trống';
                                $isBooked = ($trangThai == 'Đã đặt');
                            ?>

                                <div class="col-md-4 product-men mt-5">
                                    <div class="men-pro-item simpleCart_shelfItem">
                                        <div class="men-thumb-item text-center position-relative">

                                            <!-- Ảnh xe -->
                                            <img src="images/<?php echo $row_product['product_image'] ?>" 
                                                 alt="<?php echo htmlspecialchars($row_product['product_name']) ?>" 
                                                 class="img-fluid product-img-natural">

                                            <!-- Badge trạng thái -->
                                            <?php if($isBooked): ?>
                                                <span class="badge badge-danger booked-badge">Đã đặt</span>
                                            <?php endif; ?>

                                            <div class="men-cart-pro">
                                                <div class="inner-men-cart-pro">
                                                    <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id'] ?>" 
                                                       class="link-product-add-cart">Xem xe</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item-info-product text-center border-top mt-4 p-3">
                                            <h4 class="pt-1">
                                                <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id'] ?>">
                                                    <?php echo htmlspecialchars($row_product['product_name']) ?>
                                                </a>
                                            </h4>

                                            <p class="price-text">
                                                Giá: <strong><?php echo number_format($row_product['price'],0,",",".") ?> VND</strong>
                                            </p>

                                            <p>Trạng thái: 
                                                <span class="<?php echo $trangThai=='Còn trống'?'text-success':'text-danger'; ?>">
                                                    <strong><?php echo $trangThai; ?></strong>
                                                </span>
                                            </p>

                                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out mt-3">
                                                <form action="?quanli=giohang" method="post"
                                                    onsubmit="<?php if($isBooked) echo 'alert(\"Xe này đã được đặt thuê!\"); return false;'; ?>">
                                                    <fieldset>
                                                        <input type="hidden" name="tensanpham" value="<?php echo $row_product['product_name'] ?>" />
                                                        <input type="hidden" name="sanpham_id" value="<?php echo $row_product['product_id'] ?>" />
                                                        <input type="hidden" name="hinhanh" value="<?php echo $row_product['product_image'] ?>" />
                                                        <input type="hidden" name="soluong" value="1" />
                                                        <input type="submit" name="themgiohang" value="Đặt thuê xe" 
                                                               class="button btn-book" <?php if($isBooked) echo 'disabled'; ?> />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- //Danh sách xe -->

            <!-- Sidebar (giữ nguyên đẹp như trang chủ) -->
            <div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
                <div class="side-bar p-sm-4 p-3 bg-white rounded shadow-sm">
                    <div class="customer-rev border-bottom left-side py-3">
                        <h3 class="agileits-sear-head mb-3">Đánh giá khách hàng</h3>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center">
                                <span class="stars mr-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </span>
                                <span><strong>5.0</strong></span>
                            </li>
                        </ul>
                    </div>

                    <div class="left-side border-bottom py-3">
                        <h3 class="agileits-sear-head mb-3">Danh mục xe</h3>
                        <ul class="list-unstyled categories-list">
                            <?php
                            $sql_category_sidebar = mysqli_query($mysqli, 'SELECT * FROM tbl_category ORDER BY category_id ASC');
                            while ($row = mysqli_fetch_array($sql_category_sidebar)) {
                            ?>
                                <li>
                                    <a href="danhmucsp.php?id=<?php echo $row['category_id'] ?>">
                                        <?php echo htmlspecialchars($row['category_name']) ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS chuẩn layout “chính chủ” của bạn -->
<style>
    .product-img-natural {
        max-width: 100%;
        height: auto;
        max-height: 320px;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
        padding: 10px;
    }
    .product-img-natural:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .price-text {
        font-size: 18px;
        color: #e74c3c;
        font-weight: 600;
        margin: 10px 0;
    }
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
    .item-info-product h4 a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }
    .item-info-product h4 a:hover {
        color: #e74c3c;
    }
    .btn-book {
        background: #27ae60;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s ease;
    }
    .btn-book:hover {
        background: #2ecc71;
    }
    .btn-book:disabled {
        background: #ccc !important;
        opacity: 0.6;
        cursor: not-allowed;
    }
    .booked-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #e74c3c;
        color: #fff;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 20px;
        font-weight: 600;
        z-index: 10;
    }
    .categories-list li a {
        color: #333;
        text-decoration: none;
        padding: 6px 0;
        display: block;
        transition: color 0.3s;
    }
    .categories-list li a:hover {
        color: #e74c3c;
    }
</style>
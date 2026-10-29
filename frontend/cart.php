<?php
if (isset($_POST['themgiohang'])) {
    $tensanpham = $_POST['tensanpham'];
    $sanpham_id = $_POST['sanpham_id'];
    $hinhanh = $_POST['hinhanh'];

    // Khi thêm thì mặc định số lượng = 1
    $sql_select_giohang = mysqli_query($mysqli, "SELECT * FROM cart WHERE product_id ='$sanpham_id'");
    $count = mysqli_num_rows($sql_select_giohang);

    if ($count > 0) {
        // Nếu xe đã tồn tại trong giỏ thì không cần cộng dồn nữa
    } else {
        $sql_giohang = "INSERT INTO cart(product_name, product_id, product_image, product_quantity) 
            values ('$tensanpham', '$sanpham_id', '$hinhanh', 1)";
        $insert_row = mysqli_query($mysqli, $sql_giohang);

        if ($insert_row == 0) {
            echo "Lỗi MySQL: " . mysqli_error($mysqli);
            header('Location:index.php?quanli=chitietsp&id=' . $sanpham_id);
        }
    }
} elseif (isset($_GET['xoa'])) {
    $id_cart = $_GET['xoa'];
    $sql_delete = mysqli_query($mysqli, "DELETE FROM cart WHERE cart_id = '$id_cart'");
}
?>

<style>
.table-container {
    max-height: 600px;
    overflow-y: auto;
    position: relative;
}

.timetable_sub thead {
    position: sticky;
    top: 0;
    background-color: #f5f5f5;
}

.timetable_sub tfoot {
    position: sticky;
    bottom: 0;
    background-color: #f5f5f5;
}
</style>

<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Lựa chọn xe của bạn
        </h3>
        <div class="checkout-right">
            <?php
            $sql_laygiohang = mysqli_query($mysqli, "SELECT * FROM cart ORDER BY cart_id ASC");
            ?>
            
            <form action="" method="POST">
                <div class="table-container">
                    <table class="timetable_sub">
                        <thead>
                            <tr>
                                <th>Thứ tự</th>
                                <th>Hình ảnh xe</th>
                                <th>Tên xe</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            while ($row_fetch_giohang = mysqli_fetch_array($sql_laygiohang)) {
                                $i++;
                            ?>
                                <tr class="rem1">
                                    <td class="invert"><?php echo $i ?></td>
                                    <td class="invert-image">
                                        <a href="#">
                                            <img src="images/<?php echo $row_fetch_giohang['product_image'] ?>" alt=" " class="img-responsive">
                                        </a>
                                    </td>
                                    <td class="invert"><?php echo $row_fetch_giohang['product_name'] ?></td>
                                    <td class="invert">
                                        <a href="?quanli=giohang&xoa=<?php echo $row_fetch_giohang['cart_id'] ?>" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <?php
                                    $count_giohang = mysqli_num_rows($sql_laygiohang);
                                    if ($count_giohang > 0) {
                                        // Kiểm tra xem user đã đăng nhập chưa
                                        if (isset($_SESSION['user_code'])) {
                                    ?>
                                            <a href="index.php?quanli=thanhtoan" class="btn btn-danger ml-1">Thuê xe</a>
                                    <?php
                                        } else {
                                    ?>
                                            <span class="text-danger font-weight-normal form-control-lg">
                                                Vui lòng đăng nhập để thuê xe
                                            </span>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <span class="text-danger font-weight-normal form-control-lg">Chưa có xe nào</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </form>
        </div>
        
    </div>
</div>
<!-- //checkout page -->

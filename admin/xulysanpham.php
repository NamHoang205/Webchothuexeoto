<?php
include('../db/connect.php');
session_start();
include('./common/checkLogin.php');

// Thêm (Insert)
if (isset($_POST['themsanpham'])) {
    $tensanpham = mysqli_real_escape_string($mysqli, $_POST['tensanpham']);
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $danhmuc = $_POST['danhmuc'];
    $price = $_POST['price']; // Giá thuê xe
    $path = '../images/';

    // Validate image
    $allowedFormats = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    $fileExt = strtolower(pathinfo($hinhanh, PATHINFO_EXTENSION));
    $fileSize = $_FILES['hinhanh']['size'];
    $allowedSize = 2 * 1024 * 1024; // 2 MB

    if (!in_array($fileExt, $allowedFormats)) {
        $error_message = "Chỉ cho phép tải lên các định dạng JPG, JPEG, PNG, GIF và WEBP.";
    } elseif ($fileSize > $allowedSize) {
        $error_message = "Kích thước ảnh quá lớn. Vui lòng tải lên ảnh < 2 MB.";
    }

    if (isset($error_message)) {
        echo "<script>alert('$error_message')</script>";
    } else {
        $sql_insert_product = "INSERT INTO product(product_name, product_image, category_id, price) 
                               VALUES('$tensanpham', '$hinhanh', '$danhmuc', '$price')";
        if (mysqli_query($mysqli, $sql_insert_product)) {
            move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
            echo "<script>alert('Đã thêm xe: $tensanpham')</script>";
        } else {
            echo "<script>alert('Có lỗi khi thêm xe!')</script>";
        }
    }
}

// Cập nhật (Update)
elseif (isset($_POST['capnhatsanpham'])) {
    $id_update = $_GET['capnhat_id'];
    $tensanpham = mysqli_real_escape_string($mysqli, $_POST['tensanpham']);
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $danhmuc = $_POST['danhmuc'];
    $price = $_POST['price'];
    $path = '../images/';

    // Lấy ảnh cũ nếu không chọn ảnh mới
    $sql_old = mysqli_query($mysqli, "SELECT product_image FROM product WHERE product_id='$id_update'");
    $row_old = mysqli_fetch_array($sql_old);
    $image_to_save = $row_old['product_image'];

    if (!empty($hinhanh)) {
        $allowedFormats = ['jpg','jpeg','png','gif','webp'];
        $fileExt = strtolower(pathinfo($hinhanh, PATHINFO_EXTENSION));
        $fileSize = $_FILES['hinhanh']['size'];
        $allowedSize = 2*1024*1024;
        if (in_array($fileExt, $allowedFormats) && $fileSize <= $allowedSize) {
            if (move_uploaded_file($hinhanh_tmp, $path . $hinhanh)) {
                $image_to_save = $hinhanh;
            }
        }
    }

    $sql_update_product = "UPDATE product SET product_name='$tensanpham', product_image='$image_to_save', 
                           category_id='$danhmuc', price='$price' 
                           WHERE product_id='$id_update'";
    if (mysqli_query($mysqli, $sql_update_product)) {
        header('Location: xulysanpham.php');
        exit();
    } else {
        echo "<script>alert('Có lỗi khi cập nhật xe!')</script>";
    }
}

// Xóa (Delete)
if (isset($_GET['xoa'])) {
    $id_xoa = $_GET['xoa'];
    $sql_xoa = "DELETE FROM product WHERE product_id = '$id_xoa'";
    if (mysqli_query($mysqli, $sql_xoa)) {
        echo "<script>alert('Đã xóa xe!'); window.location='xulysanpham.php';</script>";
    } else {
        echo "<script>alert('Có lỗi khi xóa xe!')</script>";
    }
}

/* ----------- PHÂN TRANG THÊM Ở ĐÂY --------- */
$limit = 5; // Số xe mỗi trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// Lấy tổng số dòng
$result_count = mysqli_query($mysqli, "SELECT COUNT(*) AS total FROM product");
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Tính tổng số trang
$total_pages = ceil($total_records / $limit);

// Tính OFFSET
$offset = ($current_page - 1) * $limit;

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
                            <a href="index.php">Dashboard</a><span class="text-dark"> / Quản lí xe ô tô</span>
                        </h6>
                    </div>
                </div>

                <div class="row mb-5">
                    <?php
                    if (isset($_GET['quanli']) && $_GET['quanli'] == 'capnhat') {
                        $id_capnhat = $_GET['capnhat_id'];
                        $sql_capnhat = mysqli_query($mysqli, "SELECT * FROM product WHERE product_id='$id_capnhat'");
                        $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    ?>
                        <div class="col-lg-10">
                            <h4 class="py-1 text-center">Cập nhật xe ô tô</h4>
                            <form class="row" action="" method="post" enctype="multipart/form-data">
                                <div class="col-lg-6">
                                    <label>Tên xe</label>
                                    <input type="text" class="form-control" name="tensanpham" value="<?php echo $row_capnhat['product_name'] ?>" required>

                                    <label>Hình ảnh xe</label>
                                    <input type="file" class="form-control" name="hinhanh">
                                    <?php if(!empty($row_capnhat['product_image'])){ ?>
                                        <img style="max-width: 100px; margin-top:5px;" src="../images/<?php echo $row_capnhat['product_image']; ?>" alt="">
                                    <?php } ?>

                                    <label>Loại xe</label>
                                    <?php $sql_danhmuc = mysqli_query($mysqli, "SELECT * FROM tbl_category ORDER BY category_id ASC"); ?>
                                    <select class="form-control" name="danhmuc" required>
                                        <option value="">Chọn loại xe</option>
                                        <?php while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) { ?>
                                            <option value="<?php echo $row_danhmuc['category_id'] ?>" <?php if($row_capnhat['category_id'] == $row_danhmuc['category_id']) echo 'selected'; ?>>
                                                <?php echo $row_danhmuc['category_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <label>Giá thuê (VNĐ)</label>
                                    <input type="number" class="form-control" name="price" value="<?php echo $row_capnhat['price'] ?>" required>

                                    <input type="submit" name="capnhatsanpham" value="Cập nhật xe" class="btn btn-success my-3" style="width: 200px;">
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <a href="themsanpham.php" class="btn btn-success"><i class="fas fa-plus"></i> Thêm xe</a>
                                <h4 class="py-1 mr-auto">Danh sách xe ô tô</h4>
                            </div>

                            <table class="table table-bordered">
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Tên xe</th>
                                    <th>Hình ảnh</th>
                                    <th>Loại xe</th>
                                    <th>Giá thuê (VNĐ)</th>
                                    <th>Trạng thái xe</th>
                                    <th>Thao tác</th>
                                </tr>
                                <?php
                                $sql_select_sp = "SELECT p.product_id, p.product_name, p.product_image, p.price, c.category_name,
                                    (SELECT d.trangThai FROM donmuon d WHERE d.product_id = p.product_id ORDER BY d.order_id DESC LIMIT 1) AS trangThai
                                    FROM product p
                                    JOIN tbl_category c ON p.category_id = c.category_id
                                    ORDER BY p.product_id ASC LIMIT $limit OFFSET $offset";
                                $result = mysqli_query($mysqli, $sql_select_sp);
                                $i = $offset;
                                while ($row = mysqli_fetch_array($result)) {
                                    $i++;
                                ?>
                                    <tr class="text-center">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['product_name'] ?></td>
                                        <td>
                                            <?php if(!empty($row['product_image'])){ ?>
                                                <img style="max-width: 100px;" src="../images/<?php echo $row['product_image'] ?>" alt="">
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $row['category_name'] ?></td>
                                        <td><?php echo number_format($row['price'],0,',','.'); ?></td>
                                        <td><?php echo $row['trangThai'] ?? 'Sẵn sàng'; ?></td>
                                        <td>
                                            <a href="?xoa=<?php echo $row['product_id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa xe không?')">Xóa</a>
                                            <a href="xulysanpham.php?quanli=capnhat&capnhat_id=<?php echo $row['product_id'] ?>" class="btn btn-warning">Sửa</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>

                            <!-- ========= NÚT PHÂN TRANG ========== -->
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center">
                                <?php if($current_page > 1){ ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page-1 ?>">Previous</a></li>
                                <?php } ?>

                                <?php for($num = 1; $num <= $total_pages; $num++){ ?>
                                    <li class="page-item <?php if($num == $current_page) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $num ?>"><?php echo $num ?></a>
                                    </li>
                                <?php } ?>

                                <?php if($current_page < $total_pages){ ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page+1 ?>">Next</a></li>
                                <?php } ?>
                              </ul>
                            </nav>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
<?php include('./common/modal.php'); ?>
</body>
</html>

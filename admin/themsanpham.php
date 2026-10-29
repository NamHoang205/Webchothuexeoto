<?php
include('../db/connect.php');
session_start();
include('./common/checkLogin.php');
?>

<?php
if (isset($_POST['themsanpham'])) {
    $tensanpham = mysqli_real_escape_string($mysqli, $_POST['tensanpham']);
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $danhmuc = $_POST['danhmuc'];
    $price = $_POST['price']; 
    $path = '../images/';

    // Validate image
    $allowedFormats = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    $fileExt = strtolower(pathinfo($hinhanh, PATHINFO_EXTENSION));
    if (!in_array($fileExt, $allowedFormats)) {
        echo "<script> alert('Chỉ cho phép các định dạng JPG, JPEG, PNG, GIF, WEBP.') </script>";
    } else {
        $allowedSize = 2 * 1024 * 1024; // 2 MB
        $fileSize = $_FILES['hinhanh']['size'];
        if ($fileSize > $allowedSize) {
            echo "<script> alert('Kích thước ảnh quá lớn. Vui lòng tải ảnh < 2MB.') </script>";
        } else {
            $sql_insert = "INSERT INTO product(product_name, product_image, category_id, price) 
                           VALUES('$tensanpham', '$hinhanh', '$danhmuc', '$price')";
            if (mysqli_query($mysqli, $sql_insert)) {
                move_uploaded_file($hinhanh_tmp, $path . $hinhanh);
                echo "<script> alert('Đã thêm xe: $tensanpham') </script>";
                header('Location: xulysanpham.php');
                exit();
            } else {
                echo "<script> alert('Có lỗi khi thêm xe!') </script>";
            }
        }
    }
}
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
                            <a href="index.php">Dashboard</a> <span class="text-dark"> / </span>
                            <a href="xulysanpham.php">Quản lí xe</a>
                            <span class="text-dark"> / Thêm xe</span>
                        </h6>
                    </div>
                </div>

                <div class="col-lg-10 col-lg-12 mb-5">
                    <h4 class="py-1 text-center">Thêm xe ô tô cho thuê</h4>
                    <form class="row" action="" method="post" enctype="multipart/form-data">
                        <div class="col-1"></div>
                        <div class="col-lg-5">

                            <label>Tên xe ô tô</label>
                            <input type="text" class="form-control" name="tensanpham" placeholder="Ví dụ: Toyota Vios 2024" required>

                            <label>Hình ảnh xe</label>
                            <input type="file" class="form-control" name="hinhanh" required>

                            <?php $sql_danhmuc = mysqli_query($mysqli, "SELECT * FROM tbl_category ORDER BY category_id ASC"); ?>
                            <label>Loại xe</label>
                            <select class="form-control" name="danhmuc" required>
                                <option value="">Chọn loại xe</option>
                                <?php while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) { ?>
                                    <option value="<?php echo $row_danhmuc['category_id'] ?>">
                                        <?php echo $row_danhmuc['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <label>Giá thuê (VNĐ/Ngày)</label>
                            <input type="number" class="form-control" name="price" placeholder="Nhập giá thuê (VD: 800000)" required>

                            <input type="submit" name="themsanpham" value="Thêm xe" class="btn btn-success my-2" style="width: 200px;">
                        </div>
                        <div class="col-6"></div>
                        <div class="col-1"></div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
<?php include('./common/modal.php'); ?>
</body>
</html>

<?php
    include('../db/connect.php');
    session_start();
    include('./common/checkLogin.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php include('./common/head.php') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
        <?php include('./common/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('./common/topbar.php'); ?>

                <!-- User infor	 -->
                <section style="background-color: #eee;">
                    <div class="container py-5">
                        <div class="row">
                            <div class="col">
                                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <?php
                        $user_id_admin = $_SESSION['login_admin_id'] ?? null;
                        $row_user = null;

                        if ($user_id_admin) {
                            $sql_select_user = mysqli_query(
                                $mysqli,
                                "SELECT * FROM quanly_taikhoan WHERE user_id = '$user_id_admin'"
                            );
                            if ($sql_select_user && mysqli_num_rows($sql_select_user) > 0) {
                                $row_user = mysqli_fetch_array($sql_select_user);
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img src="../images/avatar1.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                        <h5 class="my-3 font-weight-bold">
                                            <?= $row_user['user_name'] ?? 'Chưa cập nhật'; ?>
                                        </h5>
                                        <p class="mb-1 form-control-lg text-danger">
                                            <?= (isset($row_user['role']) && $row_user['role'] == 1) ? 'Quản trị viên' : 'Nhân viên'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Họ tên</p></div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row_user['user_name'] ?? 'Chưa cập nhật'; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Email</p></div>
                                            <div class="col-sm-5">
                                                <p class="text-muted mb-0"><?= $row_user['user_email'] ?? 'Chưa cập nhật'; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Số điện thoại</p></div>
                                            <div class="col-sm-5">
                                                <?php
                                                if (!empty($row_user['user_phone'])) {
                                                    $fullPhoneNumber = $row_user['user_phone'];
                                                    $maskedPhoneNumber = substr($fullPhoneNumber, 0, -7) . '*******';
                                                    echo "<p class='text-muted mb-0'>$maskedPhoneNumber</p>";
                                                } else {
                                                    echo "<p class='text-muted mb-0'>Chưa cập nhật</p>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Tên tài khoản</p></div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row_user['user_code'] ?? 'Chưa cập nhật'; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Mật khẩu</p></div>
                                            <div class="col-sm-5">
                                                <?php
                                                if (!empty($row_user['user_password'])) {
                                                    $userPassword = $row_user['user_password'];
                                                    $maskedPassword = str_repeat('*', strlen($userPassword));
                                                    echo "<p class='text-muted mb-0'>$maskedPassword</p>";
                                                } else {
                                                    echo "<p class='text-muted mb-0'>Chưa cập nhật</p>";
                                                }
                                                ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="change_admin_password.php" class="text-primary mb-0">Thay đổi</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3"><p class="mb-0">Địa chỉ</p></div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row_user['user_address'] ?? 'Chưa cập nhật'; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6 d-flex">
                                                <a href="./edit_admin.php" class="btn btn-outline-secondary btn-rounded mb-4">Sửa hồ sơ</a>
                                                <?php if (($user_id_admin == 1) && ($_SESSION['login_name'] === 'admin')) { ?>
                                                    <a href="../index.php" target="_blank" class="btn btn-success btn-rounded mb-4 ml-2">Trở về Website</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-2 text-right">
                                    <a href="index.php" class="btn btn-secondary ">Trở về trang chủ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Modal user -->
                <div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 text-dark">Sửa hồ sơ</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="md-form mb-2"><label>Họ tên</label><input type="text" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Email</label><input type="text" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Số điện thoại</label><input type="text" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Địa chỉ</label><input type="text" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Tên tài khoản</label><input type="text" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Mật khẩu cũ</label><input type="password" class="form-control validate"></div>
                                <div class="md-form mb-2"><label>Mật khẩu mới</label><input type="password" class="form-control validate"></div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-danger">Lưu lại</button>
                                <button class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <?php include('./common/footer.php') ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal-->
    <?php include('./common/modal.php') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

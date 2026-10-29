<?php
include('../db/connect.php');
session_start();
include('./common/checkLogin.php');
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./common/head.php'); ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('./common/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('./common/topbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Quản lý Thuê Xe Ôtô</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Đơn thuê xe -->
                        <?php
                        $sql_select_orders = mysqli_query($mysqli, "SELECT * FROM donmuon GROUP BY mahang");
                        $count_orders = mysqli_num_rows($sql_select_orders);
                        ?>
                        <a href="donhang.php" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Đơn thuê xe</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_orders ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-car fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Tổng số lượng xe thuê -->
                        <?php
                        $total_revenue = 0;
                        $sql_select_orders = mysqli_query($mysqli, "SELECT * FROM donmuon GROUP BY mahang");
                        while($row = mysqli_fetch_array($sql_select_orders)) {
                            $total_revenue += $row['soluong']; // Giả sử mỗi số lượng đại diện cho 1 xe
                        }
                        ?>
                        <a href="#" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tổng số lượng xe thuê
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_revenue ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Khách hàng -->
                        <?php
                        $sql_select_customers = mysqli_query($mysqli, "SELECT * FROM customer");
                        $count_customers = mysqli_num_rows($sql_select_customers);
                        ?>
                        <a href="customer.php" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Khách hàng
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_customers ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Đơn chờ xử lý -->
                        <?php
                        $sql_pending_orders = mysqli_query($mysqli, "SELECT * FROM donmuon WHERE trangThai = 0 GROUP BY mahang");
                        $count_pending = mysqli_num_rows($sql_pending_orders);
                        ?>
                        <a href="unconfirmed_order.php" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Đơn chờ duyệt
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_pending ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div> <!-- End Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include('./common/footer.php'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include('./common/modal.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

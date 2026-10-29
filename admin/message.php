<?php
include('../db/connect.php');
?>
<?php
    include('../db/connect.php');
    session_start();
    include('./common/checkLogin.php')
?>
<!DOCTYPE html>
<html lang="en">

<?php
    include('./common/head.php')
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
        <?php
        include('./common/sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include('./common/topbar.php');
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tin nhắn khách hàng</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-envelope fa-fw"></i>
                            Soạn tin nhắn
                        </a>
                    </div>

                    <table class="table table-bordered col-6">

                        <tr class="text-center">
                            <th>Tên khách hàng</th>
                            <th>Thời gian</th>
                            <th>Quản lí</th>


                        </tr>

                        <tr class="text-center">
                            <td>
                                Nguyễn Văn B
                            </td>
                            <td>
                                20:30 05/07/2023
                            </td>
                            <td>
                                <a href="" class="btn btn-success">Xem </a>
                                <a href="" class="btn btn-danger">Xóa </a>
                            </td>

                        </tr>
                        <tr class="text-center">
                            <td>
                                Nguyễn Văn A
                            </td>
                            <td>
                                20:30 05/07/2023
                            </td>
                            <td>
                                <a href="" class="btn btn-success">Xem </a>
                                <a href="" class="btn btn-danger">Xóa </a>
                            </td>

                        </tr>
                        <tr class="text-center">
                            <td>
                                Nguyễn Lê Anh Khoa
                            </td>
                            <td>
                                20:30 05/07/2023
                            </td>
                            <td>
                                <a href="" class="btn btn-success">Xem </a>
                                <a href="" class="btn btn-danger">Xóa </a>
                            </td>

                        </tr>



                    </table>



                </div>
                <!-- /.container-fluid -->



            </div>
            <!-- End of Main Content -->

            <?php
            include('./common/footer.php')
            ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php
        include('./common/modal.php')
    ?>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
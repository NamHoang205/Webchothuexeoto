<?php  
	$sql_category = mysqli_query($mysqli, 'SELECT * FROM tbl_category ORDER BY category_id ASC');

    $current_page = '';
    if(isset($_GET['quanli'])){
        if($_GET['quanli'] == 'danhmuc' && isset($_GET['id'])){
            $current_page = 'danhmuc_'.$_GET['id'];
        } else {
            $current_page = $_GET['quanli'];
        }
    } else {
        $current_page = 'trangchu';
    }
?>	
<style>
.topheader .nav-link.active {
    font-weight: bold;
    color: #ff0000; /* đổi màu đỏ khi active */
}
</style>
<div class="navbar-inner topheader">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center mr-xl-5">
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link <?php echo ($current_page == 'trangchu') ? 'active' : ''; ?>" href="index.php">Trang chủ</a>
                    </li>
                    <?php
                    $sql_category_danhmuc = mysqli_query($mysqli, 'SELECT * FROM tbl_category ORDER BY category_id ASC');
                    while ($row_category_danhmuc = mysqli_fetch_array($sql_category_danhmuc)) {
                        $category_class = ($current_page == 'danhmuc_'.$row_category_danhmuc['category_id']) ? 'active' : '';
                    ?>
                        <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link <?php echo $category_class; ?>" href="?quanli=danhmuc&id=<?php echo $row_category_danhmuc['category_id']?>" role="button">
                                <?php echo $row_category_danhmuc['category_name']; ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link <?php echo ($current_page == 'gioithieu') ? 'active' : ''; ?>" href="?quanli=gioithieu">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'lienhe') ? 'active' : ''; ?>" href="?quanli=lienhe">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

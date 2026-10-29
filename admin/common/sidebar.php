<style>
    .bg-white {
        background-color: white;
    }
    .rounded {
        border-radius: 5px;
    }
    .mx-2 {
        margin-left: 10px;
        margin-right: 10px;
    }
    .text-black {
        color: black;
    }
</style>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-black sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Quản trị</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Thống kê & báo cáo</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Quản lý Đơn thuê xe -->
    <li class="nav-item">
        <a class="nav-link" href="donhang.php">
            <i class="fas fa-fw fa-car-side"></i>
            <span>Quản lý Đơn thuê xe</span>
        </a>
    </li>
    
    <!-- Quản lý Xe -->
    <li class="nav-item">
        <a class="nav-link" href="xulysanpham.php">
            <i class="fas fa-fw fa-car"></i>
            <span>Quản lý Xe</span>
        </a>
    </li>

    <!-- Quản lý Khách hàng -->
    <li class="nav-item">
        <a class="nav-link" href="customer.php">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Quản lý Khách hàng</span>
        </a>
    </li>

    <!-- Quản lý danh mục -->
    <li class="nav-item">
        <a class="nav-link" href="xulydanhmuc.php">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Quản lý danh mục</span>
        </a>
    </li>

    <!-- Quản lý Tài khoản -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_user_page" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Quản lý Tài khoản</span>
        </a>
        <div id="collapse_user_page" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tùy chọn khác</h6>
                <a class="collapse-item" href="taikhoan_admin.php">Admin</a>
                <a class="collapse-item" href="taikhoan_khachhang.php">Khách hàng</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Đăng xuất -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-fw"></i>
            <span class="text-primary nav-item">Đăng xuất</span>
        </a>
    </li>

</ul>

<script>
    // Highlight trang hiện tại
    var currentPageUrl = window.location.href;
    var navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(function(link) {
        var linkUrl = link.href;

        // Nếu URL hiện tại chứa link href
        if (currentPageUrl.includes(linkUrl)) {
            link.parentElement.classList.add("bg-white", "rounded", "mx-2", "text-black");

            var iconElement = link.querySelector("i");
            var categoryName = link.querySelector("span");

            if (iconElement) iconElement.classList.add("text-black");
            if (categoryName) categoryName.classList.add("text-black");
        }
    });
</script>

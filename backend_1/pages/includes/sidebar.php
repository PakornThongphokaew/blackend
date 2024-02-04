<?php
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("pages", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto ">
        <li class="nav-item d-md-none d-block">
            <a href="../dashboard/">
                <img src="../../assets/images/AdminLogo.png" alt="Admin Logo" width="50px" class="img-circle elevation-3">
                <span class="font-weight-light pl-1"></span>
            </a>
        </li>
        <li class="nav-item d-md-block d-none">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['OW_LOGIN'] ?> </a>
        </li>
    </ul>
</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../assets/images/fishlogo3.webp" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="../owner/" class="d-block"> <?php echo $_SESSION['OW_FULLNAME'] ?> </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="../dashboard/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <br>

                <li class="nav-header">ข้อมูลพื้นฐาน</li>
                <!-- <li class="nav-item">
                    <a href="../owner/" class="nav-link <?php echo isActive('owner') ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>ข้อมูลเจ้าของร้าน</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="../customer/" class="nav-link <?php echo isActive('customer') ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>จัดการข้อมูลลูกค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../pond/" class="nav-link <?php echo isActive('pond') ?>">
                        <i class="nav-icon fas fa-water"></i>
                        <p>จัดการข้อมูลบ่อตกปลา</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../booth/" class="nav-link <?php echo isActive('booth') ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>จัดการข้อมูลซุ้ม</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../product/" class="nav-link <?php echo isActive('product') ?>">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>จัดการข้อมูลสินค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../product_type/" class="nav-link <?php echo isActive('product_type') ?>">
                        <i class="nav-icon fas fa-caret-right"></i>
                        <p>จัดการข้อมูลประเภทสินค้าย่อย</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../product_category/" class="nav-link <?php echo isActive('product_category') ?>">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>จัดการข้อมูลประเภทสินค้า</p>
                    </a>              
                <Br>

                <li class="nav-header">รายการ</li>
                <li class="nav-item">
                    <a href="../booking/" class="nav-link <?php echo isActive('booking') ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>View การจอง</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../payment/" class="nav-link <?php echo isActive('products') ?>">
                        <i class="fas fa-money-bill-alt"></i>
                        <p>ข้อมูลการโอนมัดจำ</p>
                    </a>
                <!-- </li>
                <li class="nav-item">
                    <a href="../orders/" class="nav-link <?php echo isActive('orders') ?>">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>ออเดอร์อาหาร</p>
                    </a>
                </li> -->
                <br>

                <!-- <li class="nav-header">รายการ</li> -->
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
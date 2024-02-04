<?php
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลประเภทสินค้า</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="nav-icon fas fa-shopping-basket"></i>
                                        เพิ่มข้อมูลประเภทสินค้า
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-arrow-left"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="pdcategory_id">รหัสประเภทสินค้า</label>
                                                    <input type="text" class="form-control" name="pdcategory_id" id="pdcategory_id" placeholder="รหัสประเภทสินค้า" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pdcategory_name">ชื่อประเภทสินค้า</label>
                                                    <input type="text" class="form-control" name="pdcategory_name" id="pdcategory_name" placeholder="ชื่อประเภทสินค้า" required>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="insert">บันทึกข้อมูล</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST', // Updated type to 'POST'
                    url: '../../service/product_category/create.php',
                    data: new FormData(this), // Use FormData to handle file uploads
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(resp) {
                        if (resp.status) {
                            // Success: Show success message and redirect
                            Swal.fire({
                                text: 'เพิ่มข้อมูลเรียบร้อย',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                            }).then((result) => {
                                location.assign('./');
                            });
                        } else {
                            // Error: Show error message
                            Swal.fire({
                                text: resp.message,
                                icon: 'error',
                                confirmButtonText: 'ตกลง',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // AJAX request failed: Show error message
                        Swal.fire({
                            text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
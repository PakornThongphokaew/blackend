<?php

require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการข้อมูลลูกค้า</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
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
                            <div class="card">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="nav-icon fas fa-user"></i>
                                        เพิ่มข้อมูลลูกค้า
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-arrow-left"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <div class="card-body">
                                        <div class="form-row">   
                                            <div class="form-group col-md-12">
                                                <label for="cus_email">อีเมล</label>
                                                <input type="text" class="form-control" name="cus_email" id="cus_email" placeholder="อีเมล">
                                            </div>                 
                                            <div class="form-group col-md-12">
                                                <label for="cus_password">รหัสผ่าน</label>
                                                <input type="text" class="form-control" name="cus_password" id="cus_password" placeholder="รหัสผ่าน">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cus_fullname">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control" name="cus_fullname" id="cus_fullname" placeholder="ชื่อ-นามสกุล">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cus_tel">เบอร์โทร</label>
                                                <input type="text" class="form-control" name="cus_tel" id="cus_tel" placeholder="เบอร์โทร">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cus_address">ที่อยู่</label>
                                                <input type="text" class="form-control" name="cus_address" id="cus_address" placeholder="ที่อยู่">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-75" name="submit">บันทึกข้อมูล</button>
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

    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $('#details').summernote({
                height: 300,
            });
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../../service/customer/create.php',
                    data: $('#formData').serialize()
                }).done(function(resp) {
                    if (resp.status) {
                        // Success: Show success message and redirect
                        Swal.fire({
                            text: 'เพิ่มข้อมูลเรียบร้อย',
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).
                        then((result) => {
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
                }).fail(function(xhr, status, error) {
                    // AJAX request failed: Show error message
                    Swal.fire({
                        text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                });
            })
        });
    </script>
</body>

</html>
<?php
    require_once('../authen.php');
    $cus_email = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM customer WHERE cus_email = :cus_email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cus_email', $cus_email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($result);
    // return;
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
                                        แก้ไขข้อมูลลูกค้า
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
                                                <input type="text" class="form-control" name="cus_email" id="cus_email" placeholder="อีเมล" value="<?= $result['cus_email']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cus_fullname">ชื่อ-นามสกุลลูกค้า</label>
                                                <input type="text" class="form-control" name="cus_fullname" id="cus_fullname" placeholder="ชื่อ-นามสกุลลูกค้า" value="<?= $result['cus_fullname']; ?>">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="cus_tel">เบอร์โทร</label>
                                                <input type="text" class="form-control" name="cus_tel" id="cus_tel" placeholder="เบอร์โทร" value="<?= $result['cus_tel']; ?>">
                                            </div>                                          
                                            <div class="form-group col-md-12">
                                                <label for="cus_address">ที่อยู่</label>
                                                <input type="text" class="form-control" name="cus_address" id="cus_address" placeholder="ที่อยู่" value="<?= $result['cus_address']; ?>">
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
                height: 500,
            });
            $('#formData').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '../../service/customer/update.php',
                    contentType: 'application/json', // เพิ่ม content type เป็น JSON
                    data: JSON.stringify({
                        cus_fullname: $('#cus_fullname').val(),
                        cus_tel: $('#cus_tel').val(),
                        cus_address: $('#cus_address').val(),
                        cus_email: $('#cus_email').val(),
                    })
                }).done(function(resp) {
                    Swal.fire({
                        text: 'อัพเดทข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign('./');
                    });
                });
            });
        });
    </script>
</body>

</html>
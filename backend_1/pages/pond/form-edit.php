<?php
require_once('../authen.php');
$pond_id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM pond WHERE pond_id = :pond_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':pond_id', $pond_id, PDO::PARAM_STR);
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
    <title>จัดการข้อมูลบ่อตกปลา</title>
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
                                        <i class="nav-icon fas fa-water"></i>
                                        แก้ไขข้อมูลบ่อตกปลา
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-arrow-left"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="pond_id">รหัสบ่อ</label>
                                                    <input type="text" class="form-control" name="pond_id" id="pond_id" placeholder="รหัสบ่อ" value="<?= $result['pond_id']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pond_name">ชื่อบ่อ</label>
                                                    <input type="text" class="form-control" name="pond_name" id="pond_name" placeholder="ชื่อบ่อ" value="<?= $result['pond_name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pond_image">รูปภาพบ่อ</label>
                                                    <input type="file" class="form-control-file" id="pond_image" name="pond_image" accept="image/*" value="<?= $result['pond_image']; ?>" required>
                                                </div>
                                                <img id="previewImage" src="#" alt="รูปภาพที่เลือก" style="display: none; max-width: 300px; max-height: 300px;">
                                                <div class="form-group">
                                                    <label for="pond_size">ขนาด</label>
                                                    <input type="text" class="form-control" name="pond_size" id="pond_size" placeholder="ชื่อสาขาวิชา" value="<?= $result['pond_size']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pond_detail">รายละเอียด</label>
                                                    <input type="text" class="form-control" name="pond_detail" id="pond_detail" placeholder="ชื่อสาขาวิชา" value="<?= $result['pond_detail']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pond_rodprice">ราคาคันเบ็ด</label>
                                                    <input type="text" class="form-control" name="pond_rodprice" id="pond_rodprice" placeholder="ชื่อสาขาวิชา" value="<?= $result['pond_rodprice']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
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
        //แสดงรูปที่เลือก
        document.getElementById('pond_image').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var previewImage = document.getElementById('previewImage');
                    previewImage.src = event.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        $(function() {
        $('#formData').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST', // เปลี่ยนเป็น POST ตามการใช้งานของฟอร์ม
                url: '../../service/pond/update.php',
                processData: false,
                contentType: false,
                data: formData,
                success: function(resp) {
                    Swal.fire({
                        text: 'อัพเดทข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign('./');
                    });
                },
                error: function(err) {
                    console.error(err);
                    Swal.fire({
                        text: 'มีข้อผิดพลาดเกิดขึ้น',
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
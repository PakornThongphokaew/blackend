<?php
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>จัดการข้อมูลซุ้ม</title>
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
                                        <i class="nav-icon fas fa-store"></i>
                                        เพิ่มข้อมูลซุ้ม
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-arrow-left"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="booth_name">ชื่อซุ้ม</label>
                                                <input type="text" class="form-control" name="booth_name" id="booth_name" placeholder="ชื่อซุ้ม" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="booth_image">รูปภาพซุ้ม</label>
                                                <input type="file" class="form-control-file" id="booth_image" name="booth_image" accept="image/*" required>
                                            </div>
                                            <img id="previewImage" src="#" alt="รูปภาพที่เลือก" style="display: none; max-width: 300px; max-height: 300px;">
                                            <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <label for="pond_id">ประเภทบ่อ</label>
                                                <select class="form-control" name="pond_id" id="pond_id" required>
                                                    <option value="" disabled selected>เลือกบ่อ</option>
                                                    <?php
                                                    $pondQuery = $conn->query("SELECT pond_id, pond_name FROM pond");
                                                    $pond = $pondQuery->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($pond as $pond_type) {
                                                        echo "<option value='" . $pond_type['pond_id'] . "'>" . $pond_type['pond_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-75" name="insert">บันทึกข้อมูล</button>
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
        //แสดงรูปที่เลือก
        document.getElementById('booth_image').addEventListener('change', function() {
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
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../../service/booth/create.php',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                }).done(function(resp) {
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
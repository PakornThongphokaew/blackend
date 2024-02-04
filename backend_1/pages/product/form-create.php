<?php
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลสินค้า</title>
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
                                        เพิ่มข้อมูลสินค้า
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
                                                    <label for="product_id">รหัสสินค้า</label>
                                                    <input type="text" class="form-control" name="product_id" id="product_id" placeholder="รหัสสินค้า" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_name">ชื่อสินค้า</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="ชื่อสินค้า" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_price">ราคาสินค้า</label>
                                                    <input type="text" class="form-control" name="product_price" id="product_price" placeholder="ราคาสินค้า" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_image">รูปสินค้า</label>
                                                    <input type="file" class="form-control-file" id="product_image" name="product_image" accept="image/*" required>
                                                </div>
                                                <img id="previewImage" src="#" alt="รูปภาพที่เลือก" style="display: none; max-width: 300px; max-height: 300px;">
                                                <div class="form-group">
                                                    <label for="product_amount">จำนวนสินค้า</label>
                                                    <input type="text" class="form-control" name="product_amount" id="product_amount" placeholder="จำนวนสินค้า" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_detail">รายละเอียดสินค้า</label>
                                                    <input type="text" class="form-control" name="product_detail" id="product_detail" placeholder="รายละเอียดสินค้า" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pdtype_id">ประเภทสินค้าย่อย</label>
                                                    <select class="form-control" name="pdtype_id" id="pdtype_id" required>
                                                        <option value="" disabled selected>เลือกสินค้าย่อย</option>
                                                        <?php
                                                        $productTypeQuery = $conn->query("SELECT pdtype_id, pdtype_name FROM product_type");
                                                        $productType = $productTypeQuery->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($productType as $product_type) {
                                                            echo "<option value='" . $product_type['pdtype_id'] . "'>" . $product_type['pdtype_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
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
        //แสดงรูปที่เลือก
        document.getElementById('product_image').addEventListener('change', function() {
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
                    type: 'POST', // Updated type to 'POST'
                    url: '../../service/product/create.php',
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
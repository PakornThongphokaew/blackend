<?php
    require_once('../authen.php');
    $product_id = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM product WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
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
                <div class="container-fluid">0
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                    <i class="nav-icon fas fa-shopping-basket"></i>
                                        แก้ไขข้อมูลสินค้า
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
                                                    <input type="text" class="form-control" name="product_id" id="product_id" placeholder="รหัสสินค้า" value="<?= $result['product_id']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_name">ชื่อสินค้า</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="ชื่อสินค้า" value="<?= $result['product_name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_price">ราคาสินค้า</label>
                                                    <input type="text" class="form-control" name="product_price" id="product_price" placeholder="ราคาสินค้า" value="<?= $result['product_price']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_image">รูปสินค้า</label>
                                                    <input type="file" class="form-control-file" id="product_image" name="product_image" accept="image/*" value="<?= $result['product_image']; ?>" required>
                                                </div>
                                                <img id="previewImage" src="#" alt="รูปภาพที่เลือก" style="display: none; max-width: 300px; max-height: 300px;">  
                                                <div class="form-group">
                                                    <label for="product_amount">จำนวนสินค้า</label>
                                                    <input type="text" class="form-control" name="product_amount" id="product_amount" placeholder="ชื่อสินค้า" value="<?= $result['product_amount']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_detail">รายละเอียดสินค้า</label>
                                                    <input type="text" class="form-control" name="product_detail" id="product_detail" placeholder="รายละเอียดสินค้า" value="<?= $result['product_detail']; ?>" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="pdtype_id">ประเภทสินค้าย่อย</label>
                                                    <select class="form-control" name="pdtype_id" id="pdtype_id" required>
                                                        <option value="" disabled>เลือกสินค้าย่อย</option>
                                                        <?php
                                                        $productTypeQuery = $conn->query("SELECT pdtype_id, pdtype_name FROM product_type");
                                                        $productType = $productTypeQuery->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($productType as $product_type_type) {
                                                            echo "<option value='" . $product_type_type['pdtype_id'] . "' " . ($product_typeInfo['pdtype_id'] === $product_type_type['pdtype_id'] ? 'selected' : '') . ">" . $product_type_type['pdtype_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
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
        $('#formData').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '../../service/product/update.php',
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
<?php
require_once('../authen.php');
$pdtype_id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM product_type WHERE pdtype_id = :pdtype_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':pdtype_id', $pdtype_id, PDO::PARAM_STR);
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
    <title>จัดการข้อมูลประเภทสินค้าย่อย</title>
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
                                        แก้ไขข้อมูลประเภทสินค้าย่อย
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
                                                    <label for="pdtype_id">รหัสประเภทสินค้าย่อย</label>
                                                    <input type="text" class="form-control" name="pdtype_id" id="pdtype_id" placeholder="รหัสประเภทสินค้าย่อย" value="<?= $result['pdtype_id']; ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pdtype_name">ชื่อประเภทสินค้าย่อย</label>
                                                    <input type="text" class="form-control" name="pdtype_name" id="pdtype_name" placeholder="ชื่อประเภทสินค้าย่อย" value="<?= $result['pdtype_name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pdcategory_id">ประเภทสินค้า</label>
                                                    <select class="form-control" name="pdcategory_id" id="pdcategory_id" required>
                                                        <option value="" disabled>เลือกประเภทสินค้า</option>
                                                        <?php
                                                        $productCategoryQuery = $conn->query("SELECT pdcategory_id, pdcategory_name FROM product_category");
                                                        $productCategory = $productCategoryQuery->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($productCategory as $product_category_type) {
                                                            echo "<option value='" . $product_category_type['pdcategory_id'] . "' " . ($product_categoryInfo['pdcategory_id'] === $product_category_type['pdcategory_id'] ? 'selected' : '') . ">" . $product_category_type['pdcategory_name'] . "</option>";
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
        $(function() {
            $('#formData').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '../../service/product_type/update.php',
                    contentType: 'application/json', // เพิ่ม content type เป็น JSON
                    data: JSON.stringify({
                        pdtype_name: $('#pdtype_name').val(),
                        pdcategory_id: $('#pdcategory_id').val(),
                        pdtype_id: $('#pdtype_id').val(),
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
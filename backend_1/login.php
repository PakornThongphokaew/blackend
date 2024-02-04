<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- stylesheet -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit"> -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <header>
    <!-- Your header content -->
  </header>
  <section class="d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow p-3 p-md-4">
            <h1 class="text-center text-primary font-weight-bold">
              <img src="./assets/images/fishing.png" class="mr-2" style="height: 100px;"> Owner Login Backend
            </h1>
            <h4 class="text-center">เข้าสู่ระบบ</h4>
            <div class="card-body">
              <!-- HTML Form Login -->
              <form id="formData" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="ow_id">ชื่อผู้ใช้งาน</label>
                  <input type="text" class="form-control" id="ow_id" name="ow_id" placeholder="username" required>
                </div>
                <div class="form-group">
                  <label for="ow_password">รหัสผ่าน</label>
                  <input type="password" class="form-control" id="ow_password" name="ow_password" placeholder="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block"> เข้าสู่ระบบ</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- script -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/toastr/toastr.min.js"></script>
  <script>
  $(function() {
    /** Ajax Submit Login */
    $("#formData").submit(function(e) {
      e.preventDefault()
      $.ajax({
        type: "POST",
        url: "service/auth/login.php",
        data: $(this).serialize() // Changed to $(this).serialize() to match the form ID
      }).done(function(resp) {
        // Handle success
        toastr.success('เข้าสู่ระบบเรียบร้อย');
        setTimeout(() => {
          location.href = 'pages/dashboard/';
        }, 800);
      }).fail(function(xhr, status, error) {
        // Handle failures/errors
        toastr.error('ไม่สามารถเข้าสู่ระบบได้');
      });
    });
  });
</script>
</body>

</html>
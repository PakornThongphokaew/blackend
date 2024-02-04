<?php
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลลูกค้า</title>
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                <div class="card-header border-0 pt-4 d-flex justify-content-between align-items-center">
                                    <h4>
                                        <i class="nav-icon fas fa-user"></i>
                                        จัดการข้อมูลลูกค้า
                                    </h4>
                                    <div class="ml-auto">
                                        <a href="form-create.php" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus"></i>
                                            เพิ่มข้อมูล
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                    </table>
                                </div>
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
    <script src="../../assets/js/adminlte.min.js"></script>

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $.ajax({
                type: "GET",
                url: "../../service/customer/index.php"
            }).done(function(data) {
                let tableData = []
                data.response.forEach(function(item, index) {
                    tableData.push([
                        ++index,
                        item.cus_no,
                        item.cus_email,
                        item.cus_password,
                        item.cus_fullname,
                        item.cus_tel,
                        item.cus_address,
                        `<div class="btn-group" role="group">
                            <a href="form-edit.php?id=${item.cus_email}" type="button" class="btn btn-success text-white">
                                <i class="far fa-edit"></i> แก้ไข
                            </a>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${item.cus_email}" data-index="${index}">
                            <i class="far fa-trash-alt"></i> ลบ
                        </button>
                    </div>`
                    ])
                })
                initDataTables(tableData)
            }).fail(function() {
                Swal.fire({
                    text: 'ไม่สามารถเรียกดูข้อมูลได้',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                }).then(function() {
                    location.assign('../dashboard')
                })
            })

            function initDataTables(tableData) {
                $('#logs').DataTable({
                    data: tableData,
                    columns: [{
                            title: "ลำดับแถว",
                            className: "align-middle"
                        },
                        {
                            title: "ลำดับลูกค้า",
                            className: "align-middle"
                        },
                        {
                            title: "อีเมล",
                            className: "align-middle"
                        },
                        {
                            title: "รหัสผ่าน",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อ-นามสกุล",
                            className: "align-middle"
                        },
                        {
                            title: "เบอร์โทร",
                            className: "align-middle"
                        },
                        {
                            title: "ที่อยู่",
                            className: "align-middle"
                        },
                        {
                            title: "ปุ่มลบ แก้ไข",
                            className: "align-middle"
                        }
                    ],
                    initComplete: function() {
                        $(document).on('click', '#delete', function() {
                            let cus_email = $(this).data('id');
                            let index = $(this).data('index');
                            Swal.fire({
                                text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'ใช่! ลบเลย',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "DELETE",
                                        url: "../../service/customer/delete.php",
                                        data: JSON.stringify({
                                            cus_email: cus_email
                                        }),
                                        contentType: "application/json; charset=utf-8",
                                        dataType: "json"
                                    }).done(function(data) {
                                        Swal.fire({
                                            text: 'รายการของคุณถูกลบเรียบร้อย',
                                            icon: 'success',
                                            confirmButtonText: 'ตกลง',
                                        }).then((result) => {
                                            location.reload();
                                        })
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        console.log("AJAX Error: " + textStatus + ' - ' + errorThrown);
                                    })
                                }
                            })
                        })
                    },
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data()
                                    return 'ข้อมูลลูกค้า: ' + data[1]
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    },
                    language: {
                        "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                        "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                        "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                        "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": 'ค้นหา',
                        "paginate": {
                            "previous": "ก่อนหน้านี้",
                            "next": "หน้าต่อไป"
                        }
                    }
                })
            }

        })
    </script>
</body>

</html>
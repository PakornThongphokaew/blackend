<?php
header('Content-Type: application/json');
require_once '../connect.php';

if (isset($_GET['booking_id']) && isset($_GET['booking_paystatus'])) {
    $booking_id = $_GET['booking_id'];
    $booking_paystatus = $_GET['booking_paystatus'];

    // Update booking_paystatus in your_table_name based on booking_id
    $sql = "UPDATE your_table_name SET booking_paystatus = :booking_paystatus WHERE booking_id = :booking_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['booking_paystatus' => $booking_paystatus, 'booking_id' => $booking_id]);

    // Respond with the success or failure message
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "อัปเดตสถานะการมัดจำสำเร็จ"]);
    } else {
        echo json_encode(["success" => false, "message" => "ไม่สามารถอัปเดตสถานะการมัดจำได้"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ไม่สามารถดำเนินการได้ เนื่องจากข้อมูลไม่ถูกต้อง"]);
}
?>
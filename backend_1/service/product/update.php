<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

$pdtype_id = $_POST['pdtype_id'];

$product_name = $_POST['product_name'];
$product_id = $_POST['product_id'];
$product_price = $_POST['product_price'];
$product_amount = $_POST['product_amount'];
$product_detail = $_POST['product_detail'];

if (isset($_FILES['product_image']['name'])) {
    $unique_id = uniqid();
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg";
    $imagePath = 'uploads/' . $image_file_name;

    $tmp_name = $_FILES['product_image']['tmp_name'];
    move_uploaded_file($tmp_name, $imagePath);
} else {
    $imagePath = ''; // ตั้งค่าเป็นช่องว่างหรือตามที่คุณต้องการในกรณีที่ไม่มีการอัปโหลดรูป
}

$stmt = $conn->prepare("UPDATE product SET product_name = :product_name, product_price = :product_price, product_image = :product_image, product_amount = :product_amount, product_detail = :product_detail, pdtype_id = :pdtype_id WHERE product_id = :product_id");

$stmt->bindParam(":pdtype_id", $pdtype_id, PDO::PARAM_STR);
$stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
$stmt->bindParam(":product_price", $product_price, PDO::PARAM_STR);
$stmt->bindParam(":product_image", $imagePath, PDO::PARAM_STR);
$stmt->bindParam(":product_amount", $product_amount, PDO::PARAM_STR);
$stmt->bindParam(":product_detail", $product_detail, PDO::PARAM_STR);
$stmt->bindParam(":product_id", $product_id, PDO::PARAM_STR);

if ($stmt->execute()) {
    $response = [
        'status' => true,
        'message' => 'Update Success'
    ];
    http_response_code(200);
    echo json_encode($response);
} else {
    $response = [
        'status' => false,
        'message' => 'Update Failed'
    ];
    http_response_code(500);
    echo json_encode($response);
}
?>

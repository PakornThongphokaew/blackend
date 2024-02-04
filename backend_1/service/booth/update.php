<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

$booth_id = $_POST['booth_id'];
$booth_name = $_POST['booth_name'];
$pond_id = $_POST['pond_id'];

if (isset($_FILES['booth_image']['name'])) {
    $unique_id = uniqid();
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg";
    $imagePath = 'uploads/' . $image_file_name;

    $tmp_name = $_FILES['booth_image']['tmp_name'];
    move_uploaded_file($tmp_name, $imagePath);
} else {
    $imagePath = ''; 
}

$stmt = $conn->prepare("UPDATE booth SET booth_name = :booth_name, booth_image = :booth_image, pond_id = :pond_id WHERE booth_id = :booth_id");

$stmt->bindParam(":booth_id", $booth_id, PDO::PARAM_STR);
$stmt->bindParam(":booth_name", $booth_name, PDO::PARAM_STR);
$stmt->bindParam(":booth_image", $imagePath, PDO::PARAM_STR);
$stmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);

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

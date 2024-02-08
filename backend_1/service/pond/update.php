<?php
header('Content-Type: application/json');
require_once '../connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

// Retrieve data from the input stream
$data = $_POST;

// Ensure required fields are present in the data
$requiredFields = ['pond_name', 'pond_size', 'pond_detail', 'pond_rodprice', 'pond_id'];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => false, 'message' => 'Missing or invalid input data']);
        exit();
    }
}

$pond_name = $data['pond_name'];
$pond_size = $data['pond_size'];
$pond_detail = $data['pond_detail'];
$pond_rodprice = $data['pond_rodprice'];
$pond_id = $data['pond_id'];

// Handle image upload (if exists) and store the file where necessary
if (isset($_FILES['pond_image']['name'])) {
    $unique_id = uniqid();
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg";
    $imagePath = 'uploads/' . $image_file_name;

    $tmp_name = $_FILES['pond_image']['tmp_name'];
    move_uploaded_file($tmp_name, $imagePath);
} else {
    $imagePath = ''; 
}

try {
    $stmt = $conn->prepare("UPDATE pond SET pond_name = :pond_name, pond_image = :pond_image, pond_size = :pond_size, pond_detail = :pond_detail, pond_rodprice = :pond_rodprice WHERE pond_id = :pond_id");

    $stmt->bindParam(":pond_name", $pond_name, PDO::PARAM_STR);
    $stmt->bindParam(":pond_image", $imagePath, PDO::PARAM_STR);
    $stmt->bindParam(":pond_size", $pond_size, PDO::PARAM_STR);
    $stmt->bindParam(":pond_detail", $pond_detail, PDO::PARAM_STR);
    $stmt->bindParam(":pond_rodprice", $pond_rodprice, PDO::PARAM_STR);
    $stmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response = [
            'status' => true,
            'message' => 'Update Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(['status' => false, 'message' => 'Update Failed']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

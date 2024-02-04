<?php
header('Content-Type: application/json');
require_once '../connect.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

// Retrieve data from the input stream
$data = json_decode(file_get_contents("php://input"), true);

// Check if required data exists in the request
if (!isset($data['pdcategory_id'], $data['pdcategory_name'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => false, 'message' => 'Missing data']);
    exit();
}

$pdcategory_name = $data['pdcategory_name'];
$pdcategory_id = $data['pdcategory_id'];

try {
    $stmt = $conn->prepare("UPDATE product_category SET pdcategory_name = :pdcategory_name 
            WHERE pdcategory_id = :pdcategory_id");

    $stmt->bindParam(":pdcategory_name", $pdcategory_name, PDO::PARAM_STR);
    $stmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);

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
        http_response_code(500); // Internal Server Error
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = [
        'status' => false,
        'message' => 'Error: ' . $e->getMessage()
    ];
    http_response_code(500);
    echo json_encode($response);
}
?>

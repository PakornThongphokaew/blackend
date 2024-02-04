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

$cus_email = $data['cus_email'];
$cus_fullname = $data['cus_fullname'];
$cus_tel = $data['cus_tel'];
$cus_address = $data['cus_address'];

try {
    $stmt = $conn->prepare("UPDATE customer SET cus_fullname = :cus_fullname, cus_tel = :cus_tel, cus_address = :cus_address 
    WHERE cus_email = :cus_email");

    $stmt->bindParam(":cus_email", $cus_email, PDO::PARAM_STR);
    $stmt->bindParam(":cus_fullname", $cus_fullname, PDO::PARAM_STR);
    $stmt->bindParam(":cus_tel", $cus_tel, PDO::PARAM_STR);
    $stmt->bindParam(":cus_address", $cus_address, PDO::PARAM_STR);

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
    http_response_code(500); // Internal Server Error
    echo json_encode($response);
}


<?php
header('Content-Type: application/json');
require_once '../connect.php';

try {

    $pdcategory_id = $_POST['pdcategory_id'];
    $pdcategory_name = $_POST['pdcategory_name']; // Remove the extra tab at the end of 'pdcategory_name'

    

    $sql = "INSERT INTO product_category (pdcategory_id, pdcategory_name) 
            VALUES (:pdcategory_id, :pdcategory_name)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);
    $stmt->bindParam(":pdcategory_name", $pdcategory_name, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response = [
            'status' => true,
            'message' => 'Create Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    } else {
        $response = [
            'status' => false,
            'message' => 'Create failed'
        ];
        http_response_code(500);
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

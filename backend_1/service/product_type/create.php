<?php
header('Content-Type: application/json');
require_once '../connect.php';

try {

    if (!isset($_POST['pdcategory_id'])) {
        $response = [
            'status' => false,
            'message' => 'Missing pdcategory_id in the request'
        ];
        http_response_code(400);
        echo json_encode($response);
        exit();
    }

    $pdcategory_id = $_POST['pdcategory_id'];
    
    $pdtype_id = $_POST['pdtype_id'];
    $pdtype_name = $_POST['pdtype_name']; // Remove the extra tab at the end of 'pdcategory_name'

    $checkProductCategoryStmt = $conn->prepare("SELECT COUNT(*) FROM product_category WHERE pdcategory_id = :pdcategory_id");
    $checkProductCategoryStmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);
    $checkProductCategoryStmt->execute();
    $countProductCategory = $checkProductCategoryStmt->fetchColumn();

    if ($countProductCategory == 0) {
        $response = [
            'status' => false,
            'message' => 'Invalid pdcategory_id'
        ];
        http_response_code(400);
        echo json_encode($response);
        exit(); // End execution
    }

    $sql = "INSERT INTO product_type (pdtype_id, pdtype_name, pdcategory_id) 
            VALUES (:pdtype_id, :pdtype_name, :pdcategory_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":pdtype_id", $pdtype_id, PDO::PARAM_STR);
    $stmt->bindParam(":pdtype_name", $pdtype_name, PDO::PARAM_STR);
    $stmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);

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

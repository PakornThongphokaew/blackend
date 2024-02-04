<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];

    // Generate a unique filename
    $unique_id = uniqid(); // Generate a unique identifier
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg"; // Create a filename based on the unique identifier and date
    $imagePath = 'uploads/' . $image_file_name;

    move_uploaded_file($tmp_name, $imagePath); // Move the uploaded file to the desired location
}

    try {

        global $conn; // ดึง $conn จากไฟล์ connect.php

        if (!isset($_POST['pdtype_id'])) {
            $response = [
                'status' => false,
                'message' => 'Missing pdtype_id in the request'
            ];
            http_response_code(400);
            echo json_encode($response);
            exit();
        }

        $pdtype_id = $_POST['pdtype_id'];

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $imagePath; // Updated variable assignment
        $product_amount = $_POST['product_amount'];
        $product_detail = $_POST['product_detail'];

        $checkProductTypeStmt = $conn->prepare("SELECT COUNT(*) FROM product_type WHERE pdtype_id = :pdtype_id");
        $checkProductTypeStmt->bindParam(":pdtype_id", $pdtype_id, PDO::PARAM_STR);
        $checkProductTypeStmt->execute();
        $countProductType = $checkProductTypeStmt->fetchColumn();

        $sql = "INSERT INTO product (product_id, product_name, product_price, product_image, product_amount, product_detail, pdtype_id) 
                VALUES (:product_id, :product_name, :product_price, :product_image, :product_amount, :product_detail, :pdtype_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pdtype_id", $pdtype_id, PDO::PARAM_STR);
        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
        $stmt->bindParam(":product_price", $product_price, PDO::PARAM_STR);
        $stmt->bindParam(":product_image", $product_image, PDO::PARAM_STR);
        $stmt->bindParam(":product_amount", $product_amount, PDO::PARAM_STR);
        $stmt->bindParam(":product_detail", $product_detail, PDO::PARAM_STR);

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


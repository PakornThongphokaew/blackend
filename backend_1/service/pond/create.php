<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['pond_image']['name'];
    $tmp_name = $_FILES['pond_image']['tmp_name'];

    // Generate a unique filename
    $unique_id = uniqid(); // Generate a unique identifier
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg"; // Create a filename based on the unique identifier and date
    $imagePath = 'uploads/' . $image_file_name;

    move_uploaded_file($tmp_name, $imagePath); // Move the uploaded file to the desired location
}


try {
    global $conn; // ดึง $conn จากไฟล์ connect.php

    $pond_id = $_POST['pond_id'];
    $pond_name = $_POST['pond_name'];
    $pond_image = $imagePath; // Updated to store the image path
    $pond_size = $_POST['pond_size'];
    $pond_detail = $_POST['pond_detail'];
    $pond_rodprice = $_POST['pond_rodprice'];

    // Prepared statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO pond (pond_id, pond_name, pond_image, pond_size, pond_detail, pond_rodprice) 
            VALUES (:pond_id, :pond_name, :pond_image, :pond_size, :pond_detail, :pond_rodprice)");

    $stmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);
    $stmt->bindParam(":pond_name", $pond_name, PDO::PARAM_STR);
    $stmt->bindParam(":pond_image", $pond_image, PDO::PARAM_STR);
    $stmt->bindParam(":pond_size", $pond_size, PDO::PARAM_STR);
    $stmt->bindParam(":pond_detail", $pond_detail, PDO::PARAM_STR);
    $stmt->bindParam(":pond_rodprice", $pond_rodprice, PDO::PARAM_STR);


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
    $response = [
        'status' => true,
        'message' => 'Create Success'
    ];
    http_response_code(200);
    echo json_encode($response);
}

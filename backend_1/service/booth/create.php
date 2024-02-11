<?php
header('Content-Type: application/json');
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['booth_image']['name'];
    $tmp_name = $_FILES['booth_image']['tmp_name'];

    // Generate a unique filename
    $unique_id = uniqid(); // Generate a unique identifier
    $image_file_name = $unique_id . "_" . date("Ymd") . ".jpg"; // Create a filename based on the unique identifier and date
    $imagePath = 'uploads/' . $image_file_name;

    move_uploaded_file($tmp_name, $imagePath); // Move the uploaded file to the desired location
}

    try {

        global $conn; // ดึง $conn จากไฟล์ connect.php

        if (!isset($_POST['pond_id'])) {
            $response = [
                'status' => false,
                'message' => 'Missing pond_id in the request'
            ];
            http_response_code(400);
            echo json_encode($response);
            exit();
        }

        $pond_id = $_POST['pond_id'];
        $booth_name = $_POST['booth_name'];
        $booth_image = $imagePath; // Updated variable assignment

        $checkPondStmt = $conn->prepare("SELECT COUNT(*) FROM pond WHERE pond_id = :pond_id");
        $checkPondStmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);
        $checkPondStmt->execute();
        $countPond = $checkPondStmt->fetchColumn();

        if ($countPond == 0) {
            $response = [
                'status' => false,
                'message' => 'Invalid pond_id'
            ];
            http_response_code(400);
            echo json_encode($response);
            exit(); // End execution
        }


        $sql = "INSERT INTO booth (booth_name, booth_image, pond_id) 
                VALUES (:booth_name, :booth_image, :pond_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":booth_name", $booth_name, PDO::PARAM_STR);
        $stmt->bindParam(":booth_image", $booth_image, PDO::PARAM_STR);
        $stmt->bindParam(":pond_id", $pond_id, PDO::PARAM_STR);

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

?>

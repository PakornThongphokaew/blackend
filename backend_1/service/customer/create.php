<?php
    header('Content-Type: application/json');
    require_once '../connect.php';

    $cus_email = $_POST['cus_email'];
    $cus_password = $_POST['cus_password'];
    $cus_fullname = $_POST['cus_fullname'];
    $cus_tel = $_POST['cus_tel'];
    $cus_address = $_POST['cus_address'];

    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE cus_email = :cus_email");
    $checkStmt->bindParam(":cus_email", $cus_email, PDO::PARAM_STR);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    $sql = "INSERT INTO customer (cus_email, cus_password, cus_fullname, cus_tel, cus_address) 
            VALUES (:cus_email, :cus_password, :cus_fullname, :cus_tel, :cus_address)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":cus_email", $cus_email, PDO::PARAM_STR);
    $stmt->bindParam(":cus_password", $cus_password, PDO::PARAM_STR);
    $stmt->bindParam(":cus_fullname", $cus_fullname, PDO::PARAM_STR);
    $stmt->bindParam(":cus_tel", $cus_tel, PDO::PARAM_STR);
    $stmt->bindParam(":cus_address", $cus_address, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            // Successful insertion
            $response = [
                'status' => true,
                'message' => 'Create Success'
            ];
            http_response_code(200);
            echo json_encode($response);
        } else {
            // Insertion failed
            $response = [
                'status' => false,
                'message' => 'Create failed'
            ];
            http_response_code(500);
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Handle PDOException, including duplicate entry error
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode($response);
    }
?>
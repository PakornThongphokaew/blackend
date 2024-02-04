<?php
header('Content-Type: application/json');
require_once '../connect.php';

$ow_id = $_POST['ow_id'];
$ow_password = $_POST['ow_password'];
$ow_fullname = $_POST['ow_fullname'];

// Check if the owner ID already exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM owner WHERE ow_id = :ow_id");
$checkStmt->bindParam(":ow_id", $ow_id, PDO::PARAM_STR);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    $response = [
        'status' => false,
        'message' => 'Owner ID already exists'
    ];
    http_response_code(400); // Bad Request
    echo json_encode($response);
    exit();
}

// Hash the password
$hashedPassword = password_hash($ow_password, PASSWORD_DEFAULT);

$sql = "INSERT INTO owner (ow_id, ow_password, ow_fullname) 
        VALUES (:ow_id, :ow_password, :ow_fullname)";

$stmt = $conn->prepare($sql);

$stmt->bindParam(":ow_id", $ow_id, PDO::PARAM_STR);
$stmt->bindParam(":ow_password", $hashedPassword, PDO::PARAM_STR);
$stmt->bindParam(":ow_fullname", $ow_fullname, PDO::PARAM_STR);

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

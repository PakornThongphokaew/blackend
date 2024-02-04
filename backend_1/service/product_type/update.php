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

    if (!isset($data['pdcategory_id'])) {
        $response = [
            'status' => false,
            'message' => 'Missing pdcategory_id in the request'
        ];
        http_response_code(400);
        echo json_encode($response);
        exit();
    }

    // Check if required data exists in the request
    if (!isset($data['pdtype_id'], $data['pdtype_name'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => false, 'message' => 'Missing data']);
        exit();
    }

        $pdcategory_id = $data['pdcategory_id'];

        $pdtype_name = $data['pdtype_name'];
        $pdtype_id = $data['pdtype_id'];

        $checkProductCategoryStmt = $conn->prepare("SELECT COUNT(*) FROM product_category WHERE pdcategory_id = :pdcategory_id");
        $checkProductCategoryStmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);
        $checkProductCategoryStmt->execute();
        $countProductCategory = $checkProductCategoryStmt->fetchColumn();

    try {
        $stmt = $conn->prepare("UPDATE product_type SET pdtype_name = :pdtype_name, pdcategory_id = :pdcategory_id 
                WHERE pdtype_id = :pdtype_id");


        $stmt->bindParam(":pdcategory_id", $pdcategory_id, PDO::PARAM_STR);
        $stmt->bindParam(":pdtype_name", $pdtype_name, PDO::PARAM_STR);
        $stmt->bindParam(":pdtype_id", $pdtype_id, PDO::PARAM_STR);

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

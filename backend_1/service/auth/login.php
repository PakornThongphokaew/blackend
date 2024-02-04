<?php

    header('Content-Type: application/json');
    require_once '../connect.php';


    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $stmt = $conn->prepare("SELECT * FROM owner WHERE ow_id = :ow_id");
        $stmt->execute(array(":ow_id" => $_POST['ow_id']));
        $row = $stmt->fetch(PDO::FETCH_OBJ);


        if( !empty($row) && password_verify($_POST['ow_password'], $row->ow_password)){
            $_SESSION['OW_ID'] = $row->ow_id;
            $_SESSION['OW_FULLNAME'] = $row->ow_fullname;
            $_SESSION['OW_LOGIN'] = $row->updated_at;

           
            $updateStmt = $conn->prepare("UPDATE owner SET updated_at = :updated_at WHERE ow_id = :ow_id");
            $updateStmt->execute(array(":updated_at" => date("Y-m-d H:i:s"), ":ow_id" => $row->ow_id));

            if ($updateStmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => true, 'message' => 'Login Success!'));
            } else {
                http_response_code(500); 
                echo json_encode(array('status' => false, 'message' => 'Failed to update login timestamp!'));
            }

        } else {
            http_response_code(401);
            echo json_encode(array('status' => false, 'massage' => 'Unauthorized!'));
        }  
    } else {
        http_response_code(405);
        echo json_encode(array('status' => false, 'massage' => 'Method Not Allowed'));
    }
    
?>

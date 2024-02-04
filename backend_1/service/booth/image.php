<?php
header('Content-Type: application/json');
require_once('../authen.php');
$img_bo = $con->query("SELECT * FROM booth BY bo_id DESD");
$list = array();

while($rowdata = $img_bo->fetch_assoc()){

}

echo json_encode($list);
?>
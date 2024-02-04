<?php
header('Content-Type: application/json');
require_once('../authen.php');
$img_po = $con->query("SELECT * FROM pond BY po_id DESD");
$list = array();

while($rowdata = $img_po->fetch_assoc()){

}

echo json_encode($list);
?>
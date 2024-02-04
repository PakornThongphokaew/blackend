<?php
header('Content-Type: application/json');
require_once('../authen.php');
$img_pd = $con->query("SELECT * FROM product BY pd_id DESD");
$list = array();

while($rowdata = $img_pd->fetch_assoc()){

}

echo json_encode($list);
?>
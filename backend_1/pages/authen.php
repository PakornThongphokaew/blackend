<?php 
    require_once '../../service/connect.php' ; 
    if( !isset($_SESSION['OW_ID'] ) ){
        header('Location: ../../login.php');  
    }
?>

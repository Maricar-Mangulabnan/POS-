<?php
session_start();

$active = $_SESSION['active'];
$activeManager = $_SESSION['activeManager'];

if($activeManager != 'True'){
    header('Location: ../index.php');
}elseif($active != 'True'){
    header('Location: ../index.php');
}else{
    header('Location: ../Manager/dashboard/dashboard.php');
}
?>
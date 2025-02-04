<?php
session_start();

$active = $_SESSION['active'];
$activeAdmin = $_SESSION['activeAdmin'];

if($activeAdmin != 'True'){
    header('Location: ../index.php');
}elseif($active != 'True'){
    header('Location: ../index.php');
}else{
    header('Location: ../Admin/dashboard/dashboard.php');
}
?>
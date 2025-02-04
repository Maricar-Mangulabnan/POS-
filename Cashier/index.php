<?php
session_start();

$active = $_SESSION['active'];
$activeCashier = $_SESSION['activeCashier'];

if($activeCashier != 'True'){
    header('Location: ../index.php');
}elseif($active != 'True'){
    header('Location: ../index.php');
}else{
    header('Location: ../Cashier/dashboard/dashboard.php');
}
?>

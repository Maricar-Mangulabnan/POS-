<?php
session_start();

$active = $_SESSION['active'];
$activeInventoryClerk = $_SESSION['activeInventoryClerk'];

if($activeInventoryClerk != 'True'){
     header('Location: ../index.php');
}elseif($active != 'True'){
    header('Location: ../index.php');
}else{
    header('Location: ../Inventory Clerk/dashboard/dashboard.php');
}
?>
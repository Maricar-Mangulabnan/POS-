<?php
include '../includes/dbconn.php';

$Type = $_POST['inputType'];
$Qty = $_POST['inputLoss'];
$ID = $_GET['ID'];

if($Type == 'Lost Item'){
    $sql = "UPDATE `products` SET  LossQty =  LossQty + '$Qty', Stock = Stock - '$Qty' WHERE ID = '$ID'";
    $result = mysqli_query($conn, $sql);
}elseif($Type == 'Return Item'){
    $sql = "UPDATE `products` SET  ReturnQty = ReturnQty + '$Qty' WHERE ID = '$ID'";
    $result = mysqli_query($conn, $sql);
}

header('Location: allproducts.php');
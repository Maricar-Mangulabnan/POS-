<?php
include '../includes/dbconn.php';

$Code = $_POST['inputCode'];
$Name = $_POST['inputName'];
$Stock = $_POST['inputStock'];
$SRP = $_POST['inputSRP'];
$MarkupPrice = $_POST['inputMarkupPrice'];
$Status = $_POST['inputStatus'];
$ID = $_GET['ID'];

$sql = "UPDATE `products` SET  
        `Code` = '$Code',
        `Name` = '$Name',
        `Stock` = '$Stock',
        `SRP` = '$SRP',
        `MarkupPrice` = '$MarkupPrice',
        `Status` = '$Status'
        WHERE `ID` = '$ID'";

$result = mysqli_query($conn, $sql);

header('Location: allproducts.php');
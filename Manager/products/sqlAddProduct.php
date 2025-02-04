<?php
include '../includes/dbconn.php';

$inputCode = $_POST['inputCode'];
$inputName = $_POST['inputName'];
$inputStock = $_POST['inputStock'];
$inputSRP = $_POST['inputSRP'];
$inputMarkupPrice = $_POST['inputMarkupPrice'];
$inputStatus = $_POST['inputStatus'];

$sql = "INSERT INTO `products` (Code, Name, Stock, SRP, MarkupPrice, Status) VALUES ('$inputCode', '$inputName', '$inputStock', '$inputSRP', '$inputMarkupPrice', '$inputStatus')";

$result = mysqli_query($conn, $sql);

header('Location: allProducts.php');
?>
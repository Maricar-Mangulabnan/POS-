<?php
include '../includes/dbconn.php';

$ID = $_GET['ID'];

// Perform the deletion if the user is not active
$sqlDelete = "UPDATE `products` SET `Archive` = 'No' WHERE `ID` = '{$ID}'";
$resultDelete = mysqli_query($conn, $sqlDelete);

header('Location: allProducts.php');
?>
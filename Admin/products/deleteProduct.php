<?php
include '../includes/dbconn.php';

$ID = $_GET['ID'];

// Retrieve user status
$sqlStatus = "SELECT `Status` FROM `products` WHERE `ID` = '{$ID}'";
$resultStatus = mysqli_query($conn, $sqlStatus);
$rowStatus = mysqli_fetch_assoc($resultStatus);
$userStatus = $rowStatus['Status'];

// Check if the user has an active status
if ($userStatus == 'Active') {
    echo '<script>alert("Cannot delete an Active Product."); window.location.href = "allProducts.php";</script>';
    exit();
}

// Perform the deletion if the user is not active
$sqlDelete = "UPDATE `products` SET `Archive` = 'Yes' WHERE `ID` = '{$ID}'";
$resultDelete = mysqli_query($conn, $sqlDelete);

header('Location: allProducts.php');
?>
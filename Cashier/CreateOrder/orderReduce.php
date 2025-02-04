<?php
include "../includes/dbconn.php";

$productID = $_GET['productID'];
$sqlCheck = "SELECT * FROM `orderitems` WHERE `productID` = '$productID' AND `Archive` != 'Yes'";
$result = mysqli_query($conn, $sqlCheck);

$row = mysqli_fetch_assoc($result);
if ($row['productID'] == $productID) {
    $sql = "UPDATE `orderitems` SET Qty = Qty - 1 WHERE productID = '$productID' AND `Archive` != 'Yes'";
    $result = mysqli_query($conn, $sql);

    if ($row['Qty'] == 1) {
        $deleteSql = "DELETE FROM `orderitems` WHERE `productID` = '$productID' AND `Archive` != 'Yes'";
        $deleteResult = mysqli_query($conn, $deleteSql);
        if ($deleteResult) {
            header('Location: createOrder.php');
            exit;
        } else {
            echo "Error deleting item: " . mysqli_error($conn);
        }
    }

    if ($result) {
        // Successful update
        header('Location: createOrder.php');
        exit;
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
} else {
    // Product not found in orderitems
    header('Location: createOrder.php');
    exit;
}
?>

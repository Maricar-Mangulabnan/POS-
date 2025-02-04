<?php
include "../includes/dbconn.php";

$productID = $_GET['ID'];
$sqlCheck = "SELECT * FROM `orderitems` WHERE `productID` = '$productID' AND `Archive` != 'Yes'";
$result = mysqli_query($conn, $sqlCheck);

$row = mysqli_fetch_assoc($result);

if ($row['productID'] != $productID) {
    date_default_timezone_set("Asia/Manila");
    // If the product is not already in the order items, insert a new record
    $currentDate = date("Y-m-d"); // Get the current date in the format 'YYYY-MM-DD'
    
    // Subtract one day from the current date
    $previousDate = date("Y-m-d", strtotime($currentDate . " -1 day"));

    $sql = "INSERT INTO `orderitems` (productID, Qty, Date) VALUES ('$productID', '1', '$previousDate')";

    // $sqlStock = "UPDATE `products` SET Stock = Stock - 1, SoldQty = SoldQty + 1 WHERE ID = '{$productID}'";
    // $resultStock = mysqli_query($conn, $sqlStock);

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Successful insertion
        header('Location: createOrder.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} elseif($row['productID'] == $productID) {
    echo '<script>alert("Product is already added to the order.");</script>';
    echo '<script>window.location.href = "createOrder.php";</script>';
    exit;
}
?>
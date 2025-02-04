<?php
include '../includes/dbconn.php';
session_start();

// Check if orderIDs parameter is set in the POST data
if (isset($_POST['orderIDs'])) {
    // Split the comma-separated string into an array
    $orderIDs = explode(',', $_POST['orderIDs']);
} else {
    // Handle the case when orderIDs parameter is not set
    echo "No order IDs found in the form data.";
    exit; // Exit the script if order IDs are not available
}

$Date = $_POST['inputDate'];
$CashierID = $_SESSION['userID'];
$Customer = $_POST['inputCustomer'];
$Total = $_POST['inputTotal'];
$Amount = $_POST['Amount'];
$Change = $Amount - $Total;

// Check if the amount is greater than or equal to the total
if ($Amount < $Total) {
    echo "<script>alert('Amount should be greater than or equal to Total.');</script>";
    echo "<script>";
    echo "  setTimeout(function() { window.location.href = 'createOrder.php?'; }, 100);";
    echo "</script>";
    exit;
}

// Insert into orderhistory
$sql = "INSERT INTO `orderhistory` (Date, CustomerName, CashierID, Total, Amount_Given, Change_)
        VALUES ('$Date', '$Customer', '$CashierID', '$Total', '$Amount', '$Change')";

$result = mysqli_query($conn, $sql);

if ($result) {
    // Get the last inserted order ID
    $lastOrderID = mysqli_insert_id($conn);

    // Fetch productID from orderlist for all order items
    $sqlProductID = "SELECT productID FROM `orderitems` WHERE orderID IN (" . implode(',', $orderIDs) . ")";
    $resultProductID = mysqli_query($conn, $sqlProductID);

    // Update orderitems with Archive = 'Yes' and set orderHistoryID
    $sqlOrderList = "UPDATE `orderitems` SET `Archive` = 'Yes', `orderHistoryID` = '$lastOrderID' WHERE `orderID` IN (" . implode(',', $orderIDs) . ")";
    $resultOrderList = mysqli_query($conn, $sqlOrderList);

    // Fetch quantity from orderitems and update products for each product
    while ($productIDRow = mysqli_fetch_assoc($resultProductID)) {
        $productID = $productIDRow['productID'];
        $quantityQuery = "SELECT Qty FROM `orderitems` WHERE `orderID` IN (" . implode(',', $orderIDs) . ") AND `productID` = $productID";
        $quantityResult = mysqli_query($conn, $quantityQuery);
        $quantityRow = mysqli_fetch_assoc($quantityResult);
        $Qty = $quantityRow['Qty'];

        $stockUpdateQuery = "UPDATE `products` SET `Stock` = `Stock` - $Qty, `SoldQty` = `SoldQty` + $Qty 
        WHERE `ID` = $productID";

        $resultStockUpdate = mysqli_query($conn, $stockUpdateQuery);
        if (!$resultStockUpdate) {
            echo "Error updating products: " . mysqli_error($conn);
            exit;
        }
    }

    if (!$resultOrderList) {
        echo "Error updating orderitems: " . mysqli_error($conn);
        exit;
    }

    // Display alert with customer change
    echo "<script>";
    echo "if (confirm('Customer change: $Change')) {";
    echo "  setTimeout(function() { window.open('generateReciept.php', '_blank'); }, 500);";
    echo "  setTimeout(function() { window.location.href = 'createOrder.php'; }, 1000);";
    echo "}";
    echo "</script>";
    exit;
} else {
    echo "Error inserting into orderhistory: " . mysqli_error($conn);
    exit;
}
?>
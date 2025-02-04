<?php
include '../includes/dbconn.php';
require_once __DIR__ . "/vendor/autoload.php";

session_start();

// Retrieve the last inserted ID
$lastInsertedIDQuery = "SELECT MAX(historyID) AS lastInsertedID FROM `orderhistory`";
$lastInsertedIDResult = mysqli_query($conn, $lastInsertedIDQuery);

if (!$lastInsertedIDResult) {
    die('Error: ' . mysqli_error($conn));
}

$lastInsertedIDRow = mysqli_fetch_assoc($lastInsertedIDResult);
$historyID = $lastInsertedIDRow['lastInsertedID'];

// Validate $historyID to prevent SQL injection
$historyID = mysqli_real_escape_string($conn, $historyID);

$sql = "SELECT *, users.Name FROM `orderhistory` JOIN `users` ON orderhistory.CashierID = users.userID WHERE historyID = '$historyID'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// HTML content
$html = "
<!doctype html>
<html lang='en'>
<style>
    * {
        font-size: 20px;
    }
</style>
<body>
    <div>
        <p style='font-weight: bold; font-size: 1.5em; text-align: center;'>Order #{$historyID}</p>
        <table style=' width: 100%; border: 1px solid grey; text-align: start'>
            <tr>
                <td style='font-weight: Bold'>Date:</td>
                <td>{$row['Date']}</td>
                <td style='font-weight: Bold'>Cashier Name:</td>
                <td>{$row['Name']}</td>
            </tr>
            <tr>
                <td style='font-weight: Bold'>Customer Name:</td>
                <td>{$row['CustomerName']}</td>
                <td style='font-weight: Bold'>Total:</td>
                <td>{$row['Total']}</td>
            </tr>
            <tr>
                <td style='font-weight: Bold'>Amount Given:</td>
                <td>{$row['Amount_Given']}</td>
                <td style='font-weight: Bold'>Change:</td>
                <td>{$row['Change_']}</td>
            </tr>
        </table>
        <h4 style='text-align: center;'>Ordered Items</h4>
        <table style=' width: 100%; margin-top: 20px; text-align: center; '>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>";

// Additional HTML for the table body
$sql = "SELECT orderitems.*, products.Code, products.Name, products.MarkupPrice FROM `orderitems` JOIN 
                `products` ON orderitems.productID = products.ID WHERE orderitems.orderHistoryID = '$historyID'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$totalAmount = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $itemTotal = $row['Qty'] * $row['MarkupPrice'];
    $totalAmount += $itemTotal;

    // Append table rows to HTML
    $html .= "
        <tr>
            <td>{$row['Code']}</td>
            <td>{$row['Name']}</td>
            <td>{$row['MarkupPrice']}</td>
            <td style='text-align: center;'>{$row['Qty']}</td>
            <td style='text-align: center;'>{$itemTotal}</td>
        </tr>";
}

// Closing HTML tags
$html .= "
            </tbody>
        </table>
    </div>
</body>
</html>
";

// Create a PDF
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();

// Output PDF to browser
$dompdf->stream("Order#{$historyID}.pdf", ['Attachment' => 0]);
exit();
?>
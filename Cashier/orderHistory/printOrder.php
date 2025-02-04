<?php
require_once __DIR__ . "/vendor/autoload.php";
include '../includes/dbconn.php';
session_start();

$historyID = $_GET['historyID'];

// Validate $historyID to prevent SQL injection
$historyID = mysqli_real_escape_string($conn, $historyID);

$sql = "SELECT *, users.Name FROM `orderhistory` JOIN `users` ON orderhistory.CashierID = users.userID WHERE historyID = '$historyID'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="en">

<style>
    *{
        font-size: 20px;
    }
</style>
<body>
    <div>
        <p style="font-weight: bold; font-size: 1.5em; text-align: center;">Order #<?php echo $historyID ?></p>
        <table style="border: 1px solid black; width: 100%;">
            <tr>
                <td style="font-weight: bold">Date:</td>
                <td><?php echo $row['Date'] ?></td>
                <td style="font-weight: bold">Cashier Name:</td>
                <td><?php echo $row['Name'] ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Customer Name:</td>
                <td><?php echo $row['CustomerName'] ?></td>
                <td style="font-weight: bold">Total:</td>
                <td><?php echo $row['Total'] ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Amount Given:</td>
                <td><?php echo $row['Amount_Given'] ?></td>
                <td style="font-weight: bold">Change:</td>
                <td><?php echo $row['Change_'] ?></td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 20px; text-align: center;">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                ?>
                    <tr>
                        <td><?php echo $row['Code']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['MarkupPrice']; ?></td>
                        <td style="text-align: center;"><?php echo $row['Qty']; ?></td>
                        <td style="text-align: center;"><?php echo $itemTotal; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
use Dompdf\Dompdf;

$dompdf = new Dompdf();

// You need to pass the HTML content to load_html() method
$html = ob_get_clean();
$dompdf->load_html($html);

$dompdf->render();
$dompdf->stream("Order#" . $historyID . ".pdf", array("Attachment" => 0));
exit();
?>
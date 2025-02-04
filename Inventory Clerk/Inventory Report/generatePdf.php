<?php
include "../includes/dbconn.php";
require_once __DIR__ . "/vendor/autoload.php";
use Dompdf\Dompdf;

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Report</title>
    <style>
             table {
             border-collapse: collapse;
             width: 100%;
             font-size:16px;
        }

         th, td {
            border: 2px solid Grey;
            padding: 6px;
            text-align: left;
        }

        th {
         background-color: #f2f2f2;
         }
        p{
        font-size: 26px;
         text-align: center;
        }
    </style>
</head>

<body>
    <p>Inventory Report - <?php echo date('Y-m-d'); ?></p>
     <table>
        <thead>
         <tr>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Stock</th>
                <th scope="col">SRP</th>
                <th scope="col">Markup Price</th>
                <th scope="col">Profit</th>
                <th scope="col">Sold</th>
                <th scope="col">Loss</th>
                 <th scope="col">Return</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `products`";
            $result = mysqli_query($conn, $sql);

         while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['Code']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Stock']; ?></td>
                    <td><?php echo $row['SRP']; ?></td>
                    <td><?php echo $row['MarkupPrice']; ?></td>
                    <td><?php echo $row['MarkupPrice'] - $row['SRP']; ?></td>
                    <td><?php echo $row['SoldQty']; ?></td>
                    <td><?php echo $row['LossQty']; ?></td>
                    <td><?php echo $row['ReturnQty']; ?></td>
                </tr>
            <?php
             }
             ?>
         </tbody>
        </table>
</body>

</html>

<?php
$dompdf = new Dompdf();

$html = ob_get_clean();
$dompdf->load_html($html);
$filename = 'Report_' . date('Y-m-d') . '.pdf';

$dompdf->render();
$dompdf->stream($filename, array("Attachment" => 0));
exit();
?>
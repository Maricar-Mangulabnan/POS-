<?php
include '../includes/dbconn.php';
require_once __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
// Check if the dateRange parameter is set in the URL
if (isset($_GET['dateRange'])) {
    // Retrieve and sanitize the dateRange parameter
    $dateRange = mysqli_real_escape_string($conn, $_GET['dateRange']);

    // Split the date range into start and end dates
    list($startDate, $endDate) = explode(' - ', $dateRange);

    // Convert the dates to the required format (adjust as needed)
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT products.Code, products.Name, products.MarkUpPrice, 
            SUM(orderitems.Qty) AS SumQuantity,
            SUM(orderitems.Qty * products.MarkUpPrice) AS TotalSales
            FROM orderitems 
            JOIN `products` ON orderitems.productID = products.ID 
            WHERE DATE(orderitems.Date) BETWEEN '$startDate' AND '$endDate'
            GROUP BY products.Code, products.Name
            ORDER BY SumQuantity DESC";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Capture HTML content with date range
            $html = '<div style="text-align: center;">
            <h3>Date: ' . $dateRange . '</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" border="1">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px;">Product Code</th>
                    <th style="padding: 10px;">Product Name</th>
                    <th style="padding: 10px;">Total Quantity Sold</th>
                    <th style="padding: 10px;">Total Sales</th>
                </tr>
            </thead>
            <tbody>';

            $overall = 0; // Initialize overall variable

            while ($row = mysqli_fetch_assoc($result)) {
                $overall += $row['TotalSales'];
                $html .= '<tr>
                    <td style="padding: 10px; text-align: center;">' . $row['Code'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['Name'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['SumQuantity'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['TotalSales'] . '</td>
                </tr>';
            }

            $html .= '<tr>
                    <td style="padding: 10px;"></td>
                    <td style="padding: 10px;"></td>
                    <th style="padding: 10px; text-align: center;">Total Sales:</th>
                    <th style="padding: 10px; text-align: center;">' . $overall . '</th>
                </tr>';
            $html .= '</tbody></table>';

            $dompdf = new Dompdf();

            // Load HTML content into Dompdf
            $dompdf->loadHtml($html);

            // Render PDF
            $dompdf->render();

            // Output the PDF as a downloadable file
            $fileName = "salesReport.pdf";
            $dompdf->stream($fileName, ['Attachment' => 0]);
            exit();
        } else {
            $html = '<div style="text-align: center;">
            <h3>No Data</h3>
        </div>
        <table style="width: 100%; margin-top: 20px;" border="1">
            <thead>
                <tr>
                    <th style="padding: 10px;">Product Code</th>
                    <th style="padding: 10px;">Product Name</th>
                    <th style="padding: 10px;">Total Quantity Sold</th>
                    <th style="padding: 10px;">Total Sales</th>
                </tr>
            </thead>
            <tbody>';
            $html .= '</tbody></table>';

            $dompdf = new Dompdf();

            // Load HTML content into Dompdf
            $dompdf->loadHtml($html);

            // Render PDF
            $dompdf->render();

            // Output the PDF as a downloadable file
            $fileName = "salesReport.pdf";
            $dompdf->stream($fileName, ['Attachment' => 0]);
            exit();
        }
    }
} else {
    $sql = "SELECT products.Code, products.Name, products.MarkUpPrice, 
            SUM(orderitems.Qty) AS SumQuantity,
            SUM(orderitems.Qty * products.MarkUpPrice) AS TotalSales
            FROM orderitems 
            JOIN `products` ON orderitems.productID = products.ID 
            GROUP BY products.Code, products.Name
            ORDER BY SumQuantity DESC";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Capture HTML content with date range
            $html = '<div style="text-align: center;">
            <h3>Sales Report</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" border="1">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px;">Product Code</th>
                    <th style="padding: 10px;">Product Name</th>
                    <th style="padding: 10px;">Total Quantity Sold</th>
                    <th style="padding: 10px;">Total Sales</th>
                </tr>
            </thead>
            <tbody>';

            $overall = 0; // Initialize overall variable

            while ($row = mysqli_fetch_assoc($result)) {
                $overall += $row['TotalSales'];
                $html .= '<tr>
                    <td style="padding: 10px; text-align: center;">' . $row['Code'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['Name'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['SumQuantity'] . '</td>
                    <td style="padding: 10px; text-align: center;">' . $row['TotalSales'] . '</td>
                </tr>';
            }

            $html .= '<tr>
                    <td style="padding: 10px;"></td>
                    <td style="padding: 10px;"></td>
                    <th style="padding: 10px; text-align: center;">Total Sales:</th>
                    <th style="padding: 10px; text-align: center;">' . $overall . '</th>
                </tr>';
            $html .= '</tbody></table>';

            $dompdf = new Dompdf();

            // Load HTML content into Dompdf
            $dompdf->loadHtml($html);

            // Render PDF
            $dompdf->render();

            // Output the PDF as a downloadable file
            $fileName = "salesReport.pdf";
            $dompdf->stream($fileName, ['Attachment' => 0]);
            exit();
        }
    }
}

// Close the database connection
mysqli_close($conn);

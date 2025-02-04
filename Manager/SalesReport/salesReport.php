<?php
include '../includes/dbconn.php';
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS System - Maricar</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <!-- Boxicon Icons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../includes/style.css">

    <!-- Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"><?php echo $_SESSION['Name'] . ' - ' . $_SESSION['Position'] ?></div>
        <div class="header_img"> <img src="https://visualpharm.com/assets/381/Admin-595b40b65ba036ed117d3b23.svg" alt=""> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
    <nav class="nav">
            <div>
                <a href="" class="nav_logo">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">POS System</span>
                </a>
                <div class="nav_list">
                    <a href="../dashboard/dashboard.php" class="nav_link active">
                        <i class='bx bx-tachometer nav_icon'></i>
                        <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="../products/allProducts.php" class="nav_link">
                        <i class='bx bx-cart-alt nav_icon'></i>
                        <span class="nav_name">Products</span>
                    </a>
                    <a href="../CreateOrder/createOrder.php" class="nav_link">
                        <i class='bx bx-message-square-detail nav_icon'></i>
                        <span class="nav_name">Create order</span>
                    </a>
                    <a href="../orderHistory/history.php" class="nav_link">
                        <i class='bx bx-history nav_icon'></i>
                        <span class="nav_name">Order History</span>
                    </a>
                    <a href="../Inventory Report/inventoryReport.php" class="nav_link">
                        <i class='bx bxs-report nav_icon'></i>
                        <span class="nav_name">Inventory Reports</span>
                    </a> <a href="../SalesReport/salesReport.php" class="nav_link">
                        <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
                        <span class="nav_name">Sales Report</span>
                    </a>
                    <a href="../users/allUsers.php" class="nav_link">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Users</span>
                    </a>
                </div>
            </div>
            <a href="../logout.php" class="nav_link">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">Log out</span>
            </a>
        </nav>
    </div>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script -->
    <script src="../includes/index.js"></script>
    <!-- Container Main start -->
    <div class="bg-body text-center">
        <p class="text-start fw-bold fs-3 my-2">Sales Report</p>
        <div class="container" style="height: 100px;">
            <form method="post" action="salesReport.php">
                <div class="row">
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="datefilter" placeholder="Select date range" name="datefilter" style="width:100%; font-size: 16px;">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit" style="width:100%;"><i class="bi bi-calendar-check"></i></button>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-success" style="width:100%;" id="salesReportLink" href="../SalesReport/generateSalesReport.php" target="_blank">
                            <i class="bi bi-file-earmark-arrow-down-fill"></i>
                        </a>
                    </div>
                </div>
            </form>
            <div id="displayDataTable"></div>
        </div>
        <?php
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the selected date range from the form
            $selectedDateRange = $_POST['datefilter'];

            if (!empty($selectedDateRange)) {
                // Split the date range into start and end dates
                list($startDate, $endDate) = explode(' - ', $selectedDateRange);

                // Convert the dates to the required format (adjust as needed)
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                // Use prepared statements to prevent SQL injection
                $sql = "SELECT products.Code, products.Name, products.MarkUpPrice, 
                            SUM(orderitems.Qty) AS SumQuantity,
                            SUM(orderitems.Qty * products.MarkUpPrice) AS TotalSales
                            FROM orderitems 
                            JOIN `products` ON orderitems.productID = products.ID 
                            WHERE DATE(orderitems.Date) BETWEEN ? AND ?
                            GROUP BY products.Code, products.Name
                            ORDER BY SumQuantity DESC";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<p class="fw-bold fs-3">'. $selectedDateRange .'</p>
                        <table class="table table-bordered my-3">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>Product Code</th>
                                                <th>Product Name</th>
                                                <th>Total Quantity Sold</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                        $overall = 0; // Initialize overall variable

                        while ($row = mysqli_fetch_assoc($result)) {
                            $overall += $row['TotalSales'];
                            echo '<tr>
                                            <td>' . $row['Code'] . '</td>
                                            <td>' . $row['Name'] . '</td>
                                            <td>' . $row['SumQuantity'] . '</td>
                                            <td>₱ ' . $row['TotalSales'] . '</td>
                                        </tr>';
                        }

                        echo '<tr>
                                        <td></td>
                                        <td></td>
                                        <th>Total Sales:</th>
                                        <th> ₱ ' . $overall . '</th>
                                    </tr>';
                        echo '</tbody></table>';
                    } else {
                        echo '<p>No sales data available for the selected date range.</p>';
                    }
                } else {
                    echo '<p>Error: ' . mysqli_error($conn) . '</p>';
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else { // if the daterange dont have value
                $sql = "SELECT products.Code, products.Name, products.MarkUpPrice, 
                                    SUM(orderitems.Qty) AS SumQuantity,
                                    SUM(orderitems.Qty * products.MarkUpPrice) AS TotalSales
                                    FROM orderitems 
                                    JOIN `products` ON orderitems.productID = products.ID 
                                    GROUP BY products.Code, products.Name
                                    ORDER BY SumQuantity DESC";

                $result = mysqli_query($conn, $sql);

                echo '<p class="fw-bold fs-3">All Sales</p>
                <table class="table table-bordered my-4">
                                <thead>
                                    <tr class="bg-light">
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Total Quantity Sold</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $overall = 0; // Initialize overall variable
                while ($row = mysqli_fetch_assoc($result)) {
                    $overall += $row['TotalSales'];
                    echo '<tr>
                                                <td>' . $row['Code'] . '</td>
                                                <td>' . $row['Name'] . '</td>
                                                <td>' . $row['SumQuantity'] . '</td>
                                                <td>₱ ' . $row['TotalSales'] . '</td>
                                            </tr>';
                }
                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <th>Total Sales:</th>
                                    <th> ₱ ' . $overall . '</th>
                                </tr>';

                echo '</tbody></table>';
            }
        }
        ?>
    </div>
    <!-- Date Picker Script -->
    <script type="text/javascript">
        $(function() {
            // Variable to store the selected date range
            var selectedDateRange = '';

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                opens: 'top' // Set the calendar to open on top
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('MM/DD/YYYY');
                var endDate = picker.endDate.format('MM/DD/YYYY');
                selectedDateRange = startDate + ' - ' + endDate;

                $(this).val(selectedDateRange);
                // Set the value of the hidden input with the selected date range
                $('#selectedDateRange').val(selectedDateRange);

                // Update the sales report link with the selected date range
                updateSalesReportLink(selectedDateRange);
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                selectedDateRange = '';
                // Clear the value of the hidden input on cancel
                $('#selectedDateRange').val('');

                // Update the sales report link when the date range is cleared
                updateSalesReportLink(selectedDateRange);
            });

            // Function to update the sales report link
            function updateSalesReportLink(dateRange) {
                var salesReportLink = '../SalesReport/generateSalesReport.php?dateRange=' + encodeURIComponent(dateRange);
                $('#salesReportLink').attr('href', salesReportLink);
            }
        });
    </script>
</body>

</html>
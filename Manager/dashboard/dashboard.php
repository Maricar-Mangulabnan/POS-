<?php
include '../includes/dbconn.php';
session_start();

// Count the total number of rows from the 'products' table
$countSql = "SELECT COUNT(*) AS totalRows FROM `products` WHERE `Archive` != 'Yes'";
$countResult = mysqli_query($conn, $countSql);
$totalRows = mysqli_fetch_assoc($countResult)['totalRows'];

// Query to get the total sales and total orders from the 'orderhistory' table
$sqlTotal = "SELECT SUM(Total) AS totalSales FROM `orderhistory` WHERE `Status_` != 'Voided'";
$resultTotal = mysqli_query($conn, $sqlTotal);
$totalSales = mysqli_fetch_assoc($resultTotal)['totalSales'];

$sqlTotalOrder = "SELECT COUNT(*) AS totalOrder FROM `orderhistory` WHERE `Status_` != 'Voided'";
$resultOrder = mysqli_query($conn, $sqlTotalOrder);
$totalOrder = mysqli_fetch_assoc($resultOrder)['totalOrder'];

$sqlSales = "SELECT Date, SUM(Total) AS TotalSales FROM `orderhistory` GROUP BY Date;";
$resultSales = mysqli_query($conn, $sqlSales);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS System - Maricar</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Boxicon Icons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    </link>
    <!-- Style -->
    <link rel="stylesheet" href="../includes/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var salesData = <?php
                            $data = array();
                            while ($row = mysqli_fetch_assoc($resultSales)) {
                                $date = date('M j', strtotime($row['Date']));
                                $data[] = array($date, (float) $row['TotalSales']);
                            }
                            echo json_encode($data);
                            ?>;

            // Creating a DataTable from the extracted data
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Sales'],
                ...salesData
            ]);

            var options = {
                title: 'Sales',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
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
    <!--Container Main start-->
    <div class="bg-body text-center">
        <p class="text-start fw-bold fs-3">Dashboard</p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card text-center text-light" style="background-color: #776BCC;">
                        <div class="card-body"> 
                            <p class="card-title">Orders</p>
                            <i class='bx bx-list-ul fs-1'></i>
                            <p class="card-text fw-bold">Total Orders: <?php echo $totalOrder; ?></p>
                            <a href="../orderHistory/history.php" class="btn" style="background-color: #C7C5F4; border: 1px solid grey">See All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body text-light" style="background-color: #776BCC;">
                            <p class="card-title">Sales</p>
                            <i class='bx bx-money fs-1'></i>
                            <p class="card-text fw-bold">Total Sales: ₱ <?php echo $totalSales; ?></p>
                            <a href="../SalesReport/salesReport.php" class="btn" style="background-color: #C7C5F4; border: 1px solid grey">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body text-light" style="background-color: #776BCC;">
                            <p class="card-title">Products</p>
                            <i class='bx bx-basket fs-1'></i>
                            <p class="card-text fw-bold">Total Products: <?php echo $totalRows; ?></p>
                            <a href="../products/allProducts.php" class="btn" style="background-color: #C7C5F4; border: 1px solid grey">See All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div id="curve_chart" style="width: 100%; height: 650px"></div>
                </div>
                <div class="col-md-6 mb-3 ">
                    <table class="table">
                        <p class="fs-5"><i class='bx bx-folder-plus fs-3'></i> Recently Added</p>
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Title</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recently = "SELECT * FROM `products` WHERE `Archive` != 'Yes' ORDER BY `ID` DESC LIMIT 5";
                            $resultRecently = mysqli_query($conn, $recently);

                            while ($row = mysqli_fetch_assoc($resultRecently)) {
                            ?>
                                <tr>
                                    <th><?php echo $row['Code']; ?></th>
                                    <td><?php echo $row['Name']; ?></td>
                                    <td><?php echo $row['Stock']; ?></td>
                                    <td><?php echo $row['MarkupPrice']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p class="fs-5"><i class='bx bx-line-chart fs-3'></i> Best Selling </p>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Title</th>
                                <th scope="col">Sold</th>
                                <th scope="col">Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bestSeller = "SELECT * FROM `products` WHERE `Archive` != 'Yes' AND `SoldQty` != '0' ORDER BY `SoldQty` DESC LIMIT 5";
                            $resultbestSeller = mysqli_query($conn, $bestSeller);

                            while ($row = mysqli_fetch_assoc($resultbestSeller)) {
                            ?>
                                <tr>
                                    <th><?php echo $row['Code']; ?></th>
                                    <td><?php echo $row['Name']; ?></td>
                                    <td><?php echo $row['SoldQty']; ?></td>
                                    <td><?php echo $row['MarkupPrice']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
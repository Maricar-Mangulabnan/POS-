<?php
include '../includes/dbconn.php';
session_start();

$historyID = $_GET['historyID'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Boxicon Icons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    </link>
    <!-- Style -->
    <link rel="stylesheet" href="../includes/style.css">

    <script>
        function confirmVoidOrder(historyID) {
            var confirmMessage = "Are you sure you want to void this order?";
            if (window.confirm(confirmMessage)) {
                window.location.href = "voidOrder.php?historyID=" + historyID;
            }
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
                    <a href="/Admin/users/allUsers.php" class="nav_link">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Users</span>
                    </a>
                </div>
            </div>
            <a href="/Admin/logout.php" class="nav_link">
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
    <?php
    $sql = "SELECT *, users.Name FROM `orderhistory` JOIN `users` ON orderhistory.CashierID = users.userID WHERE historyID = '$historyID'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    ?>
    <a href="../orderHistory/history.php" class="btn btn-info my-3">Back</a>
    <div class="height-100 bg-body text-center">
        <p class="text-start fw-bold fs-3">Order #<?php echo $historyID ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <td scope="col"><?php echo $row['Date'] ?></td>
                    <th scope="col">Cashier Name</th>
                    <td scope="col"><?php echo $row['Name'] ?></td>
                </tr>
                <tr>
                    <th scope="col">Customer Name</th>
                    <td scope="col"><?php echo $row['CustomerName'] ?></td>
                    <th scope="col">Total</th>
                    <td scope="col"><?php echo $row['Total'] ?></td>
                </tr>
                <tr>
                    <th scope="col">Amount Given</th>
                    <td scope="col"><?php echo $row['Amount_Given'] ?></td>
                    <th scope="col">Change</th>
                    <td scope="col"><?php echo $row['Change_'] ?></td>
                </tr>
            </thead>
        </table>
        <table class="table mt-3 table-border table-success">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT orderitems.*, products.Code, products.Name, products.MarkupPrice FROM `orderitems` JOIN 
                `products` ON orderitems.productID = products.ID WHERE orderitems.orderHistoryID = '$historyID'";
                $result = mysqli_query($conn, $sql);
                $totalAmount = 0;
                while ($row = $result->fetch_assoc()) {
                    $itemTotal = $row['Qty'] * $row['MarkupPrice'];
                    $totalAmount += $itemTotal;
                    $orderID = $row['orderID'];
                ?>
                    <tr>
                        <th scope="row"><?php echo $row['Code']; ?></th>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['MarkupPrice']; ?></td>
                        <td class="text-center"><?php echo $row['Qty']; ?></td>
                        <td class="text-center"><?php echo $itemTotal; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
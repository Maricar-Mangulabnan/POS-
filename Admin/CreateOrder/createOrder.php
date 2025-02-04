<?php
include '../includes/dbconn.php';
session_start();
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

    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 600px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .vertical-line {
            border-left: 1px solid #dee2e6;
            height: 100%;
        }
    </style>
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
    <div class="height-100 bg-body text-center">
        <p class="text-start fw-bold fs-3">Create Order</p>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <p class="fs-5 fw-bold">Products</p>
                    <form method="GET" action="createOrder.php" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by Code or Name" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                    <table class="table mt-3 table-info">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if the search parameter is set in the URL
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                            // Modify the SQL query to include the search filter
                            $sql = "SELECT * FROM `products` WHERE `Archive` != 'Yes'";

                            // Add the search condition if the search parameter is provided
                            if ($search !== '') {
                                $sql .= " AND (`Code` LIKE '%$search%' OR `Name` LIKE '%$search%')";
                            }

                            $result = mysqli_query($conn, $sql);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['Name']; ?></td>
                                    <td><?php echo $row['Stock']; ?></td>
                                    <td><?php echo $row['MarkupPrice']; ?></td>
                                    <td>
                                        <a href="orderProduct.php?ID=<?php echo $row['ID']; ?>"><i class='bx bx-cart-add' style="font-size: 30px;"></i></a>

                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <p class="fs-5 fw-bold">Order</p>
                <table class="table mt-3 table-border">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                            <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT orderitems.*, products.Code, products.Name, products.MarkupPrice FROM `orderitems` JOIN `products` ON orderitems.productID = products.ID WHERE orderitems.Archive != 'Yes'";
                        $result = mysqli_query($conn, $sql);
                        $totalAmount = 0;
                        while ($row = $result->fetch_assoc()) {
                            $itemTotal = $row['Qty'] * $row['MarkupPrice'];
                            $totalAmount += $itemTotal;
                            $orderID = $row['orderID'];

                            // Collect order IDs in the array
                            $orderIDs[] = $orderID;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row['Code']; ?></th>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['MarkupPrice']; ?></td>
                                <td class="text-center"><?php echo $row['Qty']; ?></td>
                                <td class="text-center"><?php echo $itemTotal; ?></td>
                                <td class="text-center">
                                        <a href="orderIncrease.php?productID=<?php echo $row['productID']; ?>"><i class='bx bx-message-square-add text-success' style="font-size: 30px;"></i></a>
                                        <a href="orderReduce.php?productID=<?php echo $row['productID']; ?>"><i class='bx bx-message-square-minus text-warning' style="font-size: 30px;"></i></a>
                                        <a href="orderDelete.php?productID=<?php echo $row['productID']; ?>"><i class='bx bxs-trash text-danger' style="font-size: 30px;"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <?php
                            if ($totalAmount == 0) {
                            ?>
                                <td></td>
                            <?php
                            } else {
                            ?>
                                <td><a href="payOrders.php?orderIDs=<?php echo implode(',', $orderIDs); ?>" class="btn btn-success">Proceed</a></td>
                            <?php
                            }
                            ?>
                            <th class="">Total:</th>
                            <th class="text-center"><?php echo $totalAmount; ?></th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$_SESSION['total'] = $totalAmount;
?>
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
    <div class=" bg-body text-center">
        <p class=" text-start fw-bold fs-3">Products</p>
        <!-- Search form -->
        <form method="GET" action="allProducts.php" class="mb-3">
            <div class="input-group">
                <a href="addProduct.php" class="btn btn-info">Add Product</a>
                <input type="text" class="form-control" placeholder="Search by Code or Name" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">SRP</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Loss</th>
                    <th scope="col">Return</th>
                    <th scope="col">Status</th>
                    <th scope="col">Operations</th>
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
                        <th scope="row"><?php echo $row['ID']; ?></th>
                        <td><?php echo $row['Code']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Stock']; ?></td>
                        <td><?php echo $row['SRP']; ?></td>
                        <td><?php echo $row['MarkupPrice']; ?></td>
                        <td><?php echo $row['SoldQty']; ?></td>
                        <td><?php echo $row['LossQty']; ?></td>
                        <td><?php echo $row['ReturnQty']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td>
                            <a href="editProduct.php?ID=<?php echo $row['ID']; ?>"><i class='bx bx-edit text-info' style="font-size: 30px;"></i></a>
                            <a href="loss.php?ID=<?php echo $row['ID']; ?>"><i class='bx bx-box text-warning' style="font-size: 30px;"></i></a>
                            <a href="deleteProduct.php?ID=<?php echo $row['ID']; ?>"><i class='bx bx-trash text-danger' style="font-size: 30px;"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <!-- Second Table -->
        <p class=" text-start fw-bold fs-3">Deleted Products</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">SRP</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Status</th>
                    <th scope="col">Relist</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the search parameter is set in the URL
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Modify the SQL query to include the search filter
                $sql = "SELECT * FROM `products` WHERE `Archive` = 'Yes'";

                // Add the search condition if the search parameter is provided
                if ($search !== '') {
                    $sql .= " AND (`Code` LIKE '%$search%' OR `Name` LIKE '%$search%')";
                }

                $result = mysqli_query($conn, $sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $row['ID']; ?></th>
                        <td><?php echo $row['Code']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['SRP']; ?></td>
                        <td><?php echo $row['MarkupPrice']; ?></td>
                        <td><?php echo $row['SoldQty']; ?></td>
                        <td class="bg-danger text-light"><?php echo $row['Status']; ?></td>
                        <td>
                            <a href="relistProduct.php?ID=<?php echo $row['ID']; ?>" onclick="return confirmRelist();">
                                <i class='bx bxs-upvote text-success' style="font-size: 30px;"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmRelist() {
            return confirm("Are you sure you want to relist this product?");
        }
    </script>
</body>

</html>
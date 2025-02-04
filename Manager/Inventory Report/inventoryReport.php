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
    <div class="height-100 bg-body text-center">
        <p class="text-start fw-bold fs-3" >Inventory Report 
        <a href="generatePdf.php" target="_blank" class="btn btn-info my-1 pt-2 pb-1"><i class='bx bxs-file-pdf fs-4'></i></a>
        </p>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">SRP</th>
                    <th scope="col">Profit</th>
                    <th scope="col">Sold</th>
                    <th scope="col">Loss</th>
                    <th scope="col">Return</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM `products` WHERE `Archive` != 'Yes'";
            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)){
                if($row['Stock'] <= 10){
                    $textColor = 'bg-danger text-light';
                }elseif($row['Stock'] <= 20){
                    $textColor = 'bg-warning text-light';
                }elseif($row['Stock'] >= 21){
                    $textColor = 'bg-success text-light';
                }
            ?>
                <tr>
                        <td><?php echo $row['Code']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td class="<?php echo $textColor?>"><?php echo $row['Stock']; ?></td>
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
    </div>
</body>

</html>
<?php
include "../includes/dbconn.php";
session_start();

$ID = $_GET['ID'];

$sql = "SELECT * FROM `products` WHERE `ID` = '{$ID}'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$Code = $row['Code'];
$Name = $row['Name'];
$Stock = $row['Stock'];
$SRP = $row['SRP'];
$MarkupPrice = $row['MarkupPrice'];
$Status = $row['Status'];
?>

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
                    <a href="../Inventory Report/inventoryReport.php" class="nav_link">
                        <i class='bx bxs-report nav_icon'></i>
                        <span class="nav_name">Inventory Reports</span>
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
        <div class="text-start">
        <a href="../products/allProducts.php" class="btn btn-primary my-3">Back</a>
        </div>
        <p class="text-start fw-bold fs-3">Edit Product</p>
        <div class="container">
            <div class="row justify-content-center">
                <form class="text-start" method="POST" action="sqlEditProduct.php?ID=<?php echo $row['ID']; ?>">
                    <div class="mb-3">
                        <label for="inputCode" class="form-label">Code</label>
                        <input type="number" class="form-control" id="inputCode" name="inputCode" value="<?php echo $Code; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo $Name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="inputStock" name="inputStock" value="<?php echo $Stock; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputSRP" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="inputSRP" name="inputSRP" value="<?php echo $SRP; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputMarkupPrice" class="form-label">SRP</label>
                        <input type="number" class="form-control" id="inputMarkupPrice" name="inputMarkupPrice" value="<?php echo $MarkupPrice; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputStatus" class="form-label">Status</label>
                        <select class="form-select" name="inputStatus" required>
                            <option value="Active" <?php echo ($Status == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Discontinued" <?php echo ($Status == 'Discontinued') ? 'selected' : ''; ?>>Discontinued</option>
                        </select>
                    </div>
                    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                    <div class="mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
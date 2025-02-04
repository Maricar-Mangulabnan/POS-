<?php
include "../Admin/includes/dbconn.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE Email = '{$email}' AND Password = '{$password}' AND `Status` != 'Inactive'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $_SESSION['active'] = 'True';

    while ($rowUser = $result->fetch_assoc()) {
        if ($rowUser['Position'] == 'Admin') {
            $_SESSION['activeAdmin'] = 'True';
            $_SESSION['Name'] = $rowUser['Name'];
            $_SESSION['Position'] = $rowUser['Position'];
            $_SESSION['userID'] = $rowUser['userID'];
            header('Location: ../Admin/index.php');
        } elseif ($rowUser['Position'] == 'Manager') {
            $_SESSION['activeManager'] = 'True';
            $_SESSION['Name'] = $rowUser['Name'];
            $_SESSION['Position'] = $rowUser['Position'];
            $_SESSION['userID'] = $rowUser['userID'];
            header('Location: ../Manager/index.php');
        } elseif ($rowUser['Position'] == 'Inventory Clerk') {
            $_SESSION['activeInventoryClerk'] = 'True';
            $_SESSION['Name'] = $rowUser['Name'];
            $_SESSION['Position'] = $rowUser['Position'];
            $_SESSION['userID'] = $rowUser['userID'];
            header('Location: ../Inventory Clerk/index.php');
        } elseif ($rowUser['Position'] == 'Cashier') {
            $_SESSION['activeCashier'] = 'True';
            $_SESSION['Name'] = $rowUser['Name'];
            $_SESSION['Position'] = $rowUser['Position'];
            $_SESSION['userID'] = $rowUser['userID'];
            header('Location: ../Cashier/index.php');
        }
    }
}else{
    $_SESSION['error']= "Wrong Username or Password";
    header('Location: ../index.php');
    
}
?>
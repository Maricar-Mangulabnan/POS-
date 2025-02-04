<?php
include '../includes/dbconn.php';

$userID = $_GET['userID'];

// Retrieve user status
$sqlStatus = "SELECT `Status` FROM `users` WHERE `userID` = '{$userID}'";
$resultStatus = mysqli_query($conn, $sqlStatus);
$rowStatus = mysqli_fetch_assoc($resultStatus);
$userStatus = $rowStatus['Status'];

// Check if the user has an active status
if ($userStatus == 'Active') {
    echo '<script>alert("Cannot delete an active user."); window.location.href = "allUsers.php";</script>';
    exit();
}

// Perform the deletion if the user is not active
$sqlDelete = "UPDATE `users` SET `Archive` = 'Yes' WHERE `userID` = '{$userID}'";
$resultDelete = mysqli_query($conn, $sqlDelete);

header('Location: allUsers.php');
?>
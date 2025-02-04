<?php
include '../includes/dbconn.php';

$userID = $_GET['userID'];


// Perform the deletion if the user is not active
$sqlDelete = "UPDATE `users` SET `Archive` = 'No' WHERE `userID` = '{$userID}'";
$resultDelete = mysqli_query($conn, $sqlDelete);

header('Location: allUsers.php');
?>
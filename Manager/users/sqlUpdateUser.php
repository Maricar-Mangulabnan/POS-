<?php
include '../includes/dbconn.php';

$name = $_POST['inputName'];
$inputContact = $_POST['inputContact'];
$inputStatus = $_POST['inputStatus'];
$inputEmail = $_POST['inputEmail'];
$inputPassword = $_POST['inputPassword'];
$inputPosition = $_POST['inputPosition'];
$userID = $_GET['userID'];

$sql = "UPDATE `users` SET  `Name` = '$name', `Contact` = '$inputContact', `Email` = '$inputEmail', `Password` = '$inputPassword', `Position` = '$inputPosition', `Status` = '$inputStatus' WHERE `userID` = '$userID'";

$result = mysqli_query($conn, $sql);

header('Location: allUsers.php')
?>
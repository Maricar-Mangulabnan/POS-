<?php
include '../includes/dbconn.php';

$name = $_POST['inputName'];
$inputContact = $_POST['inputContact'];
$inputStatus = $_POST['inputStatus'];
$inputEmail = $_POST['inputEmail'];
$inputPassword = $_POST['inputPassword'];
$inputPosition = $_POST['inputPosition'];

$sql = "INSERT INTO `users` (Name, Contact, Email, Password, Position, Status) VALUES ('$name', '$inputContact', '$inputEmail', '$inputPassword', '$inputPosition', '$inputStatus')";

$result = mysqli_query($conn, $sql);

header('Location: allUsers.php')
?>
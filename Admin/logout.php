<?php
include '../Admin/includes/dbconn.php';
session_start();

session_destroy();
header('Location: ../index.php');
?>
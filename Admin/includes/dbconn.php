<?php
$conn = new mysqli('localhost', 'root', '', 'db_pos');

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

<?php
require 'connection.php';
$conn = Connect();

$id = $_GET['id'] ?? '';


$sql1 = "UPDATE customers SET status='approve' WHERE customer_username = '$id' ";
$result1 = $conn->query($sql1);
header("location: pending_users.php")
?>
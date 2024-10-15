<?php // delete_user.php
$id = $_GET['id'];

$conn = new mysqli('localhost', 'username', 'password', 'database');
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: users.php");
exit();

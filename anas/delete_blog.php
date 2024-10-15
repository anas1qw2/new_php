<?php
// delete_blog.php
$id = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'blog_platform');
$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: blogs.php");
exit();

?>

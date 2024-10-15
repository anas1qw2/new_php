<?php
session_start();

// Establish database connection
$host = 'localhost';
$dbname = 'blog_platform';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete the message from the database
    $sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: view_messages.php?success=Message deleted successfully.");
        exit();
    } else {
        die("Error deleting message: " . $conn->error);
    }
} else {
    die("No ID provided.");
}

// Close the database connection
$conn->close();


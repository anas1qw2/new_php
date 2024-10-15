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
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve message data for editing
    $sql = "SELECT * FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $message = $result->fetch_assoc();
    } else {
        die("Message not found.");
    }
} else {
    die("No ID provided.");
}

// Handle form submission for updating the message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message_text = $_POST['message'];

    // Update the message in the database
    $sql = "UPDATE contact_messages SET name = ?, email = ?, message = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $name, $email, $message_text, $id);

    if ($stmt->execute()) {
        header("Location: view_messages.php?success=Message updated successfully.");
        exit();
    } else {
        die("Error updating message: " . $conn->error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message - Blog Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-2xl font-semibold mb-6">Edit Message</h1>

        <form action="" method="POST" class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($message['name']); ?>" class="border rounded w-full py-2 px-3" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($message['email']); ?>" class="border rounded w-full py-2 px-3" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700">Message</label>
                <textarea name="message" id="message" rows="4" class="border rounded w-full py-2 px-3" required><?php echo htmlspecialchars($message['message']); ?></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Message</button>
        </form>
    </div>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>

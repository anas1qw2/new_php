<?php
session_start();
require 'db.php';

// Ensure the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle blog creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert statement (without image_url)
    $stmt = $conn->prepare("INSERT INTO blogs (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing blogs
$sql = "SELECT id, title, created_at FROM blogs ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex-grow: 1;
        }
    </style>
</head>
<body class="bg-gray-100">
<header class="bg-white shadow-lg">
    <nav class="container mx-auto px-6 py-6 flex items-center">
        <div class="logo-container flex items-center">
            <img src="./images/imc.png" alt="Blog Logo" class="h-16 w-auto mr-3">
            <span class="text-gray-800 text-4xl font-bold">Blog and Grow</span>
        </div>
        <ul class="flex items-center space-x-8 ml-auto">
            <li><a href="index.php" class="text-gray-700 hover:text-blue-500 text-lg font-semibold">Home</a></li>
            <li><a href="about.html" class="text-gray-700 hover:text-blue-500 text-lg font-semibold">About</a></li>
            <li><a href="contact.html" class="text-gray-700 hover:text-blue-500 text-lg font-semibold">Contact</a></li>
            <li><a href="blogs.php" class="text-gray-700 hover:text-blue-500 text-lg font-semibold">Blogs</a></li>
        </ul>
    </nav>
</header>

<main class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Admin Dashboard</h2>
    <h3 class="text-lg mb-6">Welcome Admin, <?php echo htmlspecialchars($_SESSION['username']); ?></h3>

    <!-- Blog Creation Form -->
    <form method="POST" action="admin_dashboard.php" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-md mb-6">
        <label for="title" class="block mb-2">Blog Title:</label>
        <input type="text" name="title" required class="border border-gray-300 p-2 w-full mb-4 rounded">
        
        <label for="content" class="block mb-2">Blog Content:</label>
        <textarea name="content" required class="border border-gray-300 p-2 w-full mb-4 rounded"></textarea>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Create Blog</button>
    </form>

    <!-- Blog Management Section -->
    <h3 class="text-lg mb-4">Manage Blogs</h3>
    <div class="overflow-x-auto">
        <?php if ($result->num_rows > 0): ?>
            <table class="min-w-full bg-white border border-gray-300 rounded shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">Created At</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                                <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline ml-4">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">No blogs available.</p>
        <?php endif; ?>
    </div>
</main>

<footer class="bg-white py-4 mt-6">
    <div class="container mx-auto text-center">
        <p class="text-gray-600">© 2024 Blog and Grow. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

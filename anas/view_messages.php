<?php
// Start the session at the beginning
session_start();

// Establish database connection
$host = 'localhost';
$dbname = 'blog_platform';
$user = 'root';  // Use your database username
$pass = '';  // Use your database password

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve contact messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY id DESC"; // Assuming 'id' is your primary key
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages - Blog Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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

        .logo-container img {
            max-width: 100px;
            margin-right: 10px;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
<header class="bg-white shadow-lg">
        <nav class="container mx-auto px-6 py-4 flex items-center">
            <div class="logo-container flex items-center">
                <img src="./images/imc.png" alt="Blog Logo">
                <span class="text-gray-800 text-2xl font-semibold">Blog and Grow</span>
            </div>
            <ul class="flex items-center space-x-6 ml-auto">
                <li><a href="index.php" class="text-gray-700 hover:text-blue-500 font-semibold">Home</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin'): ?>
                    <li><a href="about.html" class="text-gray-700 hover:text-blue-500 font-semibold">About</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin'): ?>
                    <li><a href="contact.php" class="text-gray-700 hover:text-blue-500 font-semibold">Contact</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li><a href="view_messages.php" class="text-gray-700 hover:text-blue-500 font-semibold">Feedbacks</a></li>
                <?php endif; ?>
                <li><a href="blogs.php" class="text-gray-700 hover:text-blue-500 font-semibold">Blogs</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li><a href="create_blog.php" class="text-gray-700 hover:text-blue-500 font-semibold">Add Blog</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="text-gray-700 hover:text-blue-500 font-semibold">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- Main Container -->
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-semibold text-gray-800 mb-6">Contact Messages</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Message</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Actions</th> <!-- New Actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['created_at']); // Assuming you have a created_at field ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="edit_message.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                                <form action="delete_message.php" method="POST" class="inline-block">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">No messages found.</p>
        <?php endif; ?>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <p class="text-center">&copy; 2024 Blog Platform. All Rights Reserved.</p>
    </footer>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>

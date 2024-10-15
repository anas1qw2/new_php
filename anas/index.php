<?php
session_start(); // Start the session

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'blog_platform';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is an admin
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// Handle deletion of a blog
if ($is_admin && isset($_GET['delete_blog_id'])) {
    $delete_blog_id = $_GET['delete_blog_id'];
    $delete_sql = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_blog_id);
    if ($stmt->execute()) {
        echo "<script>alert('Blog deleted successfully'); window.location.href='blogs.php';</script>";
    } else {
        echo "<script>alert('Error deleting blog: " . $conn->error . "');</script>";
    }
}

// Fetch blogs
$stmt = $conn->prepare("SELECT * FROM blogs");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

// Handle deletion of a user
if ($is_admin && isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='blogs.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A professional blog platform to share and grow ideas.">
    <meta name="keywords" content="Blog, Professional, Writing, Articles">
    <title>Professional Blog Landing Page</title>
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
        .custom-button {
    padding: 0.25rem 0.5rem; /* Adjust padding */
    font-size: 0.875rem; /* Adjust font size */
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <?php if ($_SESSION['role'] !== 'admin'): ?>
                    <li><a href="about.php" class="text-gray-700 hover:text-blue-500 font-semibold">About</a></li>
                    <li><a href="contact.php" class="text-gray-700 hover:text-blue-500 font-semibold">Contact</a></li>
                <?php endif; ?>
                <?php if ($is_admin): ?>
                    <li><a href="view_messages.php" class="text-gray-700 hover:text-blue-500 font-semibold">Feedbacks</a></li>
                    <li><a href="create_blog.php" class="text-gray-700 hover:text-blue-500 font-semibold">Add Blog</a></li>
                <?php endif; ?>
                <li><a href="blogs.php" class="text-gray-700 hover:text-blue-500 font-semibold">Blogs</a></li>
                <li><a href="logout.php" class="text-gray-700 hover:text-blue-500 font-semibold">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-12">
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105'>";
                    echo "<h2 class='text-2xl font-semibold mb-2 text-gray-800'>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p class='text-gray-600'>" . htmlspecialchars(substr($row['content'], 0, 150)) . "...</p>";
                    echo "<a href='view_blog.php?id=" . $row['id'] . "' class='mt-4 inline-block text-blue-500 hover:text-blue-700 font-semibold'>Read More</a>";

                    // Show edit and delete options only to admin
                    if ($is_admin) {
                        echo "<div class='mt-4'>";
                        echo "<a href='edit_blog.php?id={$row['id']}' class='text-blue-500'>Edit</a> | ";
                        echo "<a href='?delete_blog_id={$row['id']}' class='text-red-500' onclick='return confirm(\"Are you sure you want to delete this blog?\");'>Delete</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p class='text-gray-600'>No blogs found.</p>";
            }
            ?>
        </section>
        <?php if ($is_admin): ?>
    <h2 class="mt-12 text-xl font-semibold">User Management</h2>
    
<div class="mb-4">
    <a href="add_user.php" class="flex items-center justify-center bg-blue-500 text-white w-12 h-12 rounded-full hover:bg-blue-600 transition-all duration-200">
        <i class="fas fa-plus text-xl"></i>
    </a>
</div>

    <section class="grid grid-cols-1 gap-8 mt-4">
        <?php
        // Fetch user details
        $user_sql = "SELECT * FROM users";
        $user_result = $conn->query($user_sql);

        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                echo "<div class='bg-white rounded-lg shadow p-4 flex justify-between items-center'>";
                echo "<div class='flex flex-col'>";
                echo "<a href='view.php?id={$user_row['id']}' class='text-gray-800 font-bold text-lg'>" . htmlspecialchars($user_row['username']) . "</a>";
                echo "<p class='text-gray-600'>" . htmlspecialchars($user_row['role']) . "</p>";
                echo "<p class='text-gray-500 mt-2'>Comments: " . (isset($user_row['comments']) ? htmlspecialchars($user_row['comments']) : 'No comments available.') . "</p>";
                echo "<div class='flex mt-2'>";

                if (isset($user_row['company_name'])) {
                    echo "<i class='fa-solid fa-house mr-2' style='color: rgb(80, 74, 74);'></i><p class='text-gray-600'>" . htmlspecialchars($user_row['company_name']) . "</p>";
                }
                if (isset($user_row['location'])) {
                    echo "<i class='fa-solid fa-location-dot mr-2' style='color: rgb(80, 74, 74);'></i><p class='text-gray-600'>" . htmlspecialchars($user_row['location']) . "</p>";
                }

                echo "</div></div>";

                // Show edit and delete options only to admin
                echo "<div class='flex space-x-4'>";
                echo "<a href='edit.php?id={$user_row['id']}' class='text-blue-500'>Edit</a>";
                echo "<a href='?delete_id={$user_row['id']}' class='text-red-500' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-gray-600'>No users found.</p>";
        }
        ?>
    </section>
<?php endif; ?>

    </main>

    <footer class="bg-white text-center py-4 shadow-lg">
        <p class="text-gray-600">© 2024 Blog and Grow. All rights reserved.</p>
    </footer>
</body>

</html>

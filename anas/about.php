<?php
session_start(); // Start the session at the beginning of the file

// Initialize $is_admin based on the session or your logic
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn more about our blog platform, our story, and the team behind it.">
    <meta name="keywords" content="blog platform, about us, team, professional writing, content creation">
    <title>About Us - Blog Platform</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="./css/about.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Custom styles for the header */
        header {
            padding: 1rem 0; /* Reduced padding */
            background-color: white; /* White background for the header */
        }
        .logo-container img {
            height: 40px; /* Set a specific height for the logo */
        }
        .nav-item {
            font-size: 0.9rem; /* Adjusted font size for navigation items */
            color: black; /* Black text color */
        }
        .nav-item:hover {
            color: blue; /* Change text color on hover */
        }
    </style>
</head>
<body> <header class="bg-white shadow-lg">
        <nav class="container mx-auto px-6 py-4 flex items-center">
            <div class="logo-container flex items-center">
                <img src="./images/imc.png" alt="Blog Logo">
                <span class="text-gray-800 text-2xl font-semibold">Blog and Grow</span>
            </div>
            <ul class="flex items-center space-x-6 ml-auto">
                <li><a href="index.php" class="text-gray-700 hover:text-blue-500 font-semibold">Home</a></li>

                <?php if ($_SESSION['role'] !== 'admin'): ?> <!-- Show About link only for normal users -->
                    <li><a href="about.php" class="text-gray-700 hover:text-blue-500 font-semibold">About</a></li>
                <?php endif; ?>

                <?php if ($_SESSION['role'] !== 'admin'): ?> <!-- Show Contact link only for normal users -->
                    <li><a href="contact.php" class="text-gray-700 hover:text-blue-500 font-semibold">Contact</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li><a href="view_messages.php" class="text-gray-700 hover:text-blue-500 font-semibold">feedbacks</a>
                    </li>
                <?php endif; ?>
                <li><a href="blogs.php" class="text-gray-700 hover:text-blue-500 font-semibold">Blogs</a></li>
                <?php if ($is_admin): ?>
                    <li><a href="create_blog.php" class="text-gray-700 hover:text-blue-500 font-semibold">Add Blog</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="text-gray-700 hover:text-blue-500 font-semibold">Logout</a></li>
            </ul>
        </nav>
    </header>


    <!-- Navigation -->
    <header>
        <nav class="container mx-auto px-6 flex items-center">
            <div class="logo-container flex items-center">
                <img src="./images/imc.png" alt="Blog Logo">
                <span class="text-gray-800 text-xl font-semibold">Blog and Grow</span> <!-- Adjusted font size -->
            </div>
            <ul class="flex items-center space-x-6 ml-auto">
                <li><a href="index.php" class="nav-item font-semibold">Home</a></li>
                
                <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                    <li><a href="about.html" class="nav-item font-semibold">About</a></li>
                <?php endif; ?>

                <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                    <li><a href="contact.php" class="nav-item font-semibold">Contact</a></li>
                <?php endif; ?>

                <li><a href="blogs.php" class="nav-item font-semibold">Blogs</a></li>
                <?php if ($is_admin): ?>
                    <li><a href="create_blog.php" class="nav-item font-semibold">Add Blog</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="nav-item font-semibold">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- About Us Section -->
    <main class="container mx-auto px-6 py-12">
        <section>
            <h1 class="text-4xl font-semibold mb-4">About Us</h1>
            <p class="text-lg mb-8">Our platform makes blogging accessible to everyone, helping individuals express their thoughts, passions, and stories in a creative way.</p>
            <h2 class="text-3xl font-semibold mb-4">Our Story</h2>
            <p class="text-lg mb-6">Founded in 2020, we started as a small project aimed at empowering voices from diverse backgrounds.</p>
            <img src="./images/6.png" alt="Our Story" class="about-image mb-12">
            <h2 class="text-2xl font-semibold mb-4">Meet the Team</h2>
            <div class="team grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">
                <div class="team-member flex flex-col items-center text-center">
                    <img src="./images/anas.jpg" alt="Anas - Content Writer" class="team-photo mb-4">
                    <h3 class="text-lg font-semibold">Anas</h3>
                    <p class="text-gray-600">Manages styling and content writing, bringing creativity to the platform.</p>
                </div>
                <div class="team-member flex flex-col items-center text-center">
                    <img src="./images/5.png" alt="Huzefa - Developer" class="team-photo mb-4">
                    <h3 class="text-lg font-semibold">Huzefa</h3>
                    <p class="text-gray-600">Ensures our platform is responsive and visually appealing.</p>
                </div>
                <div class="team-member flex flex-col items-center text-center">
                    <img src="https://th.bing.com/th?id=OIP.dQKmLGYl3kucD13lv2QOuAHaJQ&w=223&h=279&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2" alt="Yasin - Leader & Developer" class="team-photo mb-4">
                    <h3 class="text-lg font-semibold">Yasin</h3>
                    <p class="text-gray-600">Leads the team and ensures our platform is responsive and visually appealing.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-white py-6">
        <p class="text-center">&copy; 2024 Blog Platform. All Rights Reserved.</p>
    </footer>

    <!-- External JavaScript -->
    <script src="scripts.js"></script>
</body>
</html>

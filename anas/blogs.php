<?php
// Start session
session_start();

// Initialize $is_admin
$is_admin = false;

// Check if the user is logged in and set $is_admin based on their role
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $is_admin = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Blogs - Blog Platform</title>
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


<!-- Main Container -->
<div class="container mx-auto px-4 py-10">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Our Latest Blogs</h1>

    <!-- Blog Grid -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Hardcoded Blog Entries -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Exploring the Mountains</h2>
            <p class="mt-4 text-gray-600">Join me as I share my experiences hiking through the breathtaking mountain ranges...</p>
            <a href="https://www.discoverwalks.com/blog/india/30-stunning-mountains-in-india-you-need-to-see/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">The Art of Cooking</h2>
            <p class="mt-4 text-gray-600">Cooking is an art! Discover the joy of creating delicious meals from scratch...</p>
            <a href="https://www.vegrecipesofindia.com/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Tech Innovations in 2024</h2>
            <p class="mt-4 text-gray-600">Explore the latest tech innovations and how they are shaping our future...</p>
            <a href="https://www.technologyreview.com/2024/01/08/1085094/10-breakthrough-technologies-2024/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Fitness Journey</h2>
            <p class="mt-4 text-gray-600">Join me on my fitness journey, where I share tips on staying fit and healthy...</p>
            <a href="https://www.schwarzenegger.com/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Traveling the World</h2>
            <p class="mt-4 text-gray-600">Travel is the only thing you buy that makes you richer. Let's explore the globe...</p>
            <a href="https://www.earthtrekkers.com/how-to-travel-around-the-world/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">The Importance of Reading</h2>
            <p class="mt-4 text-gray-600">Books are a uniquely portable magic. Discover the impact of reading...</p>
            <a href="https://www.lifehack.org/articles/lifestyle/10-benefits-reading-why-you-should-read-everyday.html" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Home Gardening Tips</h2>
            <p class="mt-4 text-gray-600">Discover the joys of home gardening and tips to get started in your backyard...</p>
            <a href="https://www.gardendesign.com/ideas/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Mindfulness and Meditation</h2>
            <p class="mt-4 text-gray-600">Learn how to incorporate mindfulness and meditation into your daily life...</p>
            <a href="https://www.mindful.org/mindfulness-how-to-do-it/" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Understanding Climate Change</h2>
            <p class="mt-4 text-gray-600">A deep dive into climate change and its effects on our planet and future generations...</p>
            <a href="https://www.wmf.org/2022watch?msclkid=76f4333694f21ae1c409543e2b07e3fe&utm_source=bing&utm_medium=cpc&utm_campaign=WMF%20-%202022%20World%20Monuments%20Watch&utm_term=challenges%20globally&utm_content=Global%20Challenges#:~:text=for%20the%20future.-,Global%20Challenges,-Climate%20change%3A%20As%20the" class="mt-6 inline-block text-blue-500 hover:text-blue-700 font-medium">Read more &rarr;</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white text-center py-4 mt-10">
    <p class="text-gray-600">© 2024 Blog Platform. All Rights Reserved.</p>
</footer>

</body>
</html>

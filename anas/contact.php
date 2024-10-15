<?php
// Establish database connection
$host = 'localhost';
$dbname = 'blog_platform';
$user = 'root';  // Use your database username
$pass = '';  // Use your database password

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert the data into the contact_messages table
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $name, $email, $message);

    if ($stmt->execute()) {
        $message_sent = true; // Set flag to true after message is sent
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Blog Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Navigation Section -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <ul class="flex space-x-6">
                <li><a href="index.php" class="text-gray-700 hover:text-blue-500 font-semibold">Home</a></li>
                <li><a href="about.html" class="text-gray-700 hover:text-blue-500 font-semibold">About</a></li>
                <li><a href="contact.php" class="text-blue-500 font-semibold">Contact</a></li>
                <li><a href="blogs.php" class="text-gray-700 hover:text-blue-500 font-semibold">Blogs</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-semibold text-gray-800 mb-6">Contact Us</h1>
        <p class="text-lg text-gray-600 mb-8">Have questions or feedback? Please fill out the form below:</p>

        <!-- Success Message -->
        <?php if ($message_sent): ?>
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Message sent successfully!</strong>
        </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form class="bg-white shadow-lg rounded-lg p-8 space-y-6 max-w-md mx-auto" action="contact.php" method="POST">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                <textarea name="message" id="message" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send Message</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <p class="text-center">&copy; 2024 Blog Platform. All Rights Reserved.</p>
    </footer>

    <!-- JavaScript to hide the success message after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>
</body>

</html>

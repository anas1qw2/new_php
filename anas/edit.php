<?php
session_start();

// Only admin can edit users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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

// Check if the ID is provided
if (!isset($_GET['id'])) {
    die("No user ID provided.");
}

$user_id = $_GET['id'];

// Handle form submission to update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $new_password = $_POST['new_password'];

    // Update username and role
    $update_sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $username, $role, $user_id);

    if ($stmt->execute()) {
        // If a new password is provided, update it
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_sql = "UPDATE users SET password = ? WHERE id = ?";
            $password_stmt = $conn->prepare($password_sql);
            $password_stmt->bind_param("si", $hashed_password, $user_id);
            $password_stmt->execute();
            $password_stmt->close();
        }
        
        echo "<script>alert('User updated successfully');</script>";
        header("Location: blogs.php"); // Redirect back to blogs page
        exit();
    } else {
        echo "<script>alert('Error updating user: " . $conn->error . "');</script>";
    }
}

// Fetch the user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Edit User</h1>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out hover:shadow-lg">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                <select id="role" name="role" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out hover:shadow-lg">
                    <option value="admin" <?php if ($user_data['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($user_data['role'] === 'user') echo 'selected'; ?>>User</option>
                </select>
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password (leave blank if not changing):</label>
                <input type="password" id="new_password" name="new_password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out hover:shadow-lg">
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-md transition duration-200 hover:shadow-lg">
                Update User
            </button>
        </form>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

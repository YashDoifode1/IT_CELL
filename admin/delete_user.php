<?php
// Include configuration and helper files
include('config.php');

// Start session
//session_start();

// // Check if user is logged in and is admin
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     // Redirect or handle unauthorized access
//     header("Location: login.php");
//     exit;
// }

// Check if ID parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID not provided.");
}

// Sanitize the ID parameter to prevent SQL injection
$user_id = intval($_GET['id']);

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to delete user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters and execute the statement
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // User deleted successfully
    echo "User deleted successfully.";
} else {
    // Error deleting user
    echo "Error deleting user: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();

// Redirect back to manage users page
header("Location: user.php");
exit;
?>

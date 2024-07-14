<?php
// Include configuration and helper files
include('config.php');

// Start session (if needed for authentication)
// session_start();

// Check if user is logged in and is admin (example)
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     // Redirect or handle unauthorized access
//     header("Location: login.php");
//     exit;
// }

// Check if ID parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Post ID not provided.");
}

// Sanitize the ID parameter to prevent SQL injection
$post_id = intval($_GET['id']);

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete comments associated with the post
$sql_delete_comments = "DELETE FROM comments WHERE post_id = ?";
$stmt_delete_comments = $conn->prepare($sql_delete_comments);
if ($stmt_delete_comments === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt_delete_comments->bind_param("i", $post_id);

if ($stmt_delete_comments->execute()) {
    // Comments deleted successfully or no comments existed
} else {
    // Error deleting comments
    echo "Error deleting comments: " . $stmt_delete_comments->error;
}

// Prepare SQL statement to delete post
$sql_delete_post = "DELETE FROM posts WHERE id = ?";
$stmt_delete_post = $conn->prepare($sql_delete_post);
if ($stmt_delete_post === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt_delete_post->bind_param("i", $post_id);

if ($stmt_delete_post->execute()) {
    // Check if any rows were affected (successful delete)
    if ($stmt_delete_post->affected_rows > 0) {
        echo "Post deleted successfully.";
    } else {
        echo "Post with ID $post_id not found.";
    }
} else {
    // Error deleting post
    echo "Error deleting post: " . $stmt_delete_post->error;
}

// Close statements and database connection
$stmt_delete_comments->close();
$stmt_delete_post->close();
$conn->close();

// Redirect back to manage posts page
header("Location: post.php");
exit;
?>

<?php
include('header.php');
include('config.php');

// Start session
//session_start();

//Check if user is logged in and is admin
// if (!isset($_SESSION['username'])!== 'admin') {
//     // Redirect or handle unauthorized access
//     header("Location: login.php");
//     exit;
// }

// Fetch counts from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$users_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$posts_count = $conn->query("SELECT COUNT(*) as count FROM posts")->fetch_assoc()['count'];
$comments_count = $conn->query("SELECT COUNT(*) as count FROM comments")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .dashboard {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .dashboard h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .dashboard .stat {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .dashboard button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .dashboard button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Admin Dashboard</h2>
        <p class="stat"><strong>Users:</strong> <?php echo $users_count; ?></p>
        <p class="stat"><strong>Posts:</strong> <?php echo $posts_count; ?></p>
        <p class="stat"><strong>Comments:</strong> <?php echo $comments_count; ?></p>
        <button onclick="location.href='user.php'">Manage Users</button>
        <button onclick="location.href='post.php'">Manage Posts</button>
        <button onclick="location.href='comment.php'">Manage Comments</button>
    </div>
</body>
</html>

<?php include('footer.html'); ?>

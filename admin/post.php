<?php
include('header.php');
include('config.php');

// Start session
//session_start();

// Check if user is logged in and is admin
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     // Redirect or handle unauthorized access
//     header("Location: login.php");
//     exit;
// }

// Fetch posts from the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, title, username FROM posts");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .container1{
            width: 900px;
            margin: 0 auto;
            padding:10px;

        }
    </style>
</head>
<body>
    
    <div class="container1">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <button class="action-button" onclick="location.href='edit_post.php?id=<?php echo $row['id']; ?>'">Edit</button>
                        <button class="action-button delete-button" onclick="location.href='delete_post.php?id=<?php echo $row['id']; ?>'">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button><a href="index.php">Back</a></button></div>
</body>
</html>

<?php include('footer.html'); ?>

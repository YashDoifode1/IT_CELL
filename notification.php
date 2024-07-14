<?php
include('includes/header.php');
include('includes/config.php');

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get notification ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Fetch notification details
    $sql = "SELECT title, description, created_at FROM notification WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($title, $description, $created_at);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid notification ID.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        .container5 {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 10px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        .notification-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .notification-box h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .notification-box p {
            font-size: 16px;
        }
        .notification-box .created-at {
            font-size: 14px;
            color: #555;
        }
        .notification-box a {
            text-decoration: none;
            color: #007BFF;
        }
        .notification-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container5">
    <div class="notification-box">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
        <p class="created-at">Created on: <?php echo htmlspecialchars($created_at); ?></p>
        <p><a href="index.php">Back to Notifications</a></p>
    </div>
    </div>
</body>
</html>

<?php
include('includes/footer.html');
?>

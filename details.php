<?php
include('includes/header.php');
include('includes/config.php');

// Start session
//session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php");
    exit;
}

// Retrieve the post ID from the URL
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch post details from the database
$stmt = $conn->prepare("SELECT username, title, Descriptions, photo, category, created_at FROM posts WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($username, $title, $descriptions, $photo, $category, $date);
$stmt->fetch();
$stmt->close();

// Fetch comments from the database
$stmt = $conn->prepare("SELECT username, comment, created_at FROM comments WHERE post_id = ? ORDER BY created_at DESC");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($comment_username, $comment_text, $comment_created_at);
$comments = [];
while ($stmt->fetch()) {
    $comments[] = [
        'username' => $comment_username,
        'comment' => $comment_text,
        'created_at' => $comment_created_at
    ];
}
$stmt->close();

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $username = $_SESSION['username'];

    // Insert comment into comments table
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO comments (post_id, username, comment, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iss", $post_id, $username, $comment);

    if ($stmt->execute()) {
        // Comment inserted successfully
        header("Location: details.php?id=" . $post_id); // Redirect to avoid form resubmission
        exit;
    } else {
        // Error inserting comment
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details</title>
    <style>
        .post-details {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .post-details h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .post-details p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .post-details img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        .separator{
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .comments {
            margin-top: 20px;
           
        }

        .comment {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 10px;
        }

        .comment p {
            margin: 5px 0;
        }

        .form-group {
            margin-bottom: 10px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="post-details">
        <p><strong>Posted by:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($descriptions)); ?></p>
        <?php if (!empty($photo)): ?>
            <img src="<?php echo htmlspecialchars($photo); ?>" alt="Post Image">
        <?php endif; ?>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>

        
    </div>
    <div class="separator">
    <h3>Comments</h3>
        <div class="comments">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> on <?php echo htmlspecialchars($comment['created_at']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Leave a Comment</h3>
        <form action="details.php?id=<?php echo $post_id; ?>" method="POST">
            <div class="form-group">
                <textarea name="comment" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
        </div>
</body>
</html>

<?php include('includes/footer.html'); ?>

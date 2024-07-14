<?php
include('includes/header.php');
include('includes/config.php');

// Start session


// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php");
    exit;
}

// Process form data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $username = $_SESSION['username'];

    // File upload handling
    $target_dir = "uploads/"; // Directory where uploads will be stored
    $target_file = $target_dir . basename($_FILES["photo"]["name"]); // Path of the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File type

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["photo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to move uploaded file to target directory
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["photo"]["name"])). " has been uploaded.";

            // Insert post into posts table with photo path
            $stmt = $conn->prepare("INSERT INTO posts (username, Title, descriptions, photo, category) VALUES (?, ?, ?, ?, ?)");
            
            // Check if prepare() succeeded
            if ($stmt === false) {
                die("Prepare statement failed: " . $conn->error);
            }
            
            // Bind parameters
            $stmt->bind_param("sssss", $username, $title, $description, $target_file, $category);

            if ($stmt->execute()) {
                // Post inserted successfully
                header("Location: index.php"); // Redirect to index or another page
                exit;
            } else {
                // Error inserting post
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="includes/post.css">
</head>
<body>
    <div class="post">
        <h2>Create a Post</h2>
        <form action="post.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Image:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="Education">Education</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Sports">Sports</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Upload Post">
            </div>
        </form>
    </div>
</body>
</html>

<?php include('includes/footer.html'); ?>

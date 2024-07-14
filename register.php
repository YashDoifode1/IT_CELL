<?php
include('includes/header.php');
include('includes/config.php');
?>

<?php
// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = ($_POST['password']);
   
    // Image upload handling
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_uploaded = true;
    } else {
        $image_uploaded = false;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, img) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ssss", $username, $email, $password, $image);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: login.php');
    } else {
        echo "<div class='error'>Error: " . htmlspecialchars($stmt->error) . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <div class="container2">
        <h2>Register</h2>
        <form method="POST" action="register.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <input type="submit" value="Register"><br><br>
            
            <button><a href="login.php">Login here</a></button><br><br>
        </form>
    </div>
</body>
</html>

<?php include('includes/footer.html'); ?>

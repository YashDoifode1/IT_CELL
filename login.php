<?php
include('includes/header.php');
include('includes/config.php');
//session_start(); // Ensure session is started

?>
<?php
// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password";
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
    <title>UniBlend</title>
    <link rel="stylesheet" href="includes/style3.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Login"><br><br>
            <button><a href="register.php">Register</a></button>
        </form>
        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
    </div>
</body>
</html>

<?php include('includes/footer.html'); ?>

<?php require "includes/header.php"; ?>
<?php require "includes/config.php"; ?>
<?php 
    if (!isset($_SESSION['username'])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit(); // Stop further execution
}

?>
<?php


// Assuming you have a database connection established already
 // Include your database connection script

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch user information
    $userQuery = "SELECT * FROM users WHERE username = '$username'";
    $userResult = $conn->query($userQuery);
    $userData = $userResult->fetch_assoc();

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page </title>
    <!-- Add your CSS styles here -->
    <style>
        /* Sample CSS for demonstration */
        .user-info-container {
            border: 1px solid #ccc;
            margin:20px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .user-info-container h2 {
            margin-top: 0;
        }
        .user-info-container p {
            margin-bottom: 5px;
        }
        .settings-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .settings-button:hover {
            background-color: #0056b3;
        }
        .post {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        span{
            color:red;
        }
        #green {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <br>
    <h1>Welcome to your Profile, <span><?php echo $userData['username']; ?><span></h1><br>

    <!-- Display user information -->
    <center><div class="user-info-container">
        <h2>User Information:</h2><br>
       <?php if (!empty($userData['profile_image'])) {
                echo '<img src="' . $userData['profile_image'] . '" alt="Profile Image">';
            } ?>
        <p>Username: <span id='green'><?php echo $userData['username']; ?></span></p>
        <p>Email:<span id='green'> <?php echo $userData['email']; ?></span></p>
        <!--<p>Bio:<span id='green'> <?php echo $userData['bio']; ?></span></p>
        <p>Interest In :<span id='green'> <?php// echo $userData['category']; ?></span></p>-->
        <p>Phone no : <span id='green'> Hidden For Security Resaons(-_-)  </span></p><br>
        <!-- Add more user information fields as needed -->
        <a href="set.php" class="settings-button">Settings</a><br>
        <p>
    </div></center>
    <!-- Add more user information fields as needed -->

    <!-- Display user's posts -->
    <h2>Your Posts:</h2>
    <?php
     //Fetch user's posts
    $postQuery = "SELECT * FROM posts WHERE username = '$username'";
    $postResult = $conn->query($postQuery);
    if ($postResult->num_rows > 0) {
        while ($post = $postResult->fetch_assoc()) {
            echo '<center><div class="post">';
            echo '<img src="' . $post['photo'] . '" alt="Profile Image">';
            echo '<h3>' . $post['Title'] . '</h3>';
            echo '<p>' . $post['Descriptions'] . '</p>';
             //Add more post details as needed
            //Extra Code Here 
            if(isset($_SESSION['username']) AND $_SESSION['username']== $post['username']):
                echo '<button class="btn-delete" value='. $post["id"] .' style="padding: 10px;background-color: red; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Delete</button>';
            endif;

            //Ends Here
            echo '</div></center>';
        }
    } else {
        echo '<script>alert("No posts found")</script>';
    }
    ?>

    <!-- Add more HTML content as needed -->

</body>
</html>


<?php
// Close database connection
$conn->close();
require "includes/footer.html";
?>



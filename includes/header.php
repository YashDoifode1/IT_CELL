<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniBlend</title>
    <link rel="stylesheet" href="includes/style2.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">IT CELL</a>
            <div class="navbar-links">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="index.php">Home</a>
                    <a href="post.php">Post A Topic </a>

                    <div class="dropdown">
                        <button class="dropbtn"><?php echo $_SESSION['username']; ?></button>
                        <div class="dropdown-content">
                            <a href="profile.php">Profile</a>
                            <a href="set.php">Settings</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                    
                    

                    
                   
                   
                <?php else: ?>
                   
                    
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>

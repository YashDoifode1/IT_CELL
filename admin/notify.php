<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify Page</title>
    <style>
        /* Basic CSS styles */
        
        .form-container {
            margin: 20px;
            
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .notifications {
            margin-top: 40px;
            max-width: 600px;
        }
        .notification {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .notification h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <h1>Submit a Notification</h1>
    <div class="form-container">
        <form action="notify.php" method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

    <!-- Notifications Section -->
    <!-- <div class="notifications">
        <h2>Notifications</h2> -->
        <?php
        // Include configuration and helper files
        include('config.php');

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $description = $_POST['description'];

            // Connect to the database
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert the notification into the database
            $stmt = $conn->prepare("INSERT INTO notification (title, description) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ss", $title, $description);

            if ($stmt->execute()) {
                // Redirect to avoid form resubmission
                header("Location: notify.php");
                exit;
            } else {
                // Error inserting notification
                echo "Error: " . $stmt->error;
            }

            // Close statement and database connection
            $stmt->close();
            $conn->close();
        }

        // Connect to the database
        // $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        // // Fetch notifications from the database
        // $sql = "SELECT title, description, created_at FROM notifications ORDER BY created_at DESC";
        // $result = $conn->query($sql);

        // if ($result->num_rows > 0) {
        //     // Output data of each row
        //     while($row = $result->fetch_assoc()) {
        //         echo '<div class="notification">';
        //         echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        //         echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        //         echo '<p><em>' . htmlspecialchars($row['created_at']) . '</em></p>';
        //         echo '</div>';
        //     }
        // } else {
        //     echo "<p>No notifications found.</p>";
        // }

        // // Close database connection
        // $conn->close();
        ?>
    </div>
</body>
</html>

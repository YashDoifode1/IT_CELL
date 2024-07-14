<?php include('includes/header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <style>
        /* Basic CSS styles */
            /* body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
            } */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .view-more-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Remove underline from link */
        }
        .view-more-btn:hover {
            background-color: #0056b3;
        }
        .notifications {
           
           position: fixed;
           right: 10px;
           top: 60px;
           width: 280px;
           max-height: 90vh;
           overflow-y: auto;
           background-color: #f9f9f9;
           padding: 10px;
           border: 1px solid #ccc;
           border-radius: 5px;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       }
        .notification {
            margin-bottom: 10px;
        }
        .section-heading {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container6 {
           padding: 20px;
            margin-right: 340px; /* Adjust to provide space for fixed notifications */
        }
        .club-info {
            margin-bottom: 40px;
        }
        .club-info h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .club-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container6">
        <div class="club-info">
            <h2>About IT Cell</h2>
            <p>Welcome to the IT Cell, the driving force behind all IT-related events at our college. We are dedicated to fostering a culture of innovation and technological advancement through various events, workshops, and seminars. Join us to enhance your skills, network with industry professionals, and be a part of a thriving community passionate about technology.</p>
        </div>

        <h1>Posts</h1>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Username</th>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include configuration and helper files
                include('includes/config.php');

                // Connect to the database
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch posts from the database
                $sql = "SELECT id, title, username, category, created_at FROM posts ORDER BY created_at DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                        echo '<td><a href="details.php?id=' . htmlspecialchars($row['id']) . '" class="view-more-btn">View More</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No posts found.</td></tr>';
                }

                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Notifications Section -->
    <div class="notifications">
        <center><h2 class="section-heading">Notifications</h2></center>
        <ul>
        <?php
        // Database connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
        $sql = "SELECT id, title FROM notification";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="notification.php?id=' . $row["id"] . '">' . htmlspecialchars($row["title"]) . '</a></li>';
            }
        } else {
            echo "No notifications found.";
        }
        $conn->close();
        ?>
        </ul>
    </div>
        <!-- Add more notifications dynamically or fetch from a database -->
    </div>
</body>
</html>
<?php include('includes/footer.html');?>

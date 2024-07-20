# IT CELL CLUB MANAGEMENT BLOG
A web application for managing and displaying posts, comments, and notifications related to IT events conducted by the IT Cell of a college.

Features
User Authentication: Users can log in to access and manage posts.
Post Management: View, add, edit, and delete posts.
Comment Management: View, add, edit, and delete comments on posts.
Notifications: Display notifications about IT-related events.
Admin Dashboard: Admin can monitor and manage users, posts, and comments.
Tech Stack
Frontend: HTML, CSS
Backend: PHP
Database: MySQL
Installation
Clone the repository:



git clone https://github.com/yourusername/college-forum.git
cd college-forum
Set up the database:
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
https://github.com/user-attachments/assets/535fd8ba-d0a8-4839-8fc2-2f7216f03fda
----------------------------------------------------------------------------------------------------------------------------------------------------------
Import the SQL file to create the necessary tables.
sql

CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` varchar(20) NOT NULL DEFAULT 'user',
    PRIMARY KEY (`id`)
);

CREATE TABLE `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `photo` varchar(255),
    `category` varchar(50) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `comments` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `comment` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `fk_post_id` (`post_id`),
    CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
);

CREATE TABLE `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `message` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);
Configure the database connection:

Update config.php with your database credentials.
php

define('DB_HOST', 'your_db_host');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');
Start the server:




License
This project is licensed under the MIT License. See the LICENSE file for details.

Acknowledgements
Special thanks to the IT Cell for their dedication to conducting IT-related events and fostering a culture of innovation and technology at our college.

 

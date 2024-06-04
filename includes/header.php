<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movie Library</title>
    <link rel="stylesheet" href="../style.css"> <!-- Add your CSS file here -->
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Home</a>
            <a href="../movies/my_lists.php">My Lists</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="../auth/login.php">Login</a>
                <a href="../auth/register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

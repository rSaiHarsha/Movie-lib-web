<?php
require '../db/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $userId = $_SESSION['user_id'];
    $name = $_POST['name'];
    $isPublic = isset($_POST['is_public']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO lists (user_id, name, is_public) VALUES (?, ?, ?)");
    if ($stmt->execute([$userId, $name, $isPublic])) {
        header('Location: my_lists.php');
    } else {
        echo "Error: Could not create list.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        header nav {
            display: flex;
            justify-content: center;
        }

        header nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
        }

        header nav a:hover {
            background-color: #555;
        }

        footer {
            position:relative;
            top: 100vh;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 5% 5%;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="checkbox"] {
            margin: 5px 0 15px;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Search Movies</a>
            <a href="my_lists.php">My Lists</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="../auth/login.php">Login</a>
            <?php else: ?>
                <a href="../auth/logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h1>Create List</h1>
        <form method="post" action="create_list.php">
            <label for="name">List Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="is_public">Public:</label>
            <input type="checkbox" id="is_public" name="is_public">
            <button type="submit">Create</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Movie Library</p>
    </footer>
</body>
</html>

<?php
require '../db/db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check for empty inputs
    if (empty($username) || empty($password)) {
        echo "Error: Both fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['id'];
                header('Location: ../index.php');
                exit;
            } else {
                echo "Error: Invalid username or password.";
            }
        } else {
            echo "Error: Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        form {
            background-color: #fff;
            padding: 5% 5%;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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
            width: 100%;
        }

        button:hover {
            background-color: #555;
        }
        
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Home</a>
            <a href="../movies/search.php">Search Movies</a>
            <a href="../my_lists.php">My Lists</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php else: ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <form method="post" action="login.php">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Movie Library</p>
    </footer>
</body>
</html>

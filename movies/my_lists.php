<?php
require '../db/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM lists WHERE user_id = ?");
$stmt->execute([$userId]);
$lists = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Lists</title>
    <link rel="stylesheet" href="../assets/my_list.css">
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Search Movies</a>
            <a href="my_lists.php">My Lists</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="../auth/login.php">Login</a>
            <?php else: ?>
                <a href="../auth/logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h1>My Movie Lists</h1>
        <ul>
            <?php foreach ($lists as $list): ?>
                <li>
                    <?php echo htmlspecialchars($list['name']); ?> (<?php echo $list['is_public'] ? 'Public' : 'Private'; ?>)
                    <form action="delete_list.php" method="post">
                        <input type="hidden" name="list_id" value="<?php echo $list['id']; ?>">
                        <input type="submit" value="Delete" class="delete-btn">
                    </form>
                    <ul>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM list_movies WHERE list_id = ?");
                        $stmt->execute([$list['id']]);
                        $movies = $stmt->fetchAll();
                        foreach ($movies as $movie):
                        ?>
                            <li>
                                <img src="<?php echo htmlspecialchars($movie['poster']); ?>" alt="Poster" style="width: 100px; height: auto;">
                                <?php echo htmlspecialchars($movie['title']); ?>
        
                                <form action="delete_movie.php" method="post">
                                    <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                                    <input type="submit" value="Delete" class="delete-btn">
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2024 Movie Library</p>
    </footer>
</body>
</html>

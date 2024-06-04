<!DOCTYPE html>
<?php 
require './db/db_config.php';
session_start();
?>
<html>
<head>
    <title>Search Movies</title>
    <link rel="stylesheet" href="./assets/index.css">

</head>
<body>
    <header>
        <nav>
        <a href="./movies/my_lists.php">My Lists</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="./auth/login.php">login</a>
                
            <?php else: ?>
                <a href="./movies/create_list.php"> Create List</a>
                <a href="./auth/logout.php">Logout</a>    
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h1>Search Movies</h1>
        <form method="get" action="./movies/search.php">
            <input type="text" name="query" placeholder = "(eg. Star Wars..)" required>
            <button type="submit">Search</button>
        </form>
        <h3>Public Playlists</h3>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM lists WHERE is_public = 1");
        $stmt->execute();
        $publicLists = $stmt->fetchAll();
        ?>
        <ul class = "movie-slider">
            <?php foreach ($publicLists as $list): ?>
                <li>
                    <?php echo htmlspecialchars($list['name']); ?>
                    <ul>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM list_movies WHERE list_id = ?");
                        $stmt->execute([$list['id']]);
                        $movies = $stmt->fetchAll();
                        foreach ($movies as $movie):
                        ?>
                            <li>
                                <img src="<?php echo htmlspecialchars($movie['poster']); ?>" alt="Movie Poster" class="movie-poster">
                                <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>© 2024 Movie Library</p>
    </footer>
</body>
</html>

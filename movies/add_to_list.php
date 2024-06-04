<?php
require '../db/db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$title = '';
$poster = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id'])) {
    $movieId = $_POST['movie_id'];
    $apiKey = '6a4ebfb'; // Replace with your OMDB API key
    $detailsUrl = "http://www.omdbapi.com/?i={$movieId}&apikey=$apiKey";
    $detailsResponse = file_get_contents($detailsUrl);

    if ($detailsResponse === FALSE) {
        echo "Error: Unable to connect to OMDB API.";
        exit;
    }

    $movieDetails = json_decode($detailsResponse, true);

    if ($movieDetails && $movieDetails['Response'] == 'True') {
        $title = $movieDetails['Title'];
        $poster = $movieDetails['Poster'];
    } else {
        echo "Error: Movie details not found.";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM lists WHERE user_id = ?");
    $stmt->execute([$userId]);
    $lists = $stmt->fetchAll();

    if ($lists === FALSE) {
        echo "Error: Unable to fetch lists from database.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add to List</title>
    <link rel="stylesheet" href="../assets/add_to_list.css">   
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
        <div class="add-to-list-page">
            <h2>Add <?php echo htmlspecialchars($title); ?> to a List</h2>
            <form method="post" action="add_to_list.php">
                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movieId); ?>">
                <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <input type="hidden" name="poster" value="<?php echo htmlspecialchars($poster); ?>">
                <select name="list_id" required>
                    <?php foreach ($lists as $list): ?>
                        <option value="<?php echo htmlspecialchars($list['id']); ?>"><?php echo htmlspecialchars($list['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Add</button>
            </form>
        </div>
    </main>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id']) && isset($_POST['list_id'])) {
    $movieId = $_POST['movie_id'];
    $title = $_POST['title'];
    $listId = $_POST['list_id'];
    $poster = $_POST['poster'];

    $stmt = $pdo->prepare("INSERT INTO list_movies (list_id, movie_id, title, poster) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$listId, $movieId, $title, $poster])) {
        header('Location: my_lists.php');
        exit; // Always exit after header redirect
    } else {
        echo "Error: Could not add movie to list.";
    }
}
?>

    <footer>
        <!-- Include your footer content here -->
    </footer>
</body>
</html>

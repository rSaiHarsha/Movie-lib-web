<?php
require '../db/db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
    $query = urlencode($_GET['query']);
    $apiKey = '6a4ebfb'; // Replace with your OMDB API key
    $url = "http://www.omdbapi.com/?s=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $movies = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
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
            position: relative;
            top:100vh;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: flex;
            align-items: flex-start;
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        img {
            margin-right: 20px;
            max-width: 150px;
            border-radius: 5px;
        }

        h3 {
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
            text-align: left;
        }

        .movie-details {
            text-align: left;
        }
      
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Search Movies</a>
            <a href="./my_lists.php">My Lists</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="../auth/login.php">Login</a>
            <?php else: ?>
                <a href="../auth/logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <div style = '  
 
        form {
            margin: 20px auto;
            max-width: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            flex-grow: 1;
            margin-right: 10px;
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

        h1 {
            margin-bottom: 20px;
        }'>
    <main style=" padding: 20px;
            text-align: center;" >
        <h1>Search Movies</h1>
        <form method="get" action="search.php">
            <input style = " padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            flex-grow: 1;
            margin-right: 10px;" type="text" name="query" placholder = "(eg. Star wars)" required>
            <button type="submit">Search</button>
        </form>
    </main>
    </div>
    <main>
        <h1>Search Results</h1>
        <?php if (isset($movies) && $movies['Response'] == 'True'): ?>
            <ul>
                <?php foreach ($movies['Search'] as $movie): 
                    $detailsUrl = "http://www.omdbapi.com/?i={$movie['imdbID']}&apikey=$apiKey";
                    $detailsResponse = file_get_contents($detailsUrl);
                    $movieDetails = json_decode($detailsResponse, true);
                ?>
                    <li>
                        <div>
                            <img src="<?php echo $movieDetails['Poster']; ?>" alt="<?php echo $movieDetails['Title']; ?>">
                        </div>
                        <div class="movie-details">
                            <h3><?php echo $movieDetails['Title']; ?> (<?php echo $movieDetails['Year']; ?>)</h3>
                            <p><strong>Released:</strong> <?php echo $movieDetails['Released']; ?></p>
                            <p><strong>Country:</strong> <?php echo $movieDetails['Country']; ?></p>
                            <p><strong>Genre:</strong> <?php echo $movieDetails['Genre']; ?></p>
                            <p><strong>Duration:</strong> <?php echo $movieDetails['Runtime']; ?></p>
                            <p><strong>Actors:</strong> <?php echo $movieDetails['Actors']; ?></p>
                            <p><strong>Writer:</strong> <?php echo $movieDetails['Writer']; ?></p>
                            <p><strong>Language:</strong> <?php echo $movieDetails['Language']; ?></p>
                            <p><strong>IMDB Rating:</strong> <?php echo $movieDetails['imdbRating']; ?></p>
                            <p><strong>Plot:</strong> <?php echo $movieDetails['Plot']; ?></p>
                         
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form method="post" action="add_to_list.php">
                                    <input type="hidden" name="movie_id" value="<?php echo $movieDetails['imdbID']; ?>">
                                    <input type="hidden" name="title" value="<?php echo urlencode($movieDetails['Title']); ?>">
                                    <button type="submit">Add to List</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (isset($movies)): ?>
            <p>No results found.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Movie Library by Sai Harsha</p>
    </footer>
</body>
</html>

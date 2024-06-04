<?php
require '../db/db_config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['movie_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$movieId = $_POST['movie_id'];
$stmt = $pdo->prepare("DELETE FROM list_movies WHERE movie_id = ? AND list_id IN (SELECT id FROM lists WHERE user_id = ?)");
$stmt->execute([$movieId, $_SESSION['user_id']]);

header('Location: my_lists.php');
exit;
?>

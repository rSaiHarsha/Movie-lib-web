<?php
require '../db/db_config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['list_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$listId = $_POST['list_id'];


$stmt = $pdo->prepare("DELETE FROM list_movies WHERE list_id = ?");
$stmt->execute([$listId]);


$stmt = $pdo->prepare("DELETE FROM lists WHERE id = ? AND user_id = ?");
$stmt->execute([$listId, $_SESSION['user_id']]);

header('Location: my_lists.php');
exit;
?>

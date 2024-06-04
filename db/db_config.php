<?php
$host = 'sql308.infinityfree.com';
$db = 'if0_36671384_movie_library';
$user = 'if0_36671384';
$pass = 'tNCeBuO8rTBLY6';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>

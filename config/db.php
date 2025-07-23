<?php
// config/db.php

$host = 'dpg-d20girumcj7s73b5gno0-a.oregon-postgres.render.com'; // Reemplaza con el host real que te da Render
$port = '5432';
$db   = 'siswebeva';
$user = 'siswebeva_user';
$pass = 'br2muyJBP6PRy8VETcmGfQrkS2YdTk88';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

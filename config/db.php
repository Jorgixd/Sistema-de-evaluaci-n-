<?php
// config/db.php

$host = 'dpg-d20edt7gi27c73ch5sbg-a'; // Reemplaza con el host real que te da Render
$port = '5432';
$db   = 'cevaluacion';
$user = 'root';
$pass = '2mapSsNT7OsiBwBnXousZIZVsEvoYl3H';

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

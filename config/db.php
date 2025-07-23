<?php
$host = 'localhost';
$dbname = 'Cevaluacion';
$user = 'postgres';
$password = '123456';

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

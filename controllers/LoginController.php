<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $stmt = $pdo->prepare("SELECT * FROM Estudiantes WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['contrasena'] === $contrasena) {
        // Guardar datos del estudiante en sesión
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['id_estudiante'] = $user['id_estudiante'];
        $_SESSION['id_carrera'] = $user['id_carrera'];

        // Obtener nombre de la carrera
        $stmtCarrera = $pdo->prepare("SELECT nombre_carrera FROM Carreras WHERE id_carrera = :id");
        $stmtCarrera->execute(['id' => $user['id_carrera']]);
        $carrera = $stmtCarrera->fetch(PDO::FETCH_ASSOC);

        $_SESSION['nombre_carrera'] = $carrera['nombre_carrera'];

        // 🚨 CAMBIO AQUÍ:
        header('Location: ../views/dashboard.php?login=success'); // Puedes cambiar evaluar.php por la vista que desees
        exit();
    } else {
        header("Location: ../views/login.php?error=Credenciales inválidas");
        exit();
    }
}

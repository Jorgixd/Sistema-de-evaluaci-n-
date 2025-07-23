<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Validar sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.php");
    exit;
}

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/dashboard.php");
    exit;
}

$id_docente = $_POST['id_docente'];
$calificacion = $_POST['calificacion'];
$descripcion = $_POST['descripcion'] ?? null;
$id_estudiante = $_SESSION['id_estudiante'];
$id_carrera = $_SESSION['id_carrera'];

// Recoger respuestas p1 a p10
$respuestas = [];
for ($i = 1; $i <= 10; $i++) {
    $respuestas["p$i"] = $_POST["p$i"] ?? null;
}

try {
    // Verificar si ya evaluó al mismo docente
    $check = $pdo->prepare("SELECT 1 FROM Evaluaciones WHERE id_estudiante = :estudiante AND id_docente = :docente");
    $check->execute([
        'estudiante' => $id_estudiante,
        'docente' => $id_docente
    ]);

    if ($check->fetch()) {
        header("Location: ../views/evaluar.php?error=Ya+has+evaluado+a+este+docente.");
        exit;
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // 1. Insertar en Evaluaciones
    $stmtEval = $pdo->prepare("INSERT INTO Evaluaciones (id_docente, id_estudiante, id_carrera, calificacion, descripcion)
                               VALUES (:docente, :estudiante, :carrera, :calificacion, :descripcion)");
    $stmtEval->execute([
        'docente' => $id_docente,
        'estudiante' => $id_estudiante,
        'carrera' => $id_carrera,
        'calificacion' => $calificacion,
        'descripcion' => $descripcion
    ]);

    // 2. Obtener ID insertado
    $id_evaluacion = $pdo->lastInsertId();

    // 3. Insertar respuestas
    $stmtRes = $pdo->prepare("INSERT INTO RespuestasEvaluacion (
        id_evaluacion, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10
    ) VALUES (
        :id_evaluacion, :p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10
    )");

    $stmtRes->execute(array_merge(
        ['id_evaluacion' => $id_evaluacion],
        $respuestas
    ));

    // Confirmar transacción
    $pdo->commit();

    // Redirigir con éxito
    header("Location: ../views/dashboard.php?success=Evaluación+registrada+correctamente");
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    // Puedes activar esta línea para debug si estás en desarrollo:
    // die("Error: " . $e->getMessage());
    header("Location: ../views/evaluar.php?error=Error+al+registrar+la+evaluación");
    exit;
}

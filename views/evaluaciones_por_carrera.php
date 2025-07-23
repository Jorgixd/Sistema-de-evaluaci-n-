<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
require_once '../config/db.php';

$id_carrera = $_SESSION['id_carrera'] ?? null;

if (!$id_carrera) {
    echo "<p>Error: No se encontró el ID de carrera en la sesión.</p>";
    exit;
}

$query = "SELECT 
            E.id_evaluacion,
            D.nombre AS nombre_docente,
            D.apellido AS apellido_docente,
            C.nombre_carrera,
            Est.nombre AS nombre_estudiante,
            Est.apellido AS apellido_estudiante,
            E.fecha_evaluacion,
            E.calificacion,
            E.descripcion,
            R.p1, R.p2, R.p3, R.p4, R.p5,
            R.p6, R.p7, R.p8, R.p9, R.p10
          FROM Evaluaciones E
          JOIN Docentes D ON E.id_docente = D.id_docente
          JOIN Carreras C ON E.id_carrera = C.id_carrera
          JOIN Estudiantes Est ON E.id_estudiante = Est.id_estudiante
          LEFT JOIN RespuestasEvaluacion R ON R.id_evaluacion = E.id_evaluacion
          WHERE E.id_carrera = :id_carrera
          ORDER BY E.fecha_evaluacion DESC";

$stmt = $pdo->prepare($query);
$stmt->execute(['id_carrera' => $id_carrera]);
$evaluaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Evaluaciones por Carrera</title>
    <link rel="stylesheet" href="../assets/estilos.css">
    <style>

    </style>
</head>

<body>

    <?php
    require_once '../includes/header.php';
    ?>


    <h3>📚 Evaluaciones de Mi Carrera (<?php echo $_SESSION['nombre_carrera']; ?>)</h3>

    <?php if (count($evaluaciones) === 0): ?>
        <p style="color:red;">No hay evaluaciones registradas aún en tu carrera (ID carrera: <?= $id_carrera ?>).</p>
    <?php else: ?>
        <?php foreach ($evaluaciones as $eval): ?>
            <div class="evaluacion-box">
                <h4>👨‍🏫 Docente: <?= $eval['nombre_docente'] . " " . $eval['apellido_docente'] ?></h4>
                <p><strong>👩‍🎓 Estudiante:</strong> <?= $eval['nombre_estudiante'] . " " . $eval['apellido_estudiante'] ?></p>
                <p><strong>🏫 Carrera:</strong> <?= $eval['nombre_carrera'] ?></p>
                <p><strong>🗓 Fecha:</strong> <?= date("d/m/Y H:i", strtotime($eval['fecha_evaluacion'])) ?></p>
                <p><strong>⭐ Calificación global:</strong> <?= $eval['calificacion'] ?></p>

                <?php if (!empty($eval['descripcion'])): ?>
                    <p><strong>💬 Comentario:</strong> <?= htmlspecialchars($eval['descripcion']) ?></p>
                <?php endif; ?>

                <?php if ($eval['p1'] !== null): ?>
                    <ul class="lista-respuestas">
                        <li><strong>A1.</strong> <?= $eval['p1'] ?></li>
                        <li><strong>A2.</strong> <?= $eval['p2'] ?></li>
                        <li><strong>B1.</strong> <?= $eval['p3'] ?></li>
                        <li><strong>B2.</strong> <?= $eval['p4'] ?></li>
                        <li><strong>C1.</strong> <?= $eval['p5'] ?></li>
                        <li><strong>D1.</strong> <?= $eval['p6'] ?></li>
                        <li><strong>E1.</strong> <?= $eval['p7'] ?></li>
                        <li><strong>F1.</strong> <?= $eval['p8'] ?></li>
                        <li><strong>G1.</strong> <?= $eval['p9'] ?></li>
                        <li><strong>H1.</strong> <?= $eval['p10'] ?></li>
                    </ul>
                <?php else: ?>
                    <p><em>No se registraron respuestas para esta evaluación.</em></p>
                <?php endif; ?>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>
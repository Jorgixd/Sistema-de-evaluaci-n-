<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
require_once '../config/db.php';

$id_estudiante = $_SESSION['id_estudiante'];

// Consulta de evaluaciones del estudiante con JOIN a respuestas
$query = "SELECT 
            E.id_evaluacion,
            D.nombre AS nombre_docente,
            D.apellido AS apellido_docente,
            E.fecha_evaluacion,
            E.calificacion,
            E.descripcion,
            R.p1, R.p2, R.p3, R.p4, R.p5,
            R.p6, R.p7, R.p8, R.p9, R.p10
          FROM Evaluaciones E
          INNER JOIN Docentes D ON E.id_docente = D.id_docente
          INNER JOIN RespuestasEvaluacion R ON R.id_evaluacion = E.id_evaluacion
          WHERE E.id_estudiante = :id_estudiante
          ORDER BY E.fecha_evaluacion DESC";

$stmt = $pdo->prepare($query);
$stmt->execute(['id_estudiante' => $id_estudiante]);
$evaluaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Evaluaciones a Docentes</title>
    <link rel="stylesheet" href="../assets/estilos.css">
    <style>

    </style>
</head>

<body>

    <?php
    require_once '../includes/header.php';
    ?>


    <div class="contenedor-principal">
        <h3>📋 Mis Evaluaciones a Docentes</h3>

        <?php if (count($evaluaciones) === 0): ?>
            <p>No has realizado ninguna evaluación aún.</p>
        <?php else: ?>
            <?php foreach ($evaluaciones as $eval): ?>
                <div class="evaluacion-box">
                    <h4>👨‍🏫 Docente: <?php echo $eval['nombre_docente'] . " " . $eval['apellido_docente']; ?></h4>
                    <p><strong>🗓 Fecha:</strong> <?php echo date("d/m/Y H:i", strtotime($eval['fecha_evaluacion'])); ?></p>
                    <p><strong>⭐ Calificación global:</strong> <?php echo $eval['calificacion']; ?></p>

                    <?php if (!empty($eval['descripcion'])): ?>
                        <p><strong>💬 Comentario:</strong> <?php echo htmlspecialchars($eval['descripcion']); ?></p>
                    <?php endif; ?>

                    <ul class="lista-respuestas">
                        <li><strong>A1.</strong> <?php echo $eval['p1']; ?></li>
                        <li><strong>A2.</strong> <?php echo $eval['p2']; ?></li>
                        <li><strong>B1.</strong> <?php echo $eval['p3']; ?></li>
                        <li><strong>B2.</strong> <?php echo $eval['p4']; ?></li>
                        <li><strong>C1.</strong> <?php echo $eval['p5']; ?></li>
                        <li><strong>D1.</strong> <?php echo $eval['p6']; ?></li>
                        <li><strong>E1.</strong> <?php echo $eval['p7']; ?></li>
                        <li><strong>F1.</strong> <?php echo $eval['p8']; ?></li>
                        <li><strong>G1.</strong> <?php echo $eval['p9']; ?></li>
                        <li><strong>H1.</strong> <?php echo $eval['p10']; ?></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>

</html>
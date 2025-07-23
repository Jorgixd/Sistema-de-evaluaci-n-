<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario'])) {
    echo "<p>No autorizado.</p>";
    exit;
}

$filtro = $_GET['busqueda'] ?? '';

$where = "WHERE 1=1";
$params = [];

if ($filtro !== '') {
    $where .= " AND (
        D.nombre ILIKE :filtro OR D.apellido ILIKE :filtro OR 
        Est.nombre ILIKE :filtro OR Est.apellido ILIKE :filtro OR 
        C.nombre_carrera ILIKE :filtro
    )";
    $params['filtro'] = "%$filtro%";
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
          JOIN RespuestasEvaluacion R ON R.id_evaluacion = E.id_evaluacion
          $where
          ORDER BY E.fecha_evaluacion DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$evaluaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Evaluaciones Generales</title>
    <link rel="stylesheet" href="../assets/estilos.css">

    </style>
</head>

<body>


    <?php
    require_once '../includes/header.php';
    ?>


    <h2>🏫 Evaluaciones Generales del ISTT</h2>

    <form>
        <input type="text" id="buscador" name="busqueda" placeholder="Buscar docente, estudiante o carrera" value="<?= htmlspecialchars($filtro) ?>">
        <button type="submit">Filtrar</button>
        <button type="button" onclick="document.getElementById('buscador').value=''; document.querySelectorAll('.filtro-evaluacion').forEach(el => el.style.display = 'block');">Limpiar</button>
    </form>

    <?php if (count($evaluaciones) === 0): ?>
        <p>No hay evaluaciones registradas.</p>
    <?php else: ?>
        <?php foreach ($evaluaciones as $eval): ?>
            <div class="evaluacion-box filtro-evaluacion">
                <p><strong>Docente:</strong> <?= $eval['nombre_docente'] . " " . $eval['apellido_docente'] ?></p>
                <p><strong>Estudiante:</strong> <?= $eval['nombre_estudiante'] . " " . $eval['apellido_estudiante'] ?></p>
                <p><strong>Carrera:</strong> <?= $eval['nombre_carrera'] ?></p>
                <p><strong>Fecha:</strong> <?= $eval['fecha_evaluacion'] ?></p>
                <p><strong>Calificación global:</strong> <?= $eval['calificacion'] ?></p>

                <p><strong>A1. Plan de estudios:</strong> <?= $eval['p1'] ?></p>
                <p><strong>A2. Actividades planificadas:</strong> <?= $eval['p2'] ?></p>
                <p><strong>B1. Conocimiento del tema:</strong> <?= $eval['p3'] ?></p>
                <p><strong>B2. Respuestas claras:</strong> <?= $eval['p4'] ?></p>
                <p><strong>C1. Métodos y recursos:</strong> <?= $eval['p5'] ?></p>
                <p><strong>D1. Criterios de evaluación:</strong> <?= $eval['p6'] ?></p>
                <p><strong>E1. Respeto y cortesía:</strong> <?= $eval['p7'] ?></p>
                <p><strong>F1. Puntualidad:</strong> <?= $eval['p8'] ?></p>
                <p><strong>G1. Ambiente de respeto:</strong> <?= $eval['p9'] ?></p>
                <p><strong>H1. Uso de tecnologías:</strong> <?= $eval['p10'] ?></p>

                <?php if (!empty($eval['descripcion'])): ?>
                    <p><strong>Comentario:</strong> <?= nl2br(htmlspecialchars($eval['descripcion'])) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('buscador');
            const cajas = document.querySelectorAll('.filtro-evaluacion');

            input.addEventListener('input', () => {
                const valor = input.value.toLowerCase();

                cajas.forEach(caja => {
                    const texto = caja.innerText.toLowerCase();
                    if (texto.includes(valor)) {
                        caja.style.display = 'block';
                    } else {
                        caja.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>
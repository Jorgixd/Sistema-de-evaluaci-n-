<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
require_once '../config/db.php';

$id_carrera = $_SESSION['id_carrera'];
$id_estudiante = $_SESSION['id_estudiante'];

$query = "SELECT D.id_docente, D.nombre, D.apellido
          FROM Docentes D
          JOIN Docentes_Carreras DC ON D.id_docente = DC.id_docente
          WHERE DC.id_carrera = :id_carrera";

$stmt = $pdo->prepare($query);
$stmt->execute(['id_carrera' => $id_carrera]);
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Evaluación</title>
    <link rel="stylesheet" href="../assets/estilos.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

    </style>
</head>

<body>




    <?php
    require_once '../includes/header.php';
    ?>

    <h3>Formulario de Evaluación Docente</h3>

    <form id="form-evaluacion" action="../controllers/EvaluacionController.php" method="POST" class="formulario-evaluacion">
        <label>Docente:
            <select name="id_docente" id="docente-select" required>
                <?php foreach ($docentes as $docente): ?>
                    <option value="<?php echo $docente['id_docente']; ?>">
                        <?php echo $docente['nombre'] . " " . $docente['apellido']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Calificación (1 Muy malo/ 2 Regular / 3 Promedio / 4 Bueno/5):
            <input type="number" name="calificacion" min="1" max="5" required>
        </label>

        <label>Comentario (opcional):
            <textarea name="descripcion" rows="4"></textarea>
        </label>

        <?php
        $bloques = [
            'A. Planificación del curso' => [
                'p1' => 'El docente presentó el plan de estudios al iniciar el módulo:',
                'p2' => 'El docente planificó actividades según los resultados de aprendizaje:'
            ],
            'B. Dominio del tema' => [
                'p3' => 'El docente demuestra conocimiento del tema:',
                'p4' => 'El docente responde con claridad las preguntas:'
            ],
            'C. Estrategias metodológicas' => ['p5' => 'El docente usa métodos y recursos variados:'],
            'D. Evaluación del aprendizaje' => ['p6' => 'El docente informa los criterios de evaluación al inicio:'],
            'E. Comunicación' => ['p7' => 'El docente se comunica con respeto y cortesía:'],
            'F. Puntualidad y responsabilidad' => ['p8' => 'El docente inicia y termina puntualmente las sesiones:'],
            'G. Manejo de la disciplina' => ['p9' => 'El docente mantiene un ambiente de respeto en clase:'],
            'H. Uso de tecnologías' => ['p10' => 'El docente utiliza tecnologías para apoyar su enseñanza:'],
        ];

        foreach ($bloques as $titulo => $preguntas): ?>
            <fieldset>
                <legend><?php echo $titulo; ?></legend>
                <?php foreach ($preguntas as $name => $texto): ?>
                    <p><?php echo $texto; ?></p>
                    <?php foreach (['Siempre', 'Casi siempre', 'Algunas veces', 'Nunca'] as $op): ?>
                        <label><input type="radio" name="<?php echo $name; ?>" value="<?php echo $op; ?>" required> <?php echo $op; ?></label>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach; ?>

        <button type="submit" class="btn-enviar">Enviar Evaluación</button>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '<?php echo htmlspecialchars($_GET['error']); ?>',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?php echo htmlspecialchars($_GET['success']); ?>',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>


    <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Bienvenido, <?= $_SESSION['nombre'] ?>!',
                text: 'Sesión iniciada correctamente 😊',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>


    <script>
        document.getElementById('docente-select').addEventListener('change', function() {
            const form = document.getElementById('form-evaluacion');

            // Limpiar radios
            const radios = form.querySelectorAll('input[type=radio]');
            radios.forEach(radio => radio.checked = false);

            // Limpiar inputs de tipo número (calificación)
            const numberInputs = form.querySelectorAll('input[type=number]');
            numberInputs.forEach(input => input.value = '');

            // Limpiar textarea
            const textareas = form.querySelectorAll('textarea');
            textareas.forEach(textarea => textarea.value = '');
        });
    </script>

</body>

</html>
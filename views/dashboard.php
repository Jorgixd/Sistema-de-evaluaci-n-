<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema web de Evalacuacion de docente </title>
    <link rel="stylesheet" href="../assets/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="top-bar">
        <span>👤 Usuario: <?php echo $_SESSION['nombre']; ?></span>
        <a href="../public/logout.php">Cerrar Sesión</a>
    </div>

    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
        <p>Carrera: <?php echo $_SESSION['nombre_carrera']; ?></p>

        <h3>Secciones disponibles:</h3>
        <ul>
            <li><a href="evaluar.php">📝 Calificación Docente</a></li>
            <li><a href="evaluar_un_docente.php">👤 Mis Evaluaciones</a></li>
            <li><a href="evaluaciones_por_carrera.php">📚 Evaluaciones de Mi Carrera</a></li>
            <li><a href="evaluaciones_gererales.php">🏫 Evaluaciones del ISTT</a></li>
        </ul>
    </div>

    <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
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

    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= htmlspecialchars($_GET['success']) ?>',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>

</html>
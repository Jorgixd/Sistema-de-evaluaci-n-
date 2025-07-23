<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mostrar errores (solo para depuración, eliminar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <form action="../controllers/LoginController.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Ingresar</button>
        </form>

        <?php if (isset($_GET['error'])): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo htmlspecialchars($_GET["error"]); ?>',
                    timer: 2500,
                    showConfirmButton: false
                });
            </script>
        <?php endif; ?>
    </div>
</body>

</html>

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
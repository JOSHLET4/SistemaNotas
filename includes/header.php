<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <title>Dashboard</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="/css/styleNavBar.css" />
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard.php">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="/login/cerrar-sesion.php"><button type="button" class="btn btn-danger">CERRAR SESION</button></a>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Sistema de Notas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/estudiantes/consultarEstudiante.php">Estudiantes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/profesores/consultarProfesor.php">Profesores</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/cursos/consultarCurso.php">Cursos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/horarios/consultarHorario.php">Horarios</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/notas/consultarNota.php">Notas</a>
              </li>
              <hr>
              <li class="nav-item">
                <a class="nav-link active" href="/login/consultarUsuario.php">Administración de Usuarios</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    </body>
</body>
</html>
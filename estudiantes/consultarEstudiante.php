<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

$where = "";
$nombre = $_GET['busNombre'] ?? '';
$ingreso = $_GET['ingreso'] ?? '';

if (isset($_GET['buscar'])) {
    if (!empty($nombre)) {
        $where = "WHERE nombre LIKE :nombre";
    }
    if (!empty($ingreso)) {
        if (!empty($where)) {
            $where .= " AND fechaRegistro = :ingreso";
        } else {
            $where = "WHERE fechaRegistro = :ingreso";
        }
    }
}

$consultaSQL = "SELECT * FROM tbl_estudiantes $where";
$fechaIngreso = $conexion->prepare($consultaSQL);

// Enlazar parámetros
if (!empty($nombre)) {
    $fechaIngreso->bindValue(':nombre', $nombre . '%');
}
if (!empty($ingreso)) {
    $fechaIngreso->bindValue(':ingreso', $ingreso);
}

try {
    $fechaIngreso->execute();
    $resultadoFechaIngreso = $fechaIngreso->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $resultadoFechaIngreso = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
    <title>Estudiantes</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>ESTUDIANTES</h1>
        <section>
            <section class="seccionFiltro">
            <form class="filtroForm" method="GET">
                <input class="form-control" type="text" placeholder="Ingresa el nombre del estudiante" name="busNombre">
                <select class="form-select form-select-sm" name="ingreso">
                    <option value="">Fecha de registro</option>
                    <?php
                    $fechasQuery = $conexion->query("SELECT DISTINCT fechaRegistro FROM tbl_estudiantes");
                    $fechas = $fechasQuery->fetchAll(PDO::FETCH_ASSOC);
                    foreach($fechas as $fecha) { ?>
                        <option value="<?php echo $fecha['fechaRegistro']; ?>"><?php echo $fecha['fechaRegistro']; ?></option>
                    <?php } ?>
                </select>
                <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
            </form>
        </section>
        <a href="./insertarEstudiante.php" class="agregar btn btn-outline-info">AGREGAR ESTUDIANTE</a>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th>Código del estudiante</th>
                        <th>Nombres del estudiante</th>
                        <th>Apellidos del estudiante</th>
                        <th>Fecha de nacimiento</th>
                        <th>Género</th>
                        <th>Dirección Residencia</th>
                        <th>Teléfono</th>
                        <th>E-mail</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultadoFechaIngreso)): ?>
                        <?php foreach($resultadoFechaIngreso as $datos): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($datos["idEstudiante"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["nombre"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["apellido"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["fechaNacimiento"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["genero"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["direccion"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["telefono"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["email"]); ?></td>
                                <td><?php echo htmlspecialchars($datos["fechaRegistro"]); ?></td>
                                <td>
                                    <a href="actualizarEstudiante.php?idEstudianteAct=<?php echo htmlspecialchars($datos['idEstudiante']); ?>" class="btn btn-outline-success">Editar</a> 
                                    <a href="#" onclick="setId(<?php echo $datos['idEstudiante']; ?>)" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</a>
                                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-dark" >
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro que desea eliminar este registro? Esta acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-danger" onclick="eliminarRegistro()">Eliminar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No se encontraron resultados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
        let estudianteId = 0;
        function setId(id) {
            estudianteId = id;
        }
        function eliminarRegistro() {
            window.location.href = 'eliminarEstudiante.php?IdEstudianteEli=' + estudianteId;
        }
    </script>
</body>
</html>
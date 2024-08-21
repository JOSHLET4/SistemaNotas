<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    $where = "";
    $nombre = $_GET['busNombre'] ?? '';
    $contratacion = $_GET['contratacion'] ?? '';

    if (isset($_GET['buscar'])) {
        if (!empty($nombre)) {
            $where = "WHERE nombre LIKE :nombre";
        }
        if (!empty($contratacion)) {
            if (!empty($where)) {
                $where .= " AND fechaContratacion = :contratacion";
            } else {
                $where = "WHERE fechaContratacion = :contratacion";
            }
        }
    }

    $consultaSQL = "SELECT * FROM tbl_profesores $where";
    $fechaContratacion = $conexion->prepare($consultaSQL);

    // Enlazar parámetros
    if (!empty($nombre)) {
        $fechaContratacion->bindValue(':nombre', $nombre . '%');
    }
    if (!empty($contratacion)) {
        $fechaContratacion->bindValue(':contratacion', $contratacion);
    }

    try {
        $fechaContratacion->execute();
        $resultadoContratacion = $fechaContratacion->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $resultadoContratacion = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
    <h1>PROFESORES</h1>
    <section>
        <section class="seccionFiltro">
            <form class="filtroForm" method="GET">
                <input class="form-control" type="text" placeholder="Ingresa el nombre del profesor" name="busNombre">
                <select class="form-select form-select-sm" name="contratacion">
                    <option value="">Fecha de contratacion</option>
                    <?php
                    $contratacionQuery = $conexion->query("SELECT DISTINCT fechaContratacion FROM tbl_profesores");
                    $contratacion = $contratacionQuery->fetchAll(PDO::FETCH_ASSOC);
                    foreach($contratacion as $contrataciones) { ?>
                        <option value="<?php echo $contrataciones['fechaContratacion']; ?>"><?php echo $contrataciones['fechaContratacion']; ?></option>
                    <?php } ?>
                </select>
                <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
            </form>
        </section>
        <a href="./insertarProfesor.php" class="agregar btn btn-outline-info">AGREGAR PROFESOR</a>
        <table class="table table-dark table-striped-columns">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>E-mail</th>
                    <th>Fecha de contratación</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($resultadoContratacion)): ?>
                <?php foreach($resultadoContratacion as $datos): ?>
                <tr>
                    <td> <?php echo htmlspecialchars($datos['idProfesor']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['nombre']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['apellido']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['especialidad']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['telefono']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['email']); ?> </td>
                    <td> <?php echo htmlspecialchars($datos['fechaContratacion']); ?> </td>
                    <td>
                        <a href="actualizarProfesor.php?idProfesorAct=<?php echo $datos['idProfesor']; ?>" class="btn btn-outline-success">Editar</a> 
                        <a href="#" onclick="setId(<?php echo $datos['idProfesor']; ?>)" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</a>
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
        let profesorId = 0;
        function setId(id) {
            profesorId = id;
        }
        function eliminarRegistro() {
            window.location.href = 'eliminarProfesor.php?IdProfesorEli=' + profesorId;
        }
    </script>
</body>
</html>
<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    $where = "";
    $id = $_GET['idBus'] ?? '';
    $fechaEv = $_GET['fechaEv'] ?? '';

    if (isset($_GET['buscar'])) {
        if (!empty($id)) {
            $where = "WHERE idEstudiante LIKE :id";
        }
        if (!empty($fechaEv)) {
            if (!empty($where)) {
                $where .= " AND fechaEvaluacion = :fechaEv";
            } else {
                $where = "WHERE fechaEvaluacion = :fechaEv";
            }
        }
    }

    $consultaSQL = "SELECT n.*, e.nombre, c.nombreCurso FROM tbl_notas n INNER JOIN tbl_estudiantes e ON n.idEstudiante = e.idEstudiante INNER JOIN tbl_cursos c ON n.idCurso = c.idCurso $where";
    $fechaEvalua = $conexion->prepare($consultaSQL);

    // Enlazar parámetros
    if (!empty($id)) {
        $fechaEvalua->bindValue(':id', $id . '%');
    }
    if (!empty($fechaEv)) {
        $fechaEvalua->bindValue(':fechaEv', $fechaEv);
    }

    try {
        $fechaEvalua->execute();
        $resultadoFechaEvaluacion = $fechaEvalua->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $resultadoFechaEvaluacion = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>NOTAS</h1>
        <section>
            <section class="seccionFiltro">
                <form class="filtroForm" method="GET">
                    <input class="form-control" type="text" placeholder="Ingresa el ID del estudiante" name="idBus">
                    <select class="form-select form-select-sm" name="fechaEv">
                        <option value="">Fecha de evaluación</option>
                        <?php
                        $fechasQuery = $conexion->query("SELECT DISTINCT fechaEvaluacion FROM tbl_notas ORDER BY fechaEvaluacion DESC");
                        $fechas = $fechasQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach($fechas as $fecha) { ?>
                            <option value="<?php echo $fecha['fechaEvaluacion']; ?>"><?php echo $fecha['fechaEvaluacion']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
                </form>
            </section>
            <a href="./insertarNota.php" class="agregar btn btn-outline-info">AGREGAR NOTA</a>
                <table class="table table-dark table-striped-columns">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Parcial</th>
                            <th>Final</th>
                            <th>Fecha de la evaluación final</th>
                            <th>Nota</th>
                            <th>Código del estudiante</th>
                            <th>Nombre del estudiante</th>
                            <th>Código del curso</th>
                            <th>Nombre del curso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($resultadoFechaEvaluacion)): ?>
                        <?php foreach($resultadoFechaEvaluacion as $datos): ?>
                        <tr>
                            <td> <?php echo htmlspecialchars($datos['notaZona']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['notaParcial']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['notaFinal']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['fechaEvaluacion']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['notaTotal']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['idEstudiante']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['nombre']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['idCurso']); ?> </td>
                            <td> <?php echo htmlspecialchars($datos['nombreCurso']); ?> </td>
                            <td>
                                <a href="actualizarNota.php?idNotaAct=<?php echo $datos['idNota']; ?>" class="btn btn-outline-success">Editar</a> 
                                <a href="#" onclick="setId(<?php echo $datos['idNota']; ?>)" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</a>
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
        let notaId = 0;
        function setId(id) {
            notaId = id;
        }
        function eliminarRegistro() {
            window.location.href = 'eliminarNota.php?IdNotaEli=' + notaId;
        }
    </script>
</body>
</html>
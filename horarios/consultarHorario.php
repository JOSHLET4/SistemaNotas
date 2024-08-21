<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    $where = "";
    $dia = $_GET['busDia'] ?? '';
    $aula = $_GET['aula'] ?? '';

    if (isset($_GET['buscar'])) {
        if (!empty($dia)) {
            $where = "WHERE diaSemana LIKE :dia";
        }
        if (!empty($aula)) {
            if (!empty($where)) {
                $where .= " AND aula = :aula";
            } else {
                $where = "WHERE aula = :aula";
            }
        }
    }

    $consultaSQL = "SELECT h.*, c.nombreCurso FROM tbl_horarios h INNER JOIN tbl_cursos c ON h.idCurso = c.idCurso $where";
    $horarios = $conexion->prepare($consultaSQL);

    // Enlazar parámetros
    if (!empty($dia)) {
        $horarios->bindValue(':dia', $dia . '%');
    }
    if (!empty($aula)) {
        $horarios->bindValue(':aula', $aula);
    }

    try {
        $horarios->execute();
        $resultadohorarios = $horarios->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $resultadohorarios = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>HORARIOS</h1>
        <section>
            <section class="seccionFiltro">
                <form class="filtroForm" method="GET">
                    <input class="form-control" type="text" placeholder="Ingresa un día de la semana" name="busDia">
                    <select class="form-select form-select-sm" name="aula">
                        <option value="">Aula</option>
                        <?php
                        $aulasQuery = $conexion->query("SELECT DISTINCT aula FROM tbl_horarios");
                        $aulas = $aulasQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach($aulas as $aula) { ?>
                            <option value="<?php echo $aula['aula']; ?>"><?php echo $aula['aula']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
                </form>
            </section>
            <a href="./insertarHorario.php" class="agregar btn btn-outline-info">AGREGAR HORARIO</a>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th>Día de la semana</th>
                        <th>Hora inicio</th>
                        <th>Hora finalización</th>
                        <th>Aula</th>
                        <th>Código del curso</th>
                        <th>Nombre del curso</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($resultadohorarios)): ?>
                    <?php foreach($resultadohorarios as $datos): ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($datos['diaSemana']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['horaInicio']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['horaFin']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['aula']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['idCurso']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['nombreCurso']); ?> </td>
                        <td>
                            <a href="actualizarHorario.php?idHorarioAct=<?php echo $datos['idHorario']; ?>" class="btn btn-outline-success">Editar</a> 
                            <a href="#" onclick="setId(<?php echo $datos['idHorario']; ?>)" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</a>
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
        let horarioId = 0;
        function setId(id) {
            horarioId = id;
        }
        function eliminarRegistro() {
            window.location.href = 'eliminarHorario.php?IdHorarioEli=' + horarioId;
        }
    </script>
</body>
</html>
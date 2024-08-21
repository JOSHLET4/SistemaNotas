<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    $where = "";
    $id = $_GET['busId'] ?? '';
    $curso = $_GET['busNombre'] ?? '';

    if (isset($_GET['buscar'])) {
        if(!empty($id)) {
            $where = "WHERE idCurso LIKE :id";
        }
        if(!empty($curso)) {
            if(!empty($where)) {
                $where .= " AND nombreCurso = :curso";
            } else {
                $where = "WHERE nombreCurso = :curso";
            }
        }
    }

    $consultaSQL = "SELECT c.*, p.nombre AS nombreProfesor FROM tbl_cursos c INNER JOIN tbl_profesores p ON c.idProfesor = p.idProfesor $where";
    $sentenciaConsulta = $conexion->prepare($consultaSQL);

    if(!empty($id)) {
        $sentenciaConsulta->bindValue(':id', $id . '%');
    }
    if(!empty($curso)) {
        $sentenciaConsulta->bindValue(':curso', $curso);
    }

    try {
    $sentenciaConsulta->execute();
    $resultado = $sentenciaConsulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $resultado = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>CURSOS</h1>
        <section>
            <section class="seccionFiltro">
                <form class="filtroForm" method="GET">
                    <input class="form-control" type="text" placeholder="Ingresa el ID del curso" name="busId">
                    <select class="form-select form-select-sm" name="busNombre">
                        <option value="">Selecciona el curso</option>
                        <?php
                        $cursoQuery = $conexion->query("SELECT DISTINCT nombreCurso FROM tbl_cursos");
                        $cursos = $cursoQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach($cursos as $curso) { ?>
                            <option value="<?php echo $curso['nombreCurso']; ?>"><?php echo $curso['nombreCurso']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
                </form>
            </section>
            <a href="./insertarCurso.php" class="agregar btn btn-outline-info">AGREGAR CURSO</a>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th>Código del curso</th>
                        <th>Nombre del Curso</th>
                        <th>Descripción del Curso</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de Finalización</th>
                        <th>Código del Profesor</th>
                        <th>Nombre del Profesor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultado)): ?>
                    <?php foreach($resultado as $datos): ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($datos['idCurso']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['nombreCurso']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['descripcion']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['fechaInicio']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['fechaFin']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['idProfesor']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['nombreProfesor']); ?> </td>
                        <td>
                        <a href="actualizarCurso.php?idCursoAct=<?php echo $datos['idCurso']; ?>" class="btn btn-outline-success">Editar</a> 
                        <a href="#" onclick="setId(<?php echo $datos['idCurso']; ?>)" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</a>
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
        let cursoId = 0;
        function setId(id) {
            cursoId = id;
        }
        function eliminarRegistro() {
            window.location.href = 'eliminarCurso.php?IdCursoEli=' + cursoId;
        }
    </script>
</body>
</html>
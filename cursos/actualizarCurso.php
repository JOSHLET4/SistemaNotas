<?php
session_start();
if(!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

    require '../conexion.php';

    if(isset($_GET['idCursoAct'])) {
        $id = $_GET['idCursoAct'];

        $consultaSQL = 'SELECT * FROM tbl_cursos WHERE idCurso = :id';
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $curso = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($curso === false) {
            echo "Curso no encontrado";
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $nombre = $_POST['nombreInp'];
            $descripcion = $_POST['descripcionInp'];
            $fechaInicio = $_POST['fechaInicioInp'];
            $fechaFin = $_POST['fechaFinInp'];
            $idProfesor = $_POST['idProfesorInp'];

            $actualizarSQL = 'UPDATE tbl_cursos SET nombreCurso = :nombre, descripcion = :descripcion, fechaInicio = :fechaInicio, fechaFin = :fechaFin, idProfesor = :idProfesor WHERE idCurso = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':descripcion', $descripcion);
            $sentencia->bindParam(':fechaInicio', $fechaInicio);
            $sentencia->bindParam(':fechaFin', $fechaFin);
            $sentencia->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
            if($sentencia->execute()) {
                header('Location: ./consultarCurso.php');
                exit;
            } else {
                echo "Error al modificar el curso";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Actualizar Curso</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>ACTUALIZAR CURSO</h1>
        <form method="POST" class="mb-3 row">
            Nombre: <input class="form-control" type="text" name="nombreInp" value="<?php echo htmlspecialchars($curso["nombreCurso"]) ?>" required><br>
            Descripcion: <input class="form-control" type="text" name="descripcionInp" value="<?php echo htmlspecialchars($curso['descripcion']) ?>" required><br>
            Fecha de inicio: <input class="form-control" type="date" name="fechaInicioInp" value="<?php echo htmlspecialchars($curso['fechaInicio']) ?>" required><br>
            Fecha de dinalización: <input class="form-control" type="date" name="fechaFinInp" value="<?php echo htmlspecialchars($curso['fechaFin']) ?>" required><br>
            Código del profesor: <input class="form-control" type="number" name="idProfesorInp" value="<?php echo htmlspecialchars($curso['idProfesor']) ?>" required><br>
            <hr>
            <input type="submit" value="Actualizar Curso" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarCurso.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
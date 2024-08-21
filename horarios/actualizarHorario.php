<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

    if(isset($_GET['idHorarioAct'])) {
        $id = $_GET['idHorarioAct'];

        $consultaSQL = 'SELECT * FROM tbl_horarios WHERE idHorario = :id';
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $horario = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($horario == false) {
            echo "Horario no encontrado";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $dia = $_POST['diaInp'];
            $horaInicio = $_POST['horaInicioInp'];
            $horaFin = $_POST['horaFinInp'];
            $aula = $_POST['aulaInp'];
            $idCurso = $_POST['idCursoInp'];

            $actualizarSQL = 'UPDATE tbl_horarios SET diaSemana = :dia, horaInicio = :horaInicio, horaFin = :horaFin, aula = :aula, idCurso = :idCurso WHERE idHorario = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':dia', $dia);
            $sentencia->bindParam(':horaInicio', $horaInicio);
            $sentencia->bindParam(':horaFin', $horaFin);
            $sentencia->bindParam(':aula', $aula);
            $sentencia->bindParam(':idCurso', $idCurso);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            if($sentencia->execute()) {
                header('Location: ./consultarHorario.php');
                exit;
            } else {
                echo "Error al modificar el horario";
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
    <title>Actualizar Horario</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
    <h1>ACTUALIZAR HORARIO</h1>
        <form method="POST" class="mb-3 row">
            Día: <input class="form-control" type="text" name="diaInp" value="<?php echo htmlspecialchars($horario["diaSemana"]) ?>" required><br>
            Hora de inicio: <input class="form-control" type="text" name="horaInicioInp" value="<?php echo htmlspecialchars($horario['horaInicio']) ?>" required><br>
            Hora de finalización: <input class="form-control" type="text" name="horaFinInp" value="<?php echo htmlspecialchars($horario['horaFin']) ?>" required><br>
            Aula: <input class="form-control" type="text" name="aulaInp" value="<?php echo htmlspecialchars($horario['aula']) ?>" required><br>
            ID del curso: <input class="form-control" type="text" name="idCursoInp" value="<?php echo htmlspecialchars($horario['idCurso']) ?>" required><br>
            <hr>
            <input type="submit" value="Actualizar Horario" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarHorario.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
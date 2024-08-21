<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $diaSemana = $_POST['diaSemanaInp'];
        $horaInicio = $_POST['horaInicioInp'];
        $horaFin = $_POST['horaFinInp'];
        $aula = $_POST['aulaInp'];
        $idCurso = $_POST['idCursoInp'];

        $insertarSQL = 'INSERT INTO tbl_horarios (diaSemana, horaInicio, horaFin, aula, idCurso) VALUES (:diaSemana, :horaInicio, :horaFin, :aula, :idCurso)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':diaSemana', $diaSemana);
        $sentencia->bindParam(':horaInicio', $horaInicio);
        $sentencia->bindParam(':horaFin', $horaFin);
        $sentencia->bindParam(':aula', $aula);
        $sentencia->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);

        if($sentencia->execute()) {
            header('Location: ./consultarHorario.php');
        } else {
            echo "Error al crear al estudiante";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Crear Horario</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <main>
    <h1>CREAR HORARIO</h1>
        <form method="POST" class="mb-3 row">
        Día de la semana: <input class="form-control" type="text" name="diaSemanaInp" required><br>
        Hora de inicio: <input class="form-control" type="text" name="horaInicioInp" required><br>
        Hora de finalización: <input class="form-control" type="text" name="horaFinInp" required><br>
        Aula: <input class="form-control" type="text" name="aulaInp" required><br>
        ID del curso: <input class="form-control" type="number" name="idCursoInp" required><br>
        <hr>
        <input type="submit" value="Crear Horario" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarHorario.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombreInp'];
        $descripcion = $_POST['descripcionInp'];
        $fechaInicio = $_POST['fechaInicioInp'];
        $fechaFin = $_POST['fechaFinInp'];
        $idProfesor = $_POST['idProfesorInp'];

        $insertarSQL = 'INSERT INTO tbl_cursos (nombreCurso, descripcion, fechaInicio, fechaFin, idProfesor) VALUES (:nombre, :descripcion, :fechaInicio, :fechaFin, :idProfesor)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':fechaInicio', $fechaInicio);
        $sentencia->bindParam(':fechaFin', $fechaFin);
        $sentencia->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);

        if($sentencia->execute()) {
            header('Location: ./consultarCurso.php');
        } else {
            echo "Error al crear el curso";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Crear Curso</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <main>
    <h1>CREAR CURSO</h1>
        <form method="POST" class="mb-3 row">
        Nombre: <input class="form-control" type="text" name="nombreInp" required><br>
        Descripcion: <input class="form-control" type="text" name="descripcionInp" required><br>
        Fecha de inicio: <input class="form-control" type="date" name="fechaInicioInp" required><br>
        Fecha de finalización: <input class="form-control" type="date" name="fechaFinInp" required><br>
        ID del profesor: <input class="form-control" type="text" name="idProfesorInp" required><br>
        <hr>
        <input type="submit" value="Crear Curso" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarCurso.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
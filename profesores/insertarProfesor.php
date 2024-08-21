<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombreInp'];
        $apellido = $_POST['apellidoInp'];
        $especialidad = $_POST['especialidadInp'];
        $telefono = $_POST['telefonoInp'];
        $email = $_POST['emailInp'];
        $fechaContratacion = $_POST['fechaContratacionInp'];

        $insertarSQL = 'INSERT INTO tbl_profesores (nombre, apellido, especialidad, telefono, email, fechaContratacion) VALUES (:nombre, :apellido, :especialidad, :telefono, :email, :fechaContratacion)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':apellido', $apellido);
        $sentencia->bindParam(':especialidad', $especialidad);
        $sentencia->bindParam(':telefono', $telefono);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':fechaContratacion', $fechaContratacion);

        if($sentencia->execute()) {
            header('Location: ./consultarProfesor.php');
        } else {
            echo "Error al crear al profesor";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Crear Profesor</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <main>
    <h1>CREAR PROFESOR</h1>
        <form method="POST" class="mb-3 row">
        Nombres: <input class="form-control" type="text" name="nombreInp" required><br>
        Apellidos: <input class="form-control" type="text" name="apellidoInp" required><br>
        Especialidad: <input class="form-control" type="text" name="especialidadInp" required><br>
        Teléfono: <input class="form-control" type="text" name="telefonoInp" required><br>
        E-mail: <input class="form-control" type="text" name="emailInp" required><br>
        Fecha de contratación: <input class="form-control" type="date" name="fechaContratacionInp" required><br>
        <hr>
        <input type="submit" value="Crear Profesor" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarProfesor.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
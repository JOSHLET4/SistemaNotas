<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombreInp'];
        $apellido = $_POST['apellidoInp'];
        $fechaNacimiento = $_POST['fechaNacimientoInp'];
        $genero = $_POST['generoInp'];
        $direccion = $_POST['direccionInp'];
        $telefono = $_POST['telefonoInp'];
        $email = $_POST['emailInp'];
        $fechaRegistro = $_POST['fechaRegistroInp'];

        $insertarSQL = 'INSERT INTO tbl_estudiantes (nombre, apellido, fechaNacimiento, genero, direccion, telefono, email, fechaRegistro) VALUES (:nombre, :apellido, :fechaNacimiento, :genero, :direccion, :telefono, :email, :fechaRegistro)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':apellido', $apellido);
        $sentencia->bindParam(':fechaNacimiento', $fechaNacimiento);
        $sentencia->bindParam(':genero', $genero);
        $sentencia->bindParam(':direccion', $direccion);
        $sentencia->bindParam(':telefono', $telefono);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':fechaRegistro', $fechaRegistro);

        if($sentencia->execute()) {
            header('Location: ./consultarEstudiante.php');
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
    <title>Crear Estudiante</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <main>
    <h1>CREAR ESTUDIANTE</h1>
        <form method="POST" class="mb-3 row">
        Nombres: <input class="form-control" type="text" name="nombreInp" required><br>
        Apellidos: <input class="form-control" type="text" name="apellidoInp" required><br>
        Fecha de nacimiento: <input class="form-control" type="date" name="fechaNacimientoInp" required><br>
        Género: <input class="form-control" type="text" name="generoInp" placeholder="Escribe M o F" required><br>
        Dirección de residencia: <input class="form-control" type="text" name="direccionInp" required><br>
        Teléfono: <input class="form-control" type="text" name="telefonoInp" required><br>
        E-mail: <input class="form-control" type="text" name="emailInp" required><br>
        Fecha de Registro: <input class="form-control" type="date" name="fechaRegistroInp" required><br>
        <hr>
        <input type="submit" value="Crear Estudiante" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarEstudiante.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
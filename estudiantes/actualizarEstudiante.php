<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    if(isset($_GET['idEstudianteAct'])) {
        $id = $_GET['idEstudianteAct'];

        $consultaSQL = 'SELECT * FROM tbl_estudiantes WHERE idEstudiante = :id';
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $estudiante = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($estudiante === false) {
            echo "Estudiante no encontrado";
            exit;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombreInp'];
            $apellido = $_POST['apellidoInp'];
            $fecha = $_POST['fechaInp'];
            $genero = $_POST['generoInp'];
            $direccion = $_POST['direccionInp'];
            $telefono = $_POST['telefonoInp'];
            $email = $_POST['emailInp'];
            $fechaRegistro = $_POST['fechaRegistroInp'];

            $actualizarSQL = 'UPDATE tbl_estudiantes SET nombre = :nombre, apellido = :apellido, FechaNacimiento = :fecha, genero = :genero, direccion = :direccion, telefono = :telefono, email = :email, fechaRegistro = :fechaRegistro WHERE idEstudiante = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellido', $apellido);
            $sentencia->bindParam(':fecha', $fecha);
            $sentencia->bindParam(':genero', $genero);
            $sentencia->bindParam(':direccion', $direccion);
            $sentencia->bindParam(':telefono', $telefono);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':fechaRegistro', $fechaRegistro);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            if($sentencia->execute()) {
                header('Location: ./consultarEstudiante.php');
                exit;
            } else{
                echo "Error al modificar el estudiante";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Actualizacion Estudiante</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleActualizar.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>ACTUALIZAR ESTUDIANTE</h1>
        <form method="POST" class="mb-3 row">
            Nombres: <input class="form-control" type="text" name="nombreInp" value="<?php echo htmlspecialchars($estudiante["nombre"]) ?>" required><br>
            Apellidos: <input class="form-control" type="text" name="apellidoInp" value="<?php echo htmlspecialchars($estudiante['apellido']) ?>" required><br>
            Fecha de Nacimiento: <input class="form-control" type="date" name="fechaInp" value="<?php echo htmlspecialchars($estudiante['fechaNacimiento']) ?>" required><br>
            Genero: <input class="form-control" type="text" name="generoInp" value="<?php echo htmlspecialchars($estudiante['genero']) ?>" required><br>
            Direccion de Residencia: <input class="form-control" type="text" name="direccionInp" value="<?php echo htmlspecialchars($estudiante['direccion']) ?>" required><br>
            Telefono: <input class="form-control" type="text" name="telefonoInp" value="<?php echo htmlspecialchars($estudiante['telefono']) ?>" required><br>
            E-mail: <input class="form-control" type="text" name="emailInp" value="<?php echo htmlspecialchars($estudiante['email']) ?>" required><br>
            Fecha de Registro: <input class="form-control" type="date" name="fechaRegistroInp" value="<?php echo htmlspecialchars($estudiante['fechaRegistro']) ?>" required><br>
            <hr>
            <input type="submit" value="Actualizar Estudiante" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarEstudiante.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
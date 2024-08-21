<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    if(isset($_GET['idProfesorAct'])) {
        $id = $_GET['idProfesorAct'];

        $consultaSQL = 'SELECT * FROM tbl_profesores WHERE idProfesor = :id';
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $profesor = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($profesor === false) {
            echo "Profesor no encontrado";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombreInp"];
            $apellido = $_POST["apellidoInp"];
            $especialidad = $_POST["especialidadInp"];
            $telefono = $_POST["telefonoInp"];
            $email = $_POST["emailInp"];
            $fechaContratacion = $_POST["fechaContratacionInp"];

            $actualizarSQL = 'UPDATE tbl_profesores SET nombre = :nombre, apellido = :apellido, especialidad = :especialidad, telefono = :telefono, email = :email, fechaContratacion = :fechaContratacion WHERE idProfesor = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellido', $apellido);
            $sentencia->bindParam(':especialidad', $especialidad);
            $sentencia->bindParam(':telefono', $telefono);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':fechaContratacion', $fechaContratacion);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            if($sentencia->execute()) {
                header('Location: ./consultarProfesor.php');
                exit;
            } else {
                echo "Error al modificar el profesor";
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
    <title>Actualizar Profesor</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>ACTUALIZAR PROFESOR</h1>
        <form method="POST" class="mb-3 row">
            Nombres: <input class="form-control" type="text" name="nombreInp" value="<?php echo htmlspecialchars($profesor["nombre"]) ?>" required><br>
            Apellidos: <input class="form-control" type="text" name="apellidoInp" value="<?php echo htmlspecialchars($profesor['apellido']) ?>" required><br>
            Especialidad: <input class="form-control" type="text" name="especialidadInp" value="<?php echo htmlspecialchars($profesor['especialidad']) ?>" required><br>
            Telefono: <input class="form-control" type="text" name="telefonoInp" value="<?php echo htmlspecialchars($profesor['telefono']) ?>" required><br>
            Telefono: <input class="form-control" type="text" name="telefonoInp" value="<?php echo htmlspecialchars($profesor['telefono']) ?>" required><br>
            E-mail: <input class="form-control" type="text" name="emailInp" value="<?php echo htmlspecialchars($profesor['email']) ?>" required><br>
            Fecha de Contratación: <input class="form-control" type="date" name="fechaContratacionInp" value="<?php echo htmlspecialchars($profesor['fechaContratacion']) ?>" required><br>
            <hr>
            <input type="submit" value="Actualizar Profesor" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarProfesor.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
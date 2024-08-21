<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if(isset($_GET['idUsuarioAct'])) {
        $id = $_GET['idUsuarioAct'];

        $consultaSQL = 'SELECT * FROM usuario WHERE id = :id';
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($usuario == false) {
            echo "Usuario no encontrado";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['usernameInp'];
            $nombre = $_POST['nombreInp'];
            $email = $_POST['emailInp'];

            $actualizarSQL = 'UPDATE usuario SET username = :username, nombreCompleto = :nombre, email = :email WHERE id = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':username', $username);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            if($sentencia->execute()) {
                header('Location: ./consultarUsuario.php');
                exit;
            } else {
                echo "Error al modificar el usuario";
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
    <title>Actualizar Usuario</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <form method="POST" class="mb-3 row">
            Usuario: <input class="form-control" type="text" name="usernameInp" value="<?php echo htmlspecialchars($usuario["username"]) ?>" required><br>
            Nombre: <input class="form-control" type="text" name="nombreInp" value="<?php echo htmlspecialchars($usuario['nombreCompleto']) ?>" required><br>
            E-mail: <input class="form-control" type="text" name="emailInp" value="<?php echo htmlspecialchars($usuario['email']) ?>" required><br>
            <hr>
            <input type="submit" value="Actualizar Usuario" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarUsuario.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
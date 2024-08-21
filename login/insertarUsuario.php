<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuarioInp'];
        $nombre = $_POST['nombreInp'];
        $password = $_POST['passwordInp'];
        $email = $_POST['emailInp'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertarSQL = 'INSERT INTO usuario (username, nombreCompleto, password, email) VALUES (:usuario, :nombre, :password, :email)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':usuario', $usuario);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':password', $hashedPassword);
        $sentencia->bindParam(':email', $email);

        if($sentencia->execute()) {
            header('Location: ./consultarUsuario.php');
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
    <title>Crear Usuario</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <main>
    <h1>CREAR USUARIO</h1>
        <form method="POST" class="mb-3 row">
        Usuario: <input class="form-control" type="text" name="usuarioInp" required><br>
        Nombre: <input class="form-control" type="text" name="nombreInp" required><br>
        Contraseña: <input class="form-control" type="password" name="passwordInp" required><br>
        email: <input class="form-control" type="email" name="emailInp" required><br>
        <hr>
        <input type="submit" value="Crear Usuario" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarUsuario.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
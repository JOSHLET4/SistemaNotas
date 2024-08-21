<?php 
require '../conexion.php';

session_start();

// Validación si se ha enviado información
if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: ../index.html');
    exit;
}

// Evitar inyecciones SQL
$stmt = $conexion->prepare('SELECT id, username, nombreCompleto, password FROM usuario WHERE username = :username');
$stmt->bindParam(':username', $_POST['username']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Validar si lo ingresado coincide con la base de datos
if ($user) {
    if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['username'] = $user['nombreCompleto'];
        header('Location: ../dashboard.php');
        exit;
    } else {
        header('Location: ../index.html');
        exit;
    }
} else {
    header('Location: ../index.html');
    exit;
}
?>

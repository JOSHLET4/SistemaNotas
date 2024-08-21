<?php 
    $servidor = "127.0.0.1:3310";
    $nombreBD = "notaseducativas";
    $usuario = "root";
    $contrasenia = "";

    try {
        $conexion = new PDO("mysql:host=$servidor; dbname=$nombreBD", $usuario, $contrasenia);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOExeption $e) {
        echo "Error en la conexion de la base de datos" . $e.getMessage();
    }
?>
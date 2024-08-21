<?php 
    $SERVIDOR = "127.0.0.1";
    $PORT = "3310";
    $NOMBREBD = "notaseducativas";
    $USUARIO = "root";
    $PASSWORD = "";

    try {
        $conexion = new PDO("mysql:host=$SERVIDOR;port=$PORT dbname=$NOMBREBD", $USUARIO, $PASSWORD);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOExeption $e) {
        echo "Error en la conexion de la base de datos" . $e.getMessage();
    }
?>
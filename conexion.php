<?php 
    $SERVIDOR = "mysql.railway.internal";
    $PORT = "3306";
    $NOMBREBD = "railway";
    $USUARIO = "root";
    $PASSWORD = "QUwMKUeZXmjhzDiSqKiUtIboHoocbaIB";

    try {
        $conexion = new PDO("mysql:host=$SERVIDOR;port=$PORT;dbname=$NOMBREBD", $USUARIO, $PASSWORD);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOExeption $e) {
        echo "Error en la conexion de la base de datos" . $e->getMessage();
    }
?>
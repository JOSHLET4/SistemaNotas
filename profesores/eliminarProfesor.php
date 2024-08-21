<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../conexion.php';

    if(isset($_GET["IdProfesorEli"]) == "GET") {
        $id = $_GET["IdProfesorEli"];

        $eliminarSQL = "DELETE FROM tbl_profesores WHERE idProfesor = :id";
        $sentencia = $conexion->prepare($eliminarSQL);
        $sentencia->bindParam(":id", $id);

        if($sentencia->execute()) {
            header("Location: consultarProfesor.php");
            exit;
        }
        else{
            echo "Error al eliminar al profesor";
        }
    }
?>
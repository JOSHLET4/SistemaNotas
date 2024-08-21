<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

    if(isset($_GET["IdEstudianteEli"]) == "GET") {
        $id = $_GET["IdEstudianteEli"];

        $eliminarSQL = "DELETE FROM tbl_estudiantes WHERE idEstudiante = :id";
        $sentencia = $conexion->prepare($eliminarSQL);
        $sentencia->bindParam(":id", $id);

        if($sentencia->execute()) {
            header("Location: consultarEstudiante.php");
            exit;
        }
        else{
            echo "Error al eliminar el estudiante";
        }
    }
?>
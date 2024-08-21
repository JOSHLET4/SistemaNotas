<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

    if(isset($_GET["IdHorarioEli"]) == "GET") {
        $id = $_GET["IdHorarioEli"];

        $eliminarSQL = "DELETE FROM tbl_horarios WHERE idHorario = :id";
        $sentencia = $conexion->prepare($eliminarSQL);
        $sentencia->bindParam(":id", $id);

        if($sentencia->execute()) {
            header("Location: consultarHorario.php");
            exit;
        }
        else{
            echo "Error al eliminar el horario";
        }
    }
?>
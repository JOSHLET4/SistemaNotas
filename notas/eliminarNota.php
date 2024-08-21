<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if(isset($_GET["IdNotaEli"]) == "GET") {
        $id = $_GET["IdNotaEli"];

        $eliminarSQL = "DELETE FROM tbl_notas WHERE idNota = :id";
        $sentencia = $conexion->prepare($eliminarSQL);
        $sentencia->bindParam(":id", $id);

        if($sentencia->execute()) {
            header("Location: consultarNota.php");
            exit;
        }
        else{
            echo "Error al eliminar la nota";
        }
    }
?>
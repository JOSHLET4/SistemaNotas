<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if(isset($_GET["IdCursoEli"]) == "GET") {
        $id = $_GET["IdCursoEli"];

        $eliminarSQL = "DELETE FROM tbl_cursos WHERE idCurso = :id";
        $sentencia = $conexion->prepare($eliminarSQL);
        $sentencia->bindParam(":id", $id);

        if($sentencia->execute()) {
            header("Location: consultarCurso.php");
            exit;
        }
        else{
            echo "Error al eliminar el cliente";
        }
    }
?>
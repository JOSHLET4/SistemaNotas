<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.html');
    exit;
}
    require '../conexion.php';

    if(isset($_GET['idNotaAct'])) {
        $id = $_GET['idNotaAct'];

        $consultarSQL = 'SELECT * FROM tbl_notas WHERE idNota = :id';
        $sentencia = $conexion->prepare($consultarSQL);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();
        $nota = $sentencia->fetch(PDO::FETCH_ASSOC);
        if($nota === false) {
            echo "Nota no encontrada";
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $notaZ = $_POST["notaZInp"];
            $notaP = $_POST["notaPInp"];
            $notaF = $_POST["notaFInp"];
            $notaT = $_POST["notaTInp"];
            $fechaEv = $_POST["fechaEvInp"];
            $idEstudiante = $_POST["idEstudianteInp"];
            $idCurso = $_POST["idCursoInp"];

            $actualizarSQL = 'UPDATE tbl_notas SET notaZona = :notaZ, notaParcial = :notaP, notaFinal = :notaF, notaTotal = :notaT, fechaEvaluacion = :fechaEv, idEstudiante = :idEstudiante, idCurso = :idCurso WHERE idNota = :id';
            $sentencia = $conexion->prepare($actualizarSQL);
            $sentencia->bindParam(':notaZ', $notaZ);
            $sentencia->bindParam(':notaP', $notaP);
            $sentencia->bindParam(':notaF', $notaF);
            $sentencia->bindParam(':notaT', $notaT);
            $sentencia->bindParam(':fechaEv', $fechaEv);
            $sentencia->bindParam(':idEstudiante', $idEstudiante, PDO::PARAM_INT);
            $sentencia->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
            $sentencia->bindParam(':id', $id, PDO::PARAM_INT);

            if($sentencia->execute()) {
                header('Location: ./consultarNota.php');
                exit();
            } else {
                echo "Error al modificar la nota";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Actualizar Notas</title>
    <script>
        function calculoTotal() {
        let notaZona = parseFloat(document.getElementsByName("notaZInp")[0].value) || 0;
        let notaParcial = parseFloat(document.getElementsByName("notaPInp")[0].value) || 0;
        let notaFinal = parseFloat(document.getElementsByName("notaFInp")[0].value) || 0;
        
        let notaTotal = notaZona + notaParcial + notaFinal;
        document.getElementsByName("notaTInp")[0].value = notaTotal.toFixed(2);
        }
        function inicializarEventosTR() {
            document.getElementsByName("notaZInp")[0].addEventListener('input', calculoTotal);
            document.getElementsByName("notaPInp")[0].addEventListener('input', calculoTotal);
            document.getElementsByName("notaFInp")[0].addEventListener('input', calculoTotal);
        }
        document.addEventListener('DOMContentLoaded', inicializarEventosTR);
    </script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>ACTUALIZAR NOTA</h1>
        <form method="POST" class="mb-3 row">
            Zona: <input class="form-control" type="number" name="notaZInp" value="<?php echo htmlspecialchars($nota["notaZona"]) ?>"><br>
            Nota Parcial: <input class="form-control" type="number" name="notaPInp" value="<?php echo htmlspecialchars($nota['notaParcial']) ?>"><br>
            Nota Final: <input class="form-control" type="number" name="notaFInp" value="<?php echo htmlspecialchars($nota['notaFinal']) ?>"><br>
            Fecha de evaluación final: <input class="form-control" type="text" name="fechaEvInp" value="<?php echo htmlspecialchars($nota['fechaEvaluacion']) ?>"><br>
            Nota Total: <input class="form-control" type="number" name="notaTInp" value="<?php echo htmlspecialchars($nota['notaTotal']) ?>" readonly><br>
            ID del estudiante: <input class="form-control" type="text" name="idEstudianteInp" value="<?php echo htmlspecialchars($nota['idEstudiante']) ?>"><br>
            ID del curso: <input class="form-control" type="text" name="idCursoInp" value="<?php echo htmlspecialchars($nota['idCurso']) ?>"><br>
            <hr>
            <input type="submit" value="Actualizar Nota" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarNota.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
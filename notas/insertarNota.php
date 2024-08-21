<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $notaZ = $_POST['notaZInp'];
        $notaP = $_POST['notaPInp'];
        $notaF = $_POST['notaFInp'];
        $notaT = $_POST['notaTInp'];
        $fechaEv = $_POST['fechaEvInp'];
        $idEstudiante = $_POST['idEstudianteInp'];
        $idCurso = $_POST['idCursoInp'];

        $insertarSQL = 'INSERT INTO tbl_notas (notaZona, notaParcial, notaFinal, notaTotal, fechaEvaluacion, idEstudiante, idCurso) VALUES (:notaZ, :notaP, :notaF, :notaT, :fechaEv, :idEstudiante, :idCurso)';
        $sentencia = $conexion->prepare($insertarSQL);
        $sentencia->bindParam(':notaZ', $notaZ);
        $sentencia->bindParam(':notaP', $notaP);
        $sentencia->bindParam(':notaF', $notaF);
        $sentencia->bindParam(':notaT', $notaT);
        $sentencia->bindParam(':fechaEv', $fechaEv);
        $sentencia->bindParam(':idEstudiante', $idEstudiante, PDO::PARAM_INT);
        $sentencia->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);

        if($sentencia->execute()) {
            header('Location: ./consultarNota.php');
        } else {
            echo "Error al crear la nota";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleActualizar.css" />
    <title>Crear Nota</title>
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
    <h1>CREAR NOTA</h1>
        <form method="POST" class="mb-3 row">
        Zona: <input class="form-control" type="text" name="notaZInp" required><br>
        Exámen parcial: <input class="form-control" type="text" name="notaPInp" required><br>
        Exámen final: <input class="form-control" type="text" name="notaFInp" required><br>
        Fecha evaluación exámen final: <input class="form-control" type="date" name="fechaEvInp" required><br>
        Nota total: <input class="form-control" type="number" name="notaTInp" readonly><br>
        ID del estudiante: <input class="form-control" type="number" name="idEstudianteInp" required><br>
        ID del curso: <input class="form-control" type="number" name="idCursoInp" required><br>
        <hr>
        <input type="submit" value="Crear Nota" class="btn btn-success">
        </form>
    </main>
    <a href="./consultarNota.php" class="btn btn-outline-danger">Salir sin guardar</a>
</body>
</html>
<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
    require '../app/conexion.php';

    $where = "";
    $id = $_GET['usuId'] ?? '';
    $nombre = $_GET['busNombre'] ?? '';

    if (isset($_GET['buscar'])) {
        if(!empty($id)) {
            $where = "WHERE username LIKE :id";
        }
        if(!empty($nombre)) {
            if(!empty($where)) {
                $where .= " AND nombreCompleto = :nombre";
            } else {
                $where = "WHERE nombreCompleto = :nombre";
            }
        }
    }

    $consultaSQL = "SELECT * FROM usuario $where";
    $sentenciaConsulta = $conexion->prepare($consultaSQL);

    if(!empty($id)) {
        $sentenciaConsulta->bindValue(':id', $id . '%');
    }
    if(!empty($nombre)) {
        $sentenciaConsulta->bindValue(':nombre', $nombre);
    }

    try {
    $sentenciaConsulta->execute();
    $resultado = $sentenciaConsulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $resultado = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/styleFiltros.css" />
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>USUARIOS</h1>
        <section>
            <section class="seccionFiltro">
                <form class="filtroForm" method="GET">
                    <input class="form-control" type="text" placeholder="Ingresa el nombre de usuario" name="usuId">
                    <select class="form-select form-select-sm" name="busNombre">
                        <option value="">Selecciona el usuario</option>
                        <?php
                        $usuarioQuery = $conexion->query("SELECT DISTINCT nombreCompleto FROM usuario");
                        $usuarios = $usuarioQuery->fetchAll(PDO::FETCH_ASSOC);
                        foreach($usuarios as $usuario) { ?>
                            <option value="<?php echo $usuario['nombreCompleto']; ?>"><?php echo $usuario['nombreCompleto']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="buscar" type="submit" class="btn btn-outline-success" class="botonFiltro">Filtrar</button>
                </form>
            </section>
            <a href="./insertarUsuario.php" class="agregar btn btn-outline-info">AGREGAR USUARIO</a>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultado)): ?>
                    <?php foreach($resultado as $datos): ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($datos['username']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['nombreCompleto']); ?> </td>
                        <td> <?php echo htmlspecialchars($datos['email']); ?> </td>
                        <td>
                        <a href="actualizarUsuario.php?idUsuarioAct=<?php echo $datos['id']; ?>" class="btn btn-outline-success">Editar</a> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No se encontraron resultados</td>
                        </tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    </script>
</body>
</html>
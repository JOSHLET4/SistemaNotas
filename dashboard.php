<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <title>Dashboard</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php include './includes/header.php'; ?>
    <section class="presentacion">
        <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="/media/images/imagen1.png" width="100%" height="400%">
            </div>
            <div class="carousel-item">
            <img src="/media/images/imagen2.png" width="100%" height="400%">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </section>
    <section class="descargas">
        <button class="button">
            <span class="button_lg">
                <span class="button_sl"></span>
                <a href="/media/images/entidadRelacion.png" download="entidadRelacion" target="_blank">
                    <span class="button_text">Descargar Entidad Relación</span>
                </a>
            </span>
        </button>
        <button class="button">
            <span class="button_lg">
                <span class="button_sl"></span>
                <a href="/media/documents/Manual de Usuario.pdf" dowload="entidadRelacion" target="_blank">
                    <span class="button_text">Descargar Manual de Usuario</span>
                </a>
            </span>
        </button>
        <button class="button">
            <span class="button_lg">
                <span class="button_sl"></span>
                <a href="/media/documents/Manual Tecnico.pdf" dowload="entidadRelacion">
                    <span class="button_text">Descargar Manual Técnico</span>
                </a>
            </span>
        </button>
    </section>
</body>
</html>
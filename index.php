<?php
include 'includes/functions.php';
iniciar_sesion_segura();
inicializar_carrito();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Agencia de Viajes</h1>
    </header>
    <nav>
    <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="ver_viajes.php">Ver Viajes</a></li>
            <li><a href="buscar_viajes.php">Buscar Viajes</a></li>
            <li><a href="agregar_vuelo.php">Agregar Vuelo</a></li>
            <li><a href="agregar_hotel.php">Agregar Hotel</a></li>
            <li><a href="consulta_hoteles.php">Hoteles Populares</a></li>
            <li><a href="carrito.php">Carrito</a></li>
        </ul>
        <?php mostrar_resumen_carrito(); ?><!-- Incluir aquí tu navegación estándar -->
    </nav>
    <main>
        <h2>Ofertas Especiales</h2>
        <?php mostrarOfertasEspeciales(); ?>
        <p>Explora nuestras increíbles ofertas y encuentra tu próximo destino de ensueño.</p>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
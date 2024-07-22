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
    <title>Agregar Hotel - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
    function validarHotel() {
        var nombre = document.getElementById('nombre').value;
        var ubicacion = document.getElementById('ubicacion').value;
        var habitaciones = document.getElementById('habitaciones').value;
        var tarifa = document.getElementById('tarifa').value;

        if (nombre == "" || ubicacion == "" || habitaciones == "" || tarifa == "") {
            alert("Todos los campos son obligatorios");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
    <header>
        <h1>Agregar Nuevo Hotel</h1>
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
        <form action="procesar_hotel.php" method="post" onsubmit="return validarHotel()">
            <label for="nombre">Nombre del Hotel:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required>

            <label for="habitaciones">Habitaciones disponibles:</label>
            <input type="number" id="habitaciones" name="habitaciones" required>

            <label for="tarifa">Tarifa por noche:</label>
            <input type="number" id="tarifa" name="tarifa" step="0.01" required>

            <input type="submit" value="Registrar Hotel">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
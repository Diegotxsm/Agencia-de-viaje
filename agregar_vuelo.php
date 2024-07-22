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
    <title>Agregar Vuelo - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
    function validarVuelo() {
        var origen = document.getElementById('origen').value;
        var destino = document.getElementById('destino').value;
        var fecha = document.getElementById('fecha').value;
        var plazas = document.getElementById('plazas').value;
        var precio = document.getElementById('precio').value;

        if (origen == "" || destino == "" || fecha == "" || plazas == "" || precio == "") {
            alert("Todos los campos son obligatorios");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
    <header>
        <h1>Agregar Nuevo Vuelo</h1>
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
        <form action="procesar_vuelo.php" method="post" onsubmit="return validarVuelo()">
            <label for="origen">Origen:</label>
            <input type="text" id="origen" name="origen" required>

            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="plazas">Plazas disponibles:</label>
            <input type="number" id="plazas" name="plazas" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <input type="submit" value="Registrar Vuelo">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
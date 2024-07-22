<?php
include 'includes/db_connect.php';
include 'includes/functions.php';
iniciar_sesion_segura();
inicializar_carrito();
// Consulta para obtener todos los viajes
$sql = "SELECT * FROM viajes ORDER BY fecha_viaje";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajes Disponibles - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Viajes Disponibles</h1>
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
        <h2>Viajes Disponibles</h2>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='viaje'>";
                echo "<h3>" . htmlspecialchars($row['nombre_hotel']) . "</h3>";
                echo "<p>Ciudad: " . htmlspecialchars($row['ciudad']) . "</p>";
                echo "<p>País: " . htmlspecialchars($row['pais']) . "</p>";
                echo "<p>Fecha: " . htmlspecialchars($row['fecha_viaje']) . "</p>";
                echo "<p>Duración: " . htmlspecialchars($row['duracion_viaje']) . " días</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay viajes disponibles en este momento.</p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
<?php
include 'includes/db_connect.php';
include 'includes/functions.php';

iniciar_sesion_segura();
inicializar_carrito();

$sql = "SELECT h.nombre, h.ubicacion, COUNT(r.id_reserva) as num_reservas
        FROM HOTEL h
        JOIN RESERVA r ON h.id_hotel = r.id_hotel
        GROUP BY h.id_hotel
        HAVING num_reservas > 2
        ORDER BY num_reservas DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles Populares - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Hoteles Populares</h1>
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
        <h2>Hoteles con más de dos reservas:</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nombre del Hotel</th><th>Ubicación</th><th>Número de Reservas</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ubicacion"]) . "</td>";
                echo "<td>" . $row["num_reservas"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron hoteles con más de dos reservas</p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
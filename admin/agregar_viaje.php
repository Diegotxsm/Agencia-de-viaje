<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreHotel = filtro($_POST['nombreHotel']);
    $ciudad = filtro($_POST['ciudad']);
    $pais = filtro($_POST['pais']);
    $fechaViaje = filtro($_POST['fechaViaje']);
    $duracionViaje = filtro($_POST['duracionViaje']);
    $precio = filtro($_POST['precio']);

    $sql = "INSERT INTO viajes (nombre_hotel, ciudad, pais, fecha_viaje, duracion_viaje, precio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssid", $nombreHotel, $ciudad, $pais, $fechaViaje, $duracionViaje, $precio);

    if ($stmt->execute()) {
        $mensaje = "Viaje agregado con éxito.";
    } else {
        $mensaje = "Error al agregar el viaje: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Viaje - Agencia de Viajes</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Agregar Nuevo Viaje</h1>
    </header>
    <main>
        <?php
        if (isset($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
        <form action="agregar_viaje.php" method="post">
            <label for="nombreHotel">Nombre del Hotel:</label>
            <input type="text" id="nombreHotel" name="nombreHotel" required>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" required>

            <label for="fechaViaje">Fecha de Viaje:</label>
            <input type="date" id="fechaViaje" name="fechaViaje" required>

            <label for="duracionViaje">Duración del Viaje (días):</label>
            <input type="number" id="duracionViaje" name="duracionViaje" required>
            
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <input type="submit" value="Agregar Viaje">
            <a href="admin_panel.php" class="back-button">Volver</a>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
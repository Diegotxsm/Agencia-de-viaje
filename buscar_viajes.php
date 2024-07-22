<?php
include 'includes/functions.php';
iniciar_sesion_segura();
inicializar_carrito();
$hoteles = obtener_hoteles($conn);
$ciudades = obtener_ciudades($conn);
$paises = obtener_paises($conn);
$fechas_disponibles = obtener_fechas_disponibles($conn);
$duraciones_disponibles = obtener_duraciones_disponibles($conn);

// Recuperar preferencias de búsqueda si existen
$ultimaBusqueda = isset($_SESSION['ultima_busqueda']) ? $_SESSION['ultima_busqueda'] : null;

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreHotel = filtro($_POST['nombreHotel']);
    $ciudad = filtro($_POST['ciudad']);
    $pais = filtro($_POST['pais']);
    $fechaViaje = filtro($_POST['fechaViaje']);
    $duracionViaje = filtro($_POST['duracionViaje']);

    // Guardar preferencias de búsqueda en la sesión
    guardar_preferencias_busqueda($ciudad, $fechaViaje, $duracionViaje);

    // Redirigir a procesar_viaje.php con los datos del formulario
    header("Location: procesar_viaje.php?nombreHotel=$nombreHotel&ciudad=$ciudad&pais=$pais&fechaViaje=$fechaViaje&duracionViaje=$duracionViaje");
    exit();
}?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Viajes - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Buscar Viajes</h1>
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
    <form action="procesar_viaje.php" method="post">
    <label for="nombreHotel">Nombre del Hotel:</label>
        <select id="nombreHotel" name="nombreHotel">
            <option value="">Seleccione un hotel</option>
            <?php foreach ($hoteles as $hotel): ?>
                <option value="<?php echo htmlspecialchars($hotel); ?>" <?php echo (isset($_POST['nombreHotel']) && $_POST['nombreHotel'] == $hotel) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="ciudad">Ciudad:</label>
        <select id="ciudad" name="ciudad">
            <option value="">Seleccione una ciudad</option>
            <?php foreach ($ciudades as $ciudad): ?>
                <option value="<?php echo htmlspecialchars($ciudad); ?>" <?php echo (isset($_POST['ciudad']) && $_POST['ciudad'] == $ciudad) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($ciudad); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="pais">País:</label>
        <select id="pais" name="pais">
            <option value="">Seleccione un país</option>
            <?php foreach ($paises as $pais): ?>
                <option value="<?php echo htmlspecialchars($pais); ?>" <?php echo (isset($_POST['pais']) && $_POST['pais'] == $pais) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($pais); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="fechaViaje">Fecha de Viaje:</label>
        <select id="fechaViaje" name="fechaViaje">
            <option value="">Seleccione una fecha</option>
            <?php foreach ($fechas_disponibles as $fecha): ?>
                <option value="<?php echo htmlspecialchars($fecha); ?>" <?php echo (isset($_POST['fechaViaje']) && $_POST['fechaViaje'] == $fecha) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($fecha); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="duracionViaje">Duración del Viaje (días):</label>
        <select id="duracionViaje" name="duracionViaje">
            <option value="">Seleccione la duración</option>
            <?php foreach ($duraciones_disponibles as $duracion): ?>
                <option value="<?php echo htmlspecialchars($duracion); ?>" <?php echo (isset($_POST['duracionViaje']) && $_POST['duracionViaje'] == $duracion) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($duracion); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Buscar Viajes">
</form>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
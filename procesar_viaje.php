<?php
// Visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'includes/db_connect.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

include 'includes/functions.php';
include 'FiltroViaje.php';

// Iniciar sesión segura e inicializar carrito
iniciar_sesion_segura();
inicializar_carrito();

$viajesEncontrados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar valores recibidos
    $nombreHotel = isset($_POST['nombreHotel']) ? filtro($_POST['nombreHotel']) : '';
    $ciudad = isset($_POST['ciudad']) ? filtro($_POST['ciudad']) : '';
    $pais = isset($_POST['pais']) ? filtro($_POST['pais']) : '';
    $fechaViaje = isset($_POST['fechaViaje']) ? filtro($_POST['fechaViaje']) : '';
    $duracionViaje = isset($_POST['duracionViaje']) ? filtro($_POST['duracionViaje']) : '';

    // Crear el filtro y buscar viajes
    $filtro = new FiltroViaje(null, $nombreHotel, $ciudad, $pais, $fechaViaje, $duracionViaje, null);
    $viajesEncontrados = $filtro->buscarViajes($conn);

    // Agregar al carrito si se solicita
    if (isset($_POST['agregar_al_carrito'])) {
        $viajeId = $_POST['viaje_id'];
        if (isset($viajesEncontrados[$viajeId])) {
            $viaje = $viajesEncontrados[$viajeId];
            agregarPaquete($viaje['id'], $viaje['nombre_hotel'] . ' - ' . $viaje['ciudad'] . ', ' . $viaje['pais'], $viaje['precio']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Resultados de Búsqueda</h1>
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
            <h2>Viajes Encontrados:</h2>
            <?php if (count($viajesEncontrados) > 0): ?>
                <?php foreach ($viajesEncontrados as $index => $viaje): ?>
                    <div class="viaje">
                        <h3><?php echo htmlspecialchars($viaje['nombre_hotel']); ?></h3>
                        <p>Ciudad: <?php echo htmlspecialchars($viaje['ciudad']); ?></p>
                        <p>País: <?php echo htmlspecialchars($viaje['pais']); ?></p>
                        <p>Fecha: <?php echo htmlspecialchars($viaje['fecha_viaje']); ?></p>
                        <p>Duración: <?php echo htmlspecialchars($viaje['duracion_viaje']); ?> días</p>
                        <p>Precio: $<?php echo number_format($viaje['precio'], 2); ?></p>
                        <form method="post">
                            <input type="hidden" name="viaje_id" value="<?php echo $index; ?>">
                            <button type="submit" name="agregar_al_carrito">Agregar al Carrito</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron viajes que coincidan con los criterios de búsqueda.</p>
            <?php endif; ?>
        </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

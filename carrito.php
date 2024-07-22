<?php
include 'includes/functions.php';
include 'FiltroViaje.php';
iniciar_sesion_segura();
inicializar_carrito();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actualizar'])) {
        foreach ($_POST['cantidad'] as $id => $cantidad) {
            if ($cantidad > 0) {
                $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
            } else {
                unset($_SESSION['carrito'][$id]);
            }
        }
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar'];
        unset($_SESSION['carrito'][$id]);
    }
}

$total = calcular_total_carrito();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
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
        <h2>Tu Carrito</h2>
        <?php if (empty($_SESSION['carrito'])): ?>
            <p>El carrito está vacío</p>
        <?php else: ?>
            <form method="post" action="carrito.php">
                <table class="carrito-tabla">
                    <thead>
                        <tr>
                            <th>Paquete</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td>$<?php echo number_format($item['precio'], 2); ?></td>
                            <td>
                                <input type="number" name="cantidad[<?php echo $id; ?>]" value="<?php echo $item['cantidad']; ?>" min="1">
                            </td>
                            <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                            <td>
                                <button type="submit" name="eliminar" value="<?php echo $id; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="carrito-total">Total: $<?php echo number_format($total, 2); ?></p>
                <button type="submit" name="actualizar">Actualizar Carrito</button>
            </form>
            <a href="procesar_compra.php" class="boton-comprar">Proceder al Pago</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
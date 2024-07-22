<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Agencia de Viajes</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
    </header>
    <nav>
        <ul>
            <li><a href="agregar_viaje.php">Agregar Viaje</a></li>
            <li><a href="agregar_oferta.php">Agregar Oferta</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <main>
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
        <p>Selecciona una opción del menú para administrar los viajes y ofertas.</p>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
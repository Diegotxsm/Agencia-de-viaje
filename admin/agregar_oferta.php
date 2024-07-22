<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = filtro($_POST['titulo']);
    $descripcion = filtro($_POST['descripcion']);
    $descuento = filtro($_POST['descuento']);
    $fecha_inicio = filtro($_POST['fecha_inicio']);
    $fecha_fin = filtro($_POST['fecha_fin']);

    $sql = "INSERT INTO ofertas (titulo, descripcion, descuento, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $titulo, $descripcion, $descuento, $fecha_inicio, $fecha_fin);

    if ($stmt->execute()) {
        $mensaje = "Oferta agregada con éxito.";
    } else {
        $mensaje = "Error al agregar la oferta: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Oferta - Agencia de Viajes</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Agregar Nueva Oferta</h1>
    </header>
    <main>
        <?php
        if (isset($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
        <form action="agregar_oferta.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="descuento">Descuento (%):</label>
            <input type="number" id="descuento" name="descuento" required>

            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <input type="submit" value="Agregar Oferta">
            <a href="admin_panel.php" class="back-button">Volver</a>
        </form>
    </main>
    
    <footer>
        <p>&copy; 2024 Agencia de Viajes. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
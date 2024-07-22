<?php
include 'includes/db_connect.php';
include 'includes/functions.php';

iniciar_sesion_segura();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = filtro($_POST['nombre']);
    $ubicacion = filtro($_POST['ubicacion']);
    $habitaciones = filtro($_POST['habitaciones']);
    $tarifa = filtro($_POST['tarifa']);

    $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $nombre, $ubicacion, $habitaciones, $tarifa);

    if ($stmt->execute()) {
        echo "Hotel registrado con éxito";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
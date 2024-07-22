<?php
include 'includes/db_connect.php';
include 'includes/functions.php';

iniciar_sesion_segura();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = filtro($_POST['origen']);
    $destino = filtro($_POST['destino']);
    $fecha = filtro($_POST['fecha']);
    $plazas = filtro($_POST['plazas']);
    $precio = filtro($_POST['precio']);

    $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssid", $origen, $destino, $fecha, $plazas, $precio);

    if ($stmt->execute()) {
        echo "Vuelo registrado con éxito";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
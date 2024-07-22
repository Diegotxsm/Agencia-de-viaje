<?php
include_once 'db_connect.php';

function obtenerOfertasActuales() {
    global $conn;
    $sql = "SELECT * FROM ofertas ORDER BY RAND() LIMIT 3";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


function mostrarOfertasEspeciales() {
    $ofertas = obtenerOfertasActuales();
    if (count($ofertas) > 0) {
        echo "<div id='ofertasEspeciales' class='ofertas-popup'>";
        echo "<h3>¡Ofertas Especiales!</h3>";
        foreach ($ofertas as $oferta) {
            echo "<div class='oferta-especial'>";
            echo "<h4>{$oferta['titulo']}</h4>";
            echo "<p>{$oferta['descripcion']}</p>";
            echo "<p class='descuento'>¡{$oferta['descuento']}% de descuento!</p>";
            echo "</div>";
        }
        echo "<button onclick='cerrarOfertas()'>Cerrar</button>";
        echo "</div>";
        
        // Script para mostrar y cerrar las ofertas
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('ofertasEspeciales').style.display = 'block';
            });
            function cerrarOfertas() {
                document.getElementById('ofertasEspeciales').style.display = 'none';
            }
        </script>";
    }
}

function filtro($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}
// Nuevas funciones de seguridad
function iniciar_sesion_segura() {
    // Verificar si la sesión no está ya iniciada
    if (session_status() == PHP_SESSION_NONE) {
        ini_set('session.gc_maxlifetime', 3600); // 1 hora
        session_set_cookie_params([
            'lifetime' => 3600,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();

        if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] > 300) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    } else {
        // La sesión ya está activa, solo regeneramos el ID si ha pasado el tiempo
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['last_activity'] = time();
        }
    }

    $_SESSION['last_activity'] = time();
}

function sanitize_session_data($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize_session_data($value);
        }
    } else {
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

function mostrar_resumen_carrito() {
    if (isset($_SESSION['carrito'])) {
        $total = calcular_total_carrito();
        $cantidad = count($_SESSION['carrito']);
        echo "<div class='carrito-resumen'>";
        echo "<p>Carrito: $cantidad item(s) - Total: $$total</p>";
        echo "<a href='carrito.php'>Ver Carrito</a>";
        echo "</div>";
    } else {
        echo "<div class='carrito-resumen'>";
        echo "<p>Carrito vacío</p>";
        echo "</div>";
    }
}

// Funciones del carrito
function inicializar_carrito() {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
}
function agregarPaquete($id, $nombre, $precio) {
    if (!isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] = [
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => 1
        ];
    } else {
        $_SESSION['carrito'][$id]['cantidad']++;
    }
}

function eliminarPaquete($id) {
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }
}

function calcular_total_carrito() {
    $total = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
    }
    return $total;
}
function guardar_preferencias_busqueda($destino, $fecha_inicio, $duracion) {
    $_SESSION['ultima_busqueda'] = [
        'destino' => $destino,
        'fecha_inicio' => $fecha_inicio,
        'duracion' => $duracion
    ];
}
function obtener_hoteles($conn) {
    $sql = "SELECT DISTINCT nombre_hotel FROM viajes ORDER BY nombre_hotel";
    $result = $conn->query($sql);
    $hoteles = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $hoteles[] = $row['nombre_hotel'];
        }
    }
    return $hoteles;
}
function obtener_ciudades($conn) {
    $sql = "SELECT DISTINCT ciudad FROM viajes ORDER BY ciudad";
    $result = $conn->query($sql);
    $ciudades = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ciudades[] = $row['ciudad'];
        }
    }
    return $ciudades;
}

function obtener_paises($conn) {
    $sql = "SELECT DISTINCT pais FROM viajes ORDER BY pais";
    $result = $conn->query($sql);
    $paises = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $paises[] = $row['pais'];
        }
    }
    return $paises;
}

function obtener_fechas_disponibles($conn) {
    $sql = "SELECT DISTINCT fecha_viaje FROM viajes WHERE fecha_viaje >= CURDATE() ORDER BY fecha_viaje";
    $result = $conn->query($sql);
    $fechas = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $fechas[] = $row['fecha_viaje'];
        }
    }
    return $fechas;
}

function obtener_duraciones_disponibles($conn) {
    $sql = "SELECT DISTINCT duracion_viaje FROM viajes ORDER BY duracion_viaje";
    $result = $conn->query($sql);
    $duraciones = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $duraciones[] = $row['duracion_viaje'];
        }
    }
    return $duraciones;
}
?>
<?php

class FiltroViaje {
    private $id;
    private $nombreHotel;
    private $ciudad;
    private $pais;
    private $fechaViaje;
    private $duracionViaje;
    private $precio;

    public function __construct($id, $nombreHotel, $ciudad, $pais, $fechaViaje, $duracionViaje, $precio) {
        $this->id = $id;
        $this->nombreHotel = $nombreHotel;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->fechaViaje = $fechaViaje;
        $this->duracionViaje = $duracionViaje;
        $this->precio = $precio;
    }


    public function getNombreHotel() {
        return $this->nombreHotel;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getFechaViaje() {
        return $this->fechaViaje;
    }

    public function getDuracionViaje() {
        return $this->duracionViaje;
    }

    public function getId() {
        return $this->id;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getInfoCarrito() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombreHotel . ' - ' . $this->ciudad . ', ' . $this->pais,
            'precio' => $this->precio
        ];
    }
    public function buscarViajes($conn) {
        $sql = "SELECT * FROM viajes WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($this->nombreHotel)) {
            $sql .= " AND nombre_hotel LIKE ?";
            $params[] = "%".$this->nombreHotel."%";
            $types .= "s";
        }
        if (!empty($this->ciudad)) {
            $sql .= " AND ciudad = ?";
            $params[] = $this->ciudad;
            $types .= "s";
        }
        if (!empty($this->pais)) {
            $sql .= " AND pais = ?";
            $params[] = $this->pais;
            $types .= "s";
        }
        if (!empty($this->fechaViaje)) {
            $sql .= " AND fecha_viaje = ?";
            $params[] = $this->fechaViaje;
            $types .= "s";
        }
        if (!empty($this->duracionViaje)) {
            $sql .= " AND duracion_viaje = ?";
            $params[] = $this->duracionViaje;
            $types .= "i";
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
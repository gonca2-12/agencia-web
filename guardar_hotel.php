<?php
require 'conexion.php';

function agregarHotel($id_hotel, $nombre, $ubicacion, $habitaciones_disponibles, $tarifa_noche, $id_vuelo) {
    try {
        $pdo = conectar();
        $sql = "INSERT INTO hotel (id_hotel, nombre, ubicacion, habitaciones_disponibles, tarifa_noche, id_vuelo) VALUES (:id_hotel, :nombre, :ubicacion, :habitaciones_disponibles, :tarifa_noche, :id_vuelo)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':id_hotel' => $id_hotel,
            ':nombre' => $nombre,
            ':ubicacion' => $ubicacion,
            ':habitaciones_disponibles' => $habitaciones_disponibles,
            ':tarifa_noche' => $tarifa_noche,
            ':id_vuelo' => $id_vuelo
        ]);
        
        echo "Hotel agregado exitosamente.";
    } catch (Exception $e) {
        echo "Error al agregar el hotel: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_hotel = $_POST['id_hotel'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
    $tarifa_noche = $_POST['tarifa_noche'];
    $id_vuelo = $_POST['id_vuelo'];
    
    agregarHotel($id_hotel, $nombre, $ubicacion, $habitaciones_disponibles, $tarifa_noche, $id_vuelo);
}
?>

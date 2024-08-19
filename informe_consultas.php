<?php
include 'conexion.php';

$conn = conectar(); // Conexión a la base de datos

try {
    // Realizar la consulta a la tabla de vuelos
    $sql = "SELECT id_vuelo, origen, destino, fecha, asientos_disponibles, precio FROM vuelos";
    $stmt = $conn->query($sql);
    $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Realizar la consulta a la tabla de hoteles
    $sql_hoteles = "SELECT id_hotel, nombre, ubicacion, habitaciones_disponibles, tarifa_por_noche FROM hoteles";
    $stmt_hoteles = $conn->query($sql_hoteles);
    $hoteles = $stmt_hoteles->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Vuelos Registrados:</h2>";
    foreach ($vuelos as $vuelo) {
        echo "ID Vuelo: " . $vuelo['id_vuelo'] . "<br>";
        echo "Origen: " . $vuelo['origen'] . "<br>";
        echo "Destino: " . $vuelo['destino'] . "<br>";
        echo "Fecha: " . $vuelo['fecha'] . "<br>";
        echo "Asientos Disponibles: " . $vuelo['asientos_disponibles'] . "<br>";
        echo "Precio: " . $vuelo['precio'] . "<br><br>";
    }

    echo "<h2>Hoteles Registrados:</h2>";
    foreach ($hoteles as $hotel) {
        echo "ID Hotel: " . $hotel['id_hotel'] . "<br>";
        echo "Nombre: " . $hotel['nombre'] . "<br>";
        echo "Ubicación: " . $hotel['ubicacion'] . "<br>";
        echo "Habitaciones Disponibles: " . $hotel['habitaciones_disponibles'] . "<br>";
        echo "Tarifa por Noche: " . $hotel['tarifa_por_noche'] . "<br><br>";
    }

} catch(PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

$conn = null; // Cerrar la conexión
?>

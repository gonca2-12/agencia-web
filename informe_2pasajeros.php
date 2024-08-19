<?php
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

$conn = conectar(); // Conexión a la base de datos

try {
    $sql = "
    SELECT 
        h.nombre AS nombre_hotel, 
        h.ubicacion AS ciudad, 
        COUNT(r.id_cliente) AS numero_pasajeros,
        r.fecha_ingreso,
        r.fecha_salida,
        c.nombre AS nombre_cliente
    FROM hoteles h
    JOIN reservas r ON h.id_hotel = r.id_hotel
    JOIN clientes c ON r.id_cliente = c.id_cliente
    GROUP BY h.id_hotel, r.fecha_ingreso, r.fecha_salida, c.nombre
    HAVING numero_pasajeros > 2
    ORDER BY h.nombre, r.fecha_ingreso;
    ";

    $stmt = $conn->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        echo "<h1>Hoteles con más de 2 personas hospedadas</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Hotel</th><th>Ciudad</th><th>Pasajeros</th><th>Fecha Ingreso</th><th>Fecha Salida</th><th>Nombre Cliente</th></tr>";
        foreach ($resultados as $fila) {
            echo "<tr>";
            echo "<td>{$fila['nombre_hotel']}</td>";
            echo "<td>{$fila['ciudad']}</td>";
            echo "<td>{$fila['numero_pasajeros']}</td>";
            echo "<td>{$fila['fecha_ingreso']}</td>";
            echo "<td>{$fila['fecha_salida']}</td>";
            echo "<td>{$fila['nombre_cliente']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron hoteles con más de 2 personas hospedadas.";
    }

} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

$conn = null; // Cerrar la conexión
?>

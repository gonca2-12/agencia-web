<?php
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

$conn = conectar(); // Conexión a la base de datos

try {
    // Eliminar todos los registros de las tablas
    $conn->exec("DELETE FROM reservas");
    $conn->exec("DELETE FROM vuelos");
    $conn->exec("DELETE FROM hoteles");
    $conn->exec("DELETE FROM clientes");
    
    // Opcionalmente, reiniciar los IDs autoincrementales
    $conn->exec("ALTER TABLE reservas AUTO_INCREMENT = 1");
    $conn->exec("ALTER TABLE vuelos AUTO_INCREMENT = 1");
    $conn->exec("ALTER TABLE hoteles AUTO_INCREMENT = 1");
    $conn->exec("ALTER TABLE clientes AUTO_INCREMENT = 1");

    echo "Base de datos reseteada exitosamente.";
} catch(PDOException $e) {
    echo "Error al resetear la base de datos: " . $e->getMessage();
}

$conn = null; // Cerrar la conexión
?>

<?php
include 'conexion.php';

try {
    $conexion = conectar();
    echo "Conexión exitosa";
} catch (Exception $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>

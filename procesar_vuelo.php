<?php
require 'conexion.php';

$codigo_vuelo = $_POST['codigo_vuelo'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$fecha = $_POST['fecha'];
$asientos_disponibles = $_POST['asientos_disponibles'];
$precio = $_POST['precio'];

$pdo = conectar();

$sql = "INSERT INTO vuelo (id_vuelo, origen, destino, fecha, asientos_disponibles, precio) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$codigo_vuelo, $origen, $destino, $fecha, $asientos_disponibles, $precio]);

header("Location: agregar_hotel.php?codigo_vuelo=$codigo_vuelo");
exit();
?>

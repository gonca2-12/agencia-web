<?php
session_start();
require 'conexion.php';

$codigo_reserva = isset($_GET['codigo_reserva']) ? $_GET['codigo_reserva'] : null;

if ($codigo_reserva) {
    $pdo = conectar();
    $stmt = $pdo->prepare("SELECT r.id_reserva, r.nombre_cliente, r.fecha_ingreso, r.fecha_salida, v.origen, v.destino, h.nombre_hotel, r.cantidad_pasajeros 
                           FROM reserva r
                           JOIN vuelo v ON r.id_vuelo = v.id_vuelo
                           JOIN hotel h ON r.id_hotel = h.id_hotel
                           WHERE r.id_reserva = :codigo_reserva");
    $stmt->execute(['codigo_reserva' => $codigo_reserva]);
    $reserva = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Reserva Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: purple;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalle de Reserva</h1>
        <?php if ($reserva): ?>
            <p>Código de la Reserva: <?php echo htmlspecialchars($reserva['id_reserva']); ?></p>
            <p>Nombre del Cliente: <?php echo htmlspecialchars($reserva['nombre_cliente']); ?></p>
            <p>Fecha de Ingreso: <?php echo htmlspecialchars($reserva['fecha_ingreso']); ?></p>
            <p>Fecha de Salida: <?php echo htmlspecialchars($reserva['fecha_salida']); ?></p>
            <p>Origen del Vuelo: <?php echo htmlspecialchars($reserva['origen']); ?></p>
            <p>Destino del Vuelo: <?php echo htmlspecialchars($reserva['destino']); ?></p>
            <p>Nombre del Hotel: <?php echo htmlspecialchars($reserva['nombre_hotel']); ?></p>
            <p>Cantidad de Pasajeros: <?php echo htmlspecialchars($reserva['cantidad_pasajeros']); ?></p>
        <?php else: ?>
            <p>No se encontró la reserva.</p>
        <?php endif; ?>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

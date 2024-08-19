<?php
include 'conectar.php';

$pdo = conectar(); // Conexión a la base de datos

try {
    // Consulta básica
    $query_basica = "SELECT v.origen, v.destino, h.nombre as hotel, h.ubicacion, r.fecha_ingreso, r.fecha_salida, v.asientos_disponibles as pasajeros
                     FROM reservas r
                     JOIN vuelos v ON r.id_vuelo = v.id_vuelo
                     JOIN hoteles h ON r.id_hotel = h.id_hotel";
    
    $stmt_basica = $pdo->query($query_basica);
    $result_basica = $stmt_basica->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta avanzada
    $query_avanzada = "SELECT h.nombre as hotel, SUM(v.asientos_disponibles) as pasajeros
                       FROM reservas r
                       JOIN hoteles h ON r.id_hotel = h.id_hotel
                       JOIN vuelos v ON r.id_vuelo = v.id_vuelo
                       GROUP BY h.nombre
                       HAVING pasajeros > 2";
    
    $stmt_avanzada = $pdo->query($query_avanzada);
    $result_avanzada = $stmt_avanzada->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al realizar la consulta: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas de Vuelos y Hoteles</title>
    <style>
        /* Estilo para el contenedor principal */
        .container {
            width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        /* Estilo para las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Estilo para enlaces */
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultas de Vuelos y Hoteles</h1>

        <div class="consulta-basica">
            <h2>Consultas Básicas</h2>
            <?php if (count($result_basica) > 0): ?>
            <table>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Hotel</th>
                    <th>Ubicación</th>
                    <th>Fecha Ingreso</th>
                    <th>Fecha Salida</th>
                    <th>Pasajeros</th>
                </tr>
                <?php foreach($result_basica as $row): ?>
                <tr>
                    <td><?php echo $row['origen']; ?></td>
                    <td><?php echo $row['destino']; ?></td>
                    <td><?php echo $row['hotel']; ?></td>
                    <td><?php echo $row['ubicacion']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td><?php echo $row['fecha_salida']; ?></td>
                    <td><?php echo $row['pasajeros']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>No hay resultados disponibles para las consultas básicas.</p>
            <?php endif; ?>
        </div>

        <div class="consulta-avanzada">
            <h2>Consultas Avanzadas</h2>
            <?php if (count($result_avanzada) > 0): ?>
            <table>
                <tr>
                    <th>Hotel</th>
                    <th>Pasajeros</th>
                </tr>
                <?php foreach($result_avanzada as $row): ?>
                <tr>
                    <td><?php echo $row['hotel']; ?></td>
                    <td><?php echo $row['pasajeros']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>No hay resultados disponibles para las consultas avanzadas.</p>
            <?php endif; ?>
        </div>

        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

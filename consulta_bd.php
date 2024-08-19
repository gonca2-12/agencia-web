<?php
include 'conexion.php';

// Consulta Básica
$sql_basica = "SELECT h.nombre AS Hotel, r.fecha_ingreso AS 'Fecha Ingreso', SUM(r.num_asientos) AS 'Cantidad de Pasajeros'
    FROM reservas r
    JOIN hoteles h ON r.id_hotel = h.id_hotel
    GROUP BY h.nombre, r.fecha_ingreso
    ORDER BY h.nombre, r.fecha_ingreso";
$stmt_basica = $pdo->prepare($sql_basica);
$stmt_basica->execute();
$resultados_basica = $stmt_basica->fetchAll(PDO::FETCH_ASSOC);

// Consulta Avanzada
$sql_avanzada = "SELECT h.nombre AS Hotel, SUM(r.num_asientos) AS 'Número de Pasajeros'
    FROM reservas r
    JOIN hoteles h ON r.id_hotel = h.id_hotel
    GROUP BY h.nombre
    HAVING SUM(r.num_asientos) > 2
    ORDER BY SUM(r.num_asientos) DESC
    LIMIT 10";
$stmt_avanzada = $pdo->prepare($sql_avanzada);
$stmt_avanzada->execute();
$resultados_avanzada = $stmt_avanzada->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Consulta Básica</h2>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Fecha Ingreso</th>
                    <th>Cantidad de Pasajeros</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados_basica as $fila): ?>
                    <tr>
                        <td><?= $fila['Hotel'] ?></td>
                        <td><?= $fila['Fecha Ingreso'] ?></td>
                        <td><?= $fila['Cantidad de Pasajeros'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Consulta Avanzada</h2>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Número de Pasajeros</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($resultados_avanzada)): ?>
                    <?php foreach ($resultados_avanzada as $fila): ?>
                        <tr>
                            <td><?= $fila['Hotel'] ?></td>
                            <td><?= $fila['Número de Pasajeros'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="menu_principal.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

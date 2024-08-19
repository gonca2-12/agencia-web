<?php
session_start();

// Conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=agencia';
$username = 'root';
$password = '';
$options = [];

try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Consulta 1: Total de vuelos realizados
$query1 = "SELECT COUNT(*) AS total_vuelos FROM vuelo";
$statement1 = $connection->prepare($query1);
$statement1->execute();
$total_vuelos = $statement1->fetch(PDO::FETCH_ASSOC);

// Consulta 2: Origen, destino y hoteles
$query2 = "
    SELECT 
        r.id_reserva,
        r.nombre_cliente,
        v.origen,
        v.destino,
        h.nombre AS nombre_hotel,
        h.ubicacion,
        r.fecha_ingreso,
        r.fecha_salida,
        r.id_vuelo,
        r.id_hotel
    FROM 
        reserva r
    LEFT JOIN 
        vuelo v ON r.id_vuelo = v.id_vuelo
    LEFT JOIN 
        hotel h ON r.id_hotel = h.id_hotel
";
$statement2 = $connection->prepare($query2);
$statement2->execute();
$detalles_reservas = $statement2->fetchAll(PDO::FETCH_ASSOC);

// Consulta 3: Hoteles con más de 2 reservas y los vuelos asociados
$query3 = "
    SELECT 
        r.id_hotel,
        h.nombre AS nombre_hotel,
        COUNT(r.id_hotel) AS total_reservas,
        GROUP_CONCAT(r.id_vuelo) AS vuelos_asociados
    FROM 
        reserva r
    LEFT JOIN 
        hotel h ON r.id_hotel = h.id_hotel
    GROUP BY 
        r.id_hotel
    HAVING 
        COUNT(r.id_hotel) > 2
";
$statement3 = $connection->prepare($query3);
$statement3->execute();
$hoteles_mas_de_dos_reservas = $statement3->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta BD</title>
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
            width: 800px;
            overflow-y: auto;
            max-height: 90vh;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
        <h1>Consulta BD</h1>

        <h2>Total de Vuelos Realizados</h2>
        <p>Total: <?php echo $total_vuelos['total_vuelos']; ?></p>

        <h2>Detalles de Reservas</h2>
        <table>
            <tr>
                <th>ID Reserva</th>
                <th>Nombre Cliente</th>
                <th>Origen Vuelo</th>
                <th>Destino Vuelo</th>
                <th>Nombre Hotel</th>
                <th>Ubicación Hotel</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
                <th>Código Vuelo</th>
                <th>Código Hotel</th>
            </tr>
            <?php foreach ($detalles_reservas as $reserva): ?>
            <tr>
                <td><?php echo $reserva['id_reserva']; ?></td>
                <td><?php echo $reserva['nombre_cliente']; ?></td>
                <td><?php echo $reserva['origen']; ?></td>
                <td><?php echo $reserva['destino']; ?></td>
                <td><?php echo $reserva['nombre_hotel']; ?></td>
                <td><?php echo $reserva['ubicacion']; ?></td>
                <td><?php echo $reserva['fecha_ingreso']; ?></td>
                <td><?php echo $reserva['fecha_salida']; ?></td>
                <td><?php echo $reserva['id_vuelo']; ?></td>
                <td><?php echo $reserva['id_hotel']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h2>Hoteles con más de 2 Reservas y Vuelos Asociados</h2>
        <table>
            <tr>
                <th>ID Hotel</th>
                <th>Nombre Hotel</th>
                <th>Total Reservas</th>
                <th>Vuelos Asociados</th>
            </tr>
            <?php foreach ($hoteles_mas_de_dos_reservas as $hotel): ?>
            <tr>
                <td><?php echo $hotel['id_hotel']; ?></td>
                <td><?php echo $hotel['nombre_hotel']; ?></td>
                <td><?php echo $hotel['total_reservas']; ?></td>
                <td><?php echo $hotel['vuelos_asociados']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

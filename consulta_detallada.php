<?php
function conectar() {
    $host = '127.0.0.1';
    $db = 'agencia';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

$connection = conectar();

// Consulta 1: Total de vuelos realizados
$query1 = "SELECT COUNT(*) AS total_vuelos FROM vuelo";
$statement1 = $connection->prepare($query1);
$statement1->execute();
$total_vuelos = $statement1->fetch(PDO::FETCH_ASSOC);

// Consulta 2: Origen, destino y hoteles
$query2 = "
    SELECT 
        v.origen,
        v.destino,
        h.nombre AS nombre_hotel,
        h.ubicacion,
        r.nombre_cliente,
        r.fecha_ingreso,
        r.fecha_salida,
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

// Consulta 3: Hoteles con más de 2 pasajeros
$query3 = "
    SELECT 
        h.id_hotel AS id,
        h.nombre AS nombre_hotel,
        COUNT(r.nombre_cliente) AS total_pasajeros
    FROM 
        reserva r
    LEFT JOIN 
        hotel h ON r.id_hotel = h.id_hotel
    GROUP BY 
        h.id_hotel, h.nombre
    HAVING 
        COUNT(r.nombre_cliente) > 2
";
$statement3 = $connection->prepare($query3);
$statement3->execute();
$hoteles_mas_de_dos = $statement3->fetchAll(PDO::FETCH_ASSOC);
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
            width: 90%;
            max-width: 1000px;
        }
        h1, h2 {
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
                <th>Nombre Cliente</th>
                <th>Origen Vuelo</th>
                <th>Destino Vuelo</th>
                <th>Nombre Hotel</th>
                <th>Ubicación Hotel</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
                <th>Código Hotel</th>
            </tr>
            <?php foreach ($detalles_reservas as $reserva): ?>
            <tr>
                <td><?php echo $reserva['nombre_cliente']; ?></td>
                <td><?php echo $reserva['origen']; ?></td>
                <td><?php echo $reserva['destino']; ?></td>
                <td><?php echo $reserva['nombre_hotel']; ?></td>
                <td><?php echo $reserva['ubicacion']; ?></td>
                <td><?php echo $reserva['fecha_ingreso']; ?></td>
                <td><?php echo $reserva['fecha_salida']; ?></td>
                <td><?php echo $reserva['id_hotel']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h2>Hoteles con más de 2 Pasajeros</h2>
        <table>
            <tr>
                <th>Nombre del Hotel</th>
                <th>ID Hotel</th>
                <th>Total Pasajeros</th>
            </tr>
            <?php foreach ($hoteles_mas_de_dos as $hotel): ?>
            <tr>
                <td><?php echo $hotel['nombre_hotel']; ?></td>
                <td><?php echo $hotel['id']; ?></td>
                <td><?php echo $hotel['total_pasajeros']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

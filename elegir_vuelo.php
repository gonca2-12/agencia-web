<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Establecer la conexión
$pdo = conectar();

// Consultar los vuelos desde la base de datos
$sql = "SELECT id_vuelo, origen, destino, fecha, asientos_disponibles, precio FROM vuelos";
$stmt = $pdo->query($sql);
$vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Elegir Vuelo</title>
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
            width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .vuelo {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Elegir Vuelo</h1>
        <?php foreach ($vuelos as $vuelo): ?>
            <div class="vuelo">
                <p>Origen: <?= $vuelo['origen'] ?></p>
                <p>Destino: <?= $vuelo['destino'] ?></p>
                <p>Fecha: <?= $vuelo['fecha'] ?></p>
                <p>Asientos disponibles: <?= $vuelo['asientos_disponibles'] ?></p>
                <p>Precio: <?= $vuelo['precio'] ?></p>
                <button onclick="seleccionarVuelo('<?= $vuelo['id_vuelo'] ?>')">Seleccionar</button>
            </div>
        <?php endforeach; ?>
        <a href="index.php">Volver al Menú Principal</a>
    </div>

    <form id="formVuelo" method="post" action="elegir_hotel.php">
        <input type="hidden" name="id_vuelo" id="idVueloSeleccionado">
    </form>

    <script>
        function seleccionarVuelo(idVuelo) {
            document.getElementById('idVueloSeleccionado').value = idVuelo;
            document.getElementById('formVuelo').submit();
        }
    </script>
</body>
</html>

<?php
require 'conexion.php'; // Incluir el archivo de conexión

$pdo = conectar(); // Establecer la conexión y asignarla a la variable $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha = $_POST['fecha'];
    $num_asientos = $_POST['num_asientos'];  // Cambio aquí
    $precio = $_POST['precio'];

    // Generar un ID de vuelo único
    $sql_max_id = "SELECT MAX(CAST(SUBSTRING(id_vuelo, 2) AS UNSIGNED)) AS max_id FROM vuelos";
    $stmt_max_id = $pdo->query($sql_max_id);
    $max_id_row = $stmt_max_id->fetch(PDO::FETCH_ASSOC);
    $new_id_number = $max_id_row['max_id'] + 1;
    $new_id = "V" . str_pad($new_id_number, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO vuelos (id_vuelo, origen, destino, fecha, asientos_disponibles, precio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_id, $origen, $destino, $fecha, $num_asientos, $precio]); // Cambio aquí

    // Redirigir a la página de agregar hotel después de agregar un vuelo
    header("Location: agregar_hotel.php?id_vuelo=$new_id");
    exit(); // Asegurarse de que el script termine después de la redirección
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Agregar Vuelo</title>
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
            width: 600px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label, input {
            margin: 5px 0;
            width: 100%;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Vuelo</h1>
        <form action="agregar_vuelo.php" method="post">
            <label for="origen">Origen:</label>
            <input type="text" id="origen" name="origen" required>

            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="num_asientos">Número de Asientos:</label>
            <input type="number" id="num_asientos" name="num_asientos" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" required>

            <button type="submit">Agregar Vuelo</button>
        </form>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

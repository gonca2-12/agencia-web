<?php
require 'conexion.php';

$pdo = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $tarifa = $_POST['tarifa'];
    $id_vuelo = $_POST['id_vuelo'];

    // Verificar que el ID del vuelo exista en la base de datos
    $sql_verificar = "SELECT COUNT(*) FROM vuelos WHERE id_vuelo = ?";
    $stmt_verificar = $pdo->prepare($sql_verificar);
    $stmt_verificar->execute([$id_vuelo]);

    if ($stmt_verificar->fetchColumn() > 0) {
        // Generar un ID de hotel único
        $sql_max_id = "SELECT MAX(CAST(SUBSTRING(id_hotel, 2) AS UNSIGNED)) AS max_id FROM hoteles";
        $stmt_max_id = $pdo->query($sql_max_id);
        $max_id_row = $stmt_max_id->fetch(PDO::FETCH_ASSOC);
        $new_id_number = $max_id_row['max_id'] + 1;
        $new_id = "H" . str_pad($new_id_number, 4, "0", STR_PAD_LEFT);

        $sql = "INSERT INTO hoteles (id_hotel, nombre, ubicacion, habitaciones_disponibles, tarifa_noche, id_vuelo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_id, $nombre, $ubicacion, $habitaciones, $tarifa, $id_vuelo]);

        $mensaje = "Hotel agregado exitosamente con ID: $new_id";
        header("Location: gestionar_reserva.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        $error = "Error: El ID del vuelo no existe en la base de datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Hotel</title>
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
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 10px;
            display: block;
            text-align: left;
        }

        input[type="text"],
        input[type="number"],
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
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

        .mensaje {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

        .error {
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Hotel</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form action="agregar_hotel.php" method="post">
            <label for="nombre">Nombre del Hotel:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required>

            <label for="habitaciones">Habitaciones Disponibles:</label>
            <input type="number" id="habitaciones" name="habitaciones" required>

            <label for="tarifa">Tarifa por Noche:</label>
            <input type="number" id="tarifa" name="tarifa" required>

            <label for="id_vuelo">ID del Vuelo Asociado:</label>
            <select id="id_vuelo" name="id_vuelo" required>
                <?php
                $sql_vuelos = "SELECT id_vuelo FROM vuelos";
                foreach ($pdo->query($sql_vuelos) as $vuelo) {
                    echo "<option value='{$vuelo['id_vuelo']}'>{$vuelo['id_vuelo']}</option>";
                }
                ?>
            </select>

            <button type="submit">Agregar Hotel</button>
        </form>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

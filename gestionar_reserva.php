<?php
require 'conexion.php'; // Incluir el archivo de conexión

$pdo = conectar(); // Establecer la conexión y asignarla a la variable $pdo

// Obtener el último vuelo registrado
$stmt_vuelo = $pdo->query("SELECT id_vuelo FROM vuelos ORDER BY id_vuelo DESC LIMIT 1");
$vuelo = $stmt_vuelo->fetch(PDO::FETCH_ASSOC);

// Obtener el último hotel registrado
$stmt_hotel = $pdo->query("SELECT id_hotel FROM hoteles ORDER BY id_hotel DESC LIMIT 1");
$hotel = $stmt_hotel->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    $id_vuelo = $vuelo['id_vuelo'] ?? null;
    $id_hotel = $hotel['id_hotel'] ?? null;

    if ($id_vuelo === null || $id_hotel === null) {
        $message = "Error: Debes registrar al menos un vuelo y un hotel antes de poder hacer una reserva.";
    } else {
        $sql = "INSERT INTO reservas (nombre_cliente, fecha_ingreso, fecha_salida, id_vuelo, id_hotel) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre_cliente, $fecha_ingreso, $fecha_salida, $id_vuelo, $id_hotel]);

        $message = "Reserva agregada exitosamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Reserva</title>
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

        label {
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestionar Reserva</h1>
        <?php if (isset($message)): ?>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="index.php">Volver al Menú Principal</a>
        <?php else: ?>
        <form action="gestionar_reserva.php" method="post">
            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" required>

            <label for="fecha_ingreso">Fecha de Ingreso:</label>
            <input type="date" id="fecha_ingreso" name="fecha_ingreso" required>

            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" id="fecha_salida" name="fecha_salida" required>

            <label for="id_vuelo">Número de Vuelo:</label>
            <input type="text" id="id_vuelo" name="id_vuelo" value="<?= htmlspecialchars($vuelo['id_vuelo'] ?? 'No hay vuelos registrados') ?>" readonly>

            <label for="id_hotel">Hotel:</label>
            <input type="text" id="id_hotel" name="id_hotel" value="<?= htmlspecialchars($hotel['id_hotel'] ?? 'No hay hoteles registrados') ?>" readonly>

            <button type="submit">Agregar Reserva</button>
            <a href="index.php" class="btn btn-secondary" style="display: block; margin-top: 20px;">Volver al Menú Principal</a>

        </form>
        <?php endif; ?>
    </div>
</body>
</html>

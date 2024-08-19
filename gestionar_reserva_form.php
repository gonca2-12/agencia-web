<?php
require 'conexion.php';
$pdo = conectar();

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
    $id_vuelo = $_POST['id_vuelo'];
    $id_hotel = $_POST['id_hotel'];

    try {
        // Verificar que el vuelo y el hotel existen
        $stmt_verificar_vuelo = $pdo->prepare("SELECT id_vuelo FROM vuelos WHERE id_vuelo = ?");
        $stmt_verificar_vuelo->execute([$id_vuelo]);

        $stmt_verificar_hotel = $pdo->prepare("SELECT id_hotel FROM hoteles WHERE id_hotel = ?");
        $stmt_verificar_hotel->execute([$id_hotel]);

        if ($stmt_verificar_vuelo->rowCount() > 0 && $stmt_verificar_hotel->rowCount() > 0) {
            // Insertar la reserva si el vuelo y el hotel existen
            $sql = "INSERT INTO reservas (nombre_cliente, fecha_ingreso, fecha_salida, id_vuelo, id_hotel) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre_cliente, $fecha_ingreso, $fecha_salida, $id_vuelo, $id_hotel]);

            $message = "Reserva agregada exitosamente.";
        } else {
            $message = "Error: El vuelo o el hotel asociados no existen.";
        }
    } catch (PDOException $e) {
        $message = "Error al agregar la reserva: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Reserva</title>
    <style>
        body { ... }
        /* Continúa con el mismo estilo CSS proporcionado */
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
        </form>
        <?php endif; ?>
    </div>
</body>
</html>

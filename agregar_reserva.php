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

$mensaje = '';
$codigo_vuelo = $_GET['codigo_vuelo'];
$codigo_hotel = $_GET['codigo_hotel'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];

    $connection = conectar();
    $stmt = $connection->prepare("INSERT INTO reserva (nombre_cliente, fecha_ingreso, fecha_salida, id_vuelo, id_hotel) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_cliente, $fecha_ingreso, $fecha_salida, $codigo_vuelo, $codigo_hotel]);

    $mensaje = 'Reserva agregada exitosamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione su Reserva</title>
    <!-- Estilos aquí -->
</head>
<body>
    <div class="container">
        <h1>Gestione su Reserva</h1>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form action="agregar_reserva.php?codigo_vuelo=<?php echo $codigo_vuelo; ?>&codigo_hotel=<?php echo $codigo_hotel; ?>" method="post">
            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" required>

            <label for="fecha_ingreso">Fecha de Ingreso:</label>
            <input type="date" id="fecha_ingreso" name="fecha_ingreso" required>

            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" id="fecha_salida" name="fecha_salida" required>

            <label for="id_vuelo">Número de Vuelo:</label>
            <input type="text" id="id_vuelo" name="id_vuelo" value="<?php echo $codigo_vuelo; ?>" readonly>

            <label for="id_hotel">Hotel:</label>
            <input type="text" id="id_hotel" name="id_hotel" value="<?php echo $codigo_hotel; ?>" readonly>

            <button type="submit">Agregar Reserva</button>
        </form>

        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

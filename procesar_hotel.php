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

$pdo = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_vuelo = $_POST['codigo_vuelo'];
    $codigo_hotel = $_POST['codigo_hotel'];
    $nombre_hotel = $_POST['nombre_hotel'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
    $tarifa_noche = $_POST['tarifa_noche'];

    $stmt = $pdo->prepare("INSERT INTO hotel (id_hotel, nombre, ubicacion, habitaciones_disponibles, tarifa_noche, id_vuelo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$codigo_hotel, $nombre_hotel, $ubicacion, $habitaciones_disponibles, $tarifa_noche, $codigo_vuelo]);

    echo "Hotel agregado exitosamente.";
    header("Location: agregar_reserva.php"); // Cambiar por la página que corresponda después de agregar el hotel
    exit();
}

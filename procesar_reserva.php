<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST['nombre_cliente'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    $num_asientos = $_POST['num_asientos'];  // Cambio aquí
    $codigo_vuelo = $_SESSION['codigo_vuelo'];
    $codigo_hotel = $_SESSION['codigo_hotel'];

    // Guardar los datos en la sesión
    $_SESSION['nombre_cliente'] = $nombre_cliente;
    $_SESSION['fecha_ingreso'] = $fecha_ingreso;
    $_SESSION['fecha_salida'] = $fecha_salida;

    // Conectar a la base de datos
    require 'conexion.php';
    $pdo = conectar();

    // Insertar la reserva en la base de datos
    $stmt = $pdo->prepare("INSERT INTO reservas (nombre_cliente, fecha_ingreso, fecha_salida, num_asientos, id_vuelo, id_hotel) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_cliente, $fecha_ingreso, $fecha_salida, $num_asientos, $codigo_vuelo, $codigo_hotel]);  // Cambio aquí

    // Obtener el ID de la reserva
    $id_reserva = $pdo->lastInsertId();

    // Redirigir a la página de gestión de la reserva con el ID de la reserva
    header("Location: gestionar_reserva.php?id_reserva=" . $id_reserva);
    exit();
}
?>

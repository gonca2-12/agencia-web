<?php
require 'conexion.php';

$pdo = conectar();

try {
    $pdo->exec("DELETE FROM vuelos");
    $pdo->exec("DELETE FROM hoteles");
    $pdo->exec("DELETE FROM reservas");
    echo "Memoria reseteada correctamente.";
} catch (PDOException $e) {
    echo "Error al resetear la memoria: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resetear Memoria</title>
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
        <p><?php echo $mensaje; ?></p>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

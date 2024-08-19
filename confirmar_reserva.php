<!-- confirmar_reserva.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
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
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 5px 0;
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
        <h1>Confirmar Reserva</h1>
        <?php
        require 'conexion.php';

        $id_reserva = $_GET['id_reserva'];
        $pdo = conectar();

        $sql = "SELECT * FROM reserva WHERE id_reserva = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_reserva]);
        $reserva = $stmt->fetch();
        ?>
        <p>Nombre: <?php echo $reserva['nombre']; ?></p>
        <p>Código del Vuelo: <?php echo $reserva['codigo_vuelo']; ?></p>
        <p>Código del Hotel: <?php echo $reserva['codigo_hotel']; ?></p>
        <p>Fecha de Ingreso: <?php echo $reserva['fecha_ingreso']; ?></p>
        <p>Fecha de Salida: <?php echo $reserva['fecha_salida']; ?></p>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

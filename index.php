<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agencia de Viajes</title>
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
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 18px;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agencia de Viajes</h1>
        <a href="agregar_vuelo.php" class="btn">Elija su Vuelo</a>
        <a href="agregar_hotel.php" class="btn">Elija su Hotel</a>
        <a href="gestionar_reserva.php" class="btn">Gestionar Reserva</a>
        <a href="consultas.php" class="btn">Consultas</a>
        <a href="resetear_bd.php" class="btn">Resetear Base de Datos</a>
    </div>
</body>
</html>

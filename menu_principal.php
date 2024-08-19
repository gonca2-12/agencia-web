<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            margin: 0 auto;
            text-align: center;
            padding-top: 50px;
        }
        a {
            display: block;
            margin: 20px 0;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Menú Principal</h1>
        <a href="agregar_vuelo.php">Agregar Vuelo</a>
        <a href="agregar_hotel.php">Agregar Hotel</a>
        <a href="gestionar_reserva.php">Gestionar Reserva</a>
        <a href="consulta_bd.php">Consultar Reservas</a>
        <a href="resetear_bd.php">Resetear Base de Datos</a>
    </div>
</body>
</html>

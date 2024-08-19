<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoteles con más de dos Reservas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agencia de Viajes</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="main-content">
            <h1>Hoteles con más de dos Reservas</h1>
            <?php
            require 'conexion.php';

            $sql = "SELECT h.id_hotel, h.nombre, h.ubicacion, COUNT(r.id_reserva) AS total_reservas 
                    FROM HOTEL h 
                    JOIN RESERVA r ON h.id_hotel = r.id_hotel 
                    GROUP BY h.id_hotel 
                    HAVING total_reservas > 2";
            $stmt = $pdo->query($sql);
            echo "<table border='1'>";
            echo "<tr><th>ID Hotel</th><th>Nombre</th><th>Ubicación</th><th>Total Reservas</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>" . $row['id_hotel'] . "</td><td>" . $row['nombre'] . "</td><td>" . $row['ubicacion'] . "</td><td>" . $row['total_reservas'] . "</td></tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <footer>
        <p>Agencia de Viajes &copy; 2024</p>
    </footer>
</body>
</html>

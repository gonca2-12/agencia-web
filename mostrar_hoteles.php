<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Hoteles</title>
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
            <h1>Listado de Hoteles</h1>
            <?php
            require 'conexion.php';

            $sql = "SELECT * FROM HOTEL";
            $stmt = $pdo->query($sql);
            echo "<table border='1'>";
            echo "<tr><th>ID Hotel</th><th>Nombre</th><th>Ubicación</th><th>Habitaciones Disponibles</th><th>Tarifa por Noche</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>" . $row['id_hotel'] . "</td><td>" . $row['nombre'] . "</td><td>" . $row['ubicacion'] . "</td><td>" . $row['habitaciones_disponibles'] . "</td><td>" . $row['tarifa_noche'] . "</td></tr>";
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


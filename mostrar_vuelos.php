<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Vuelos</title>
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
            <h1>Listado de Vuelos</h1>
            <?php
            require 'conexion.php';

            $sql = "SELECT * FROM VUELO";
            $stmt = $pdo->query($sql);
            echo "<table border='1'>";
            echo "<tr><th>ID Vuelo</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Asientos Disponibles</th><th>Precio</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>" . $row['id_vuelo'] . "</td><td>" . $row['origen'] . "</td><td>" . $row['destino'] . "</td><td>" . $row['fecha'] . "</td><td>" . $row['asientos_disponibles'] . "</td><td>" . $row['precio'] . "</td></tr>";
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

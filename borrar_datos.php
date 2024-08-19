<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql1 = "DELETE FROM RESERVA";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();

    $sql2 = "DELETE FROM VUELO";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();

    $sql3 = "DELETE FROM HOTEL";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute();

    $message = "Memoria reseteada exitosamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseteo de Memoria</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Reseteo de Memoria</h1>
        <?php if (isset($message)): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="reset_memoria.php" method="post">
            <button type="submit">Resetear Memoria</button>
        </form>
        <br>
        <a href="index.php">Volver al Menú Principal</a>
    </div>
</body>
</html>

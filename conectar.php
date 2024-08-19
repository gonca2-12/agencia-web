<?php
function conectar() {
    try {
        // Usar 'root' como usuario y dejar la contraseña vacía
        $pdo = new PDO('mysql:host=localhost;dbname=agencia', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit();
    }
}
?>

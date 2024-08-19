<?php
$idVuelo = $_POST['id_vuelo']; // Obtener el ID del vuelo seleccionado

// Suponiendo que tienes una lista de hoteles en un array $hoteles
$hoteles = [
    ['id_hotel' => 'H001', 'nombre' => 'Hotel 1', 'ubicacion' => 'Buenos Aires', 'habitaciones_disponibles' => 10, 'tarifa_noche' => 50000],
    ['id_hotel' => 'H002', 'nombre' => 'Hotel 2', 'ubicacion' => 'Lima', 'habitaciones_disponibles' => 8, 'tarifa_noche' => 40000],
    // Agrega más hoteles según sea necesario
];

foreach ($hoteles as $hotel) {
    echo '<div>';
    echo 'Nombre: ' . $hotel['nombre'] . '<br>';
    echo 'Ubicación: ' . $hotel['ubicacion'] . '<br>';
    echo 'Habitaciones disponibles: ' . $hotel['habitaciones_disponibles'] . '<br>';
    echo 'Tarifa por noche: ' . $hotel['tarifa_noche'] . '<br>';
    echo '<button onclick="seleccionarHotel(\'' . $hotel['id_hotel'] . '\')">Seleccionar</button>';
    echo '</div>';
}
?>
<form id="formHotel" method="post" action="gestionar_reserva.php">
    <input type="hidden" name="id_vuelo" value="<?php echo $idVuelo; ?>">
    <input type="hidden" name="id_hotel" id="idHotelSeleccionado">
</form>
<script>
function seleccionarHotel(idHotel) {
    document.getElementById('idHotelSeleccionado').value = idHotel;
    document.getElementById('formHotel').submit();
}
</script>

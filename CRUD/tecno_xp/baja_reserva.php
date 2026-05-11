<?php

include('conexion.php');
$conexion = conectar();

$cod_usuario = $_POST['cod_usuario'] ?? '';
$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';

if (empty($cod_usuario) || empty($cod_dispositivo) || empty($fecha_inicio)) {
    echo "<script>window.location='baja_reserva.html'</script>";
    exit();
}

$stmt = $conexion->prepare("DELETE FROM reservas WHERE cod_usuario = ? AND cod_dispositivo = ? AND fecha_inicio = ?");
$stmt->bind_param("sss", $cod_usuario, $cod_dispositivo, $fecha_inicio);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('RESERVA CANCELADA CORRECTAMENTE');
    window.location='baja_reserva.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL CANCELAR RESERVA');
    window.location='baja_reserva.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>

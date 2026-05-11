<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$nombre_dispositivo = $_POST['nombre_dispositivo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$estado = $_POST['estado'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='cambio_dispositivo.html'</script>";
    exit();
}

$stmt = $conexion->prepare("UPDATE dispositivos SET nombre_dispositivo = ?, tipo = ?, estado = ? WHERE cod_dispositivo = ?");
$stmt->bind_param("ssss", $nombre_dispositivo, $tipo, $estado, $cod_dispositivo);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('DISPOSITIVO ACTUALIZADO CORRECTAMENTE');
    window.location='cambio_dispositivo.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL ACTUALIZAR');
    window.location='cambio_dispositivo.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>

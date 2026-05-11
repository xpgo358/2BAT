<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$nombre_dispositivo = $_POST['nombre_dispositivo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$estado = $_POST['estado'] ?? '';

if (empty($cod_dispositivo) || empty($nombre_dispositivo) || empty($tipo) || empty($estado)) {
    echo "
    <script>
    alert('FALTAN DATOS OBLIGATORIOS');
    window.location='alta_dispositivo.html';
    </script>";
    exit();
}

$stmt = $conexion->prepare("INSERT INTO dispositivos (cod_dispositivo, nombre_dispositivo, tipo, estado) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $cod_dispositivo, $nombre_dispositivo, $tipo, $estado);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_dispositivo.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('DISPOSITIVO GUARDADO CORRECTAMENTE');
    window.location='alta_dispositivo.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
